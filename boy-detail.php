<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock'));

  try{
    $JACKED->Flock->requireLogin();

  }catch(NotLoggedInException $e){
    $redirectReason = 'no-login';
    require('login.php');
    exit();
  }

  $contestantID = $_GET['boy'];
  $contestant = $JACKED->Syrup->Contestant->findOne(array('uuid' => $contestantID));
  if(!$contestant){
    header("Location: boys.php");
  }
  
  $page = 'boys';
  require('body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);
  $latestEpisode = $brain->getLatestEpisodeID();

  $total = $brain->getScoreForContestant($contestantID);
  $scores = $brain->getScoresForContestant($contestantID, 'episode');
  $alive = $contestant->alive > 0;
  $ownerships = $JACKED->Syrup->Ownership->find(array('AND' => 
    array('Contestant' => $contestantID, 'episode' => $latestEpisode)))
?>

      <?php 
        if(isset($failedToKillBoy) && $failedToKillBoy){
      ?>

      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
        <strong>Oh dip!</strong> Unable to alter Boy state
      </div>

      <?php
        }
      ?>
  
      <div class="jumbotron">
        <div class="row">
          <div class="col-md-5">
            <img class="img-responsive" src="/assets/img/boys/<?php echo $contestant->uuid; ?>.jpg" />
          </div>
          <div class="col-md-7">
            <h1><?php echo $contestant->name; ?></h1>
            <p>Total Score: <?php echo $total; ?></p>
            <p>
              <span class="glyphicon glyphicon-<?php echo $alive ? 'sunglasses' : 'trash'; ?>" aria-hidden="true"></span>
              <?php echo $alive ? 'Still alive' : 'Dead to us'; ?>
            </p>
            <p>
              <?php 
                if($alive){
              ?>
              <a class="btn btn-danger" aria-label="Kill Boy" href="alter-boy.php?action=kill&boy=<?php echo $contestant->uuid; ?>">
                <span class="glyphicon glyphicon-eject" aria-hidden="true"></span>
                Did he died?
              </a>
              <?php
                }else{
              ?>
              <a class="btn btn-warning" aria-label="Rez Boy" href="alter-boy.php?action=resurrect&boy=<?php echo $contestant->uuid; ?>">
                <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                Did you fuck up and he's definitely not dead?
              </a>
              <?php 
                }
              ?>
            </p>
          </div>
        </div>
      </div>

      <?php
        if(count($ownerships) > 0){
      ?>
          <h2>Week <?php echo $latestEpisode; ?> Owners</h2>
      <?php
          foreach($ownerships as $ownership){
            $team = $ownership->Team;
      ?>

        <div class="team-link media clickable" data-team-id="<?php echo $team->uuid; ?>">
          <div class="media-left">
            <img width="100px" class="media-object" src="<?php echo $team->avatar; ?>" >
          </div>
          <div class="media-body">
            <h1 class="media-heading"><?php echo $team->name; ?></h1>
          </div>
        </div>
      <?php
          }
        }
      ?>

      <h3>Scores</h3>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Action</th>
            <th>Episode</th>
            <th>Value</th>
            <th>Scored By</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($scores as $score){
          ?>

          <tr>
            <td><?php echo $score->Action->name; ?></td>
            <td><?php echo $score->episode; ?></td>
            <td><?php echo $score->Action->value; ?></td>
            <td><?php echo $score->Scorer->username; ?></td>
          </tr>
          <?php
            }
          ?>

        </tbody>
      </table>

<?php
  $jsFooter = '
        $(\'.team-link\').click(function(){
          document.location = \'team-detail.php?team=\' + $(this).data(\'team-id\');
        });';
  require('body_bottom.php');
?>