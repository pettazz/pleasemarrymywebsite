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

  $total = $brain->getScoreForContestant($contestantID);
  $scores = $brain->getScoresForContestant($contestantID);
  $alive = $contestant->alive > 0;

?>
      
      <div class="jumbotron">
        <h1><?php echo $contestant->name; ?></h1>
        <p>Total Score: <?php echo $total; ?></p>
        <p>
          <span class="glyphicon glyphicon-<?php echo $alive ? 'sunglasses' : 'trash'; ?>" aria-hidden="true"></span>
          <?php echo $alive ? 'Still alive' : 'Dead to us'; ?>
        </p>
      </div>


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
  require('body_bottom.php');
?>