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

  $me = $JACKED->Flock->getUserSession();
  $meID = $me['userid'];
  $team = $JACKED->Syrup->Team->findOne(array('Owner' => $meID));
  if(!$team){
    $JACKED->Sessions->write('create-team.redirect-reason', 'Well this is embarrassing; you don\'t have a team. Don\'t even trip, dawg. You can make it here.');
    header("Location: create-team.php");
  }
  
  $page = 'team';
  require('body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);

  $total = $brain->getScoreForTeam($team->uuid);
  $currentWeek = $brain->getLatestEpisode();

?>
      <!-- edit team notifications-->
      <?php
          if($JACKED->Sessions->check('alter-team.succeeded') && $JACKED->Sessions->read('alter-team.succeeded') == 'false'){
      ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
        <strong>Be cool.</strong><?php echo $JACKED->Sessions->read('alter-team.failed-reason'); ?>
      </div>
      <?php
            $JACKED->Sessions->delete('alter-team.succeeded');
            $JACKED->Sessions->delete('alter-team.failed-reason');
          }
      ?>

      <?php
          if($JACKED->Sessions->check('alter-team.succeeded') && $JACKED->Sessions->read('alter-team.succeeded') == 'true'){
      ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        <strong>Nice</strong> Team saved
      </div>
      <?php
            $JACKED->Sessions->delete('alter-team.succeeded');
          }
      ?>
      <!-- /edit team notifications-->

      <!-- add boy notifications-->
      <?php
          if($JACKED->Sessions->check('create-ownership.succeeded') && $JACKED->Sessions->read('create-ownership.succeeded') == 'false'){
      ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
        <strong>Be cool.</strong> <?php echo $JACKED->Sessions->read('create-ownership.failed-reason'); ?>
      </div>
      <?php
            $JACKED->Sessions->delete('create-ownership.succeeded');
            $JACKED->Sessions->delete('create-ownership.failed-reason');
          }
      ?>

      <?php
          if($JACKED->Sessions->check('create-ownership.succeeded') && $JACKED->Sessions->read('create-ownership.succeeded') == 'true'){
      ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        <strong>Nice</strong> Boy added
      </div>
      <?php
            $JACKED->Sessions->delete('create-ownership.succeeded');
          }
      ?>
      <!-- /add boy notifications-->

      <div class="jumbotron">
        <h1><?php echo $team->name; ?></h1>
        <p>Total Score: <?php echo $total; ?></p>

        <a class="btn btn-info" aria-label="Edit Team" href="create-team.php?team=<?php echo $team->uuid; ?>">
          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          Edit Details
        </a>
      </div>

      <?php 
        $weekidx = $currentWeek->id;
        while($weekidx > 0){ 
          $week = $JACKED->Syrup->Episode->findOne(array('id' => $weekidx));
          $weekEditable = $week->id == 1 || $week->startTime > time();
          $weekOwnerships = $JACKED->Syrup->Ownership->find(array('AND' => array('Team' => $team->uuid, 'episode' => $weekidx)));
          $weekScore = $brain->getScoreForTeamByEpisode($team->uuid, $weekidx);
      ?>
      <h3>
        Week <?php echo $weekidx; ?><br />
        <small>Score: <?php echo $weekScore; ?></small>
      </h3>

      <?php
        if(count($weekOwnerships) < $week->teamSize && $weekEditable){
      ?>
          <a class="btn btn-sm btn-success" aria-label="Add Boy" href="create-ownership.php?week=<?php echo $weekidx; ?>">
            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            Add a Boy
          </a>
      <?php
        }
      ?>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Boy</th>
            <th>Week Score</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($weekOwnerships as $week){
          ?>

          <tr class="contestant-link clickable" data-contestant-id="<?php echo $week->Contestant->uuid; ?>">
            <td><?php echo $week->Contestant->name; ?></td>
            <td><?php echo $brain->getScoreForContestantByEpisode($week->Contestant->uuid, $weekidx); ?></td>
          </tr>
        <?php
            }
        ?>
        </tbody>
      </table>
        <?php
            $weekidx--;
          }
        ?>


<?php
  $jsFooter = '
        $(\'tr.contestant-link\').click(function(){
          document.location = \'boy-detail.php?boy=\' + $(this).data(\'contestant-id\');
        });';
  require('body_bottom.php');
?>