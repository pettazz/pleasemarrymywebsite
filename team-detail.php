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

  $teamID = $_GET['team'];
  $team = $JACKED->Syrup->Team->findOne(array('uuid' => $teamID));
  if(!$team){
    header("Location: league.php");
  }
  
  $page = 'league';
  require('body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);

  $total = $brain->getScoreForTeam($teamID);
  $currentWeek = $brain->getCurrentEpisode();

?>
      
      <div class="jumbotron">
        <h1><?php echo $team->name; ?></h1>
        <p>Total Score: <?php echo $total; ?></p>
      </div>


      <h3>Weeks</h3>

      <?php 
        $weekidx = $currentWeek->id;
        while($weekidx > 0){ 
          $weekOwnerships = $JACKED->Syrup->Ownership->find(array('AND' => array('Team' => $team->uuid, 'episode' => $weekidx)));
          $weekScore = $brain->getScoreForTeamByEpisode($team->uuid, $weekidx);
      ?>
      <h4>
        Week <?php echo $weekidx; ?><br />
        Score: <?php echo $weekScore; ?>
      </h4>
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