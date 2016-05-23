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

  require('Bach.php');
  $brain = new Bach($JACKED);

  $page = 'league';
  require('body_top.php');

  $ep = $brain->getCurrentEpisode();
  $teams = $brain->getTeams('rank');
?>
      <div class="jumbotron">
        <h1>WEEK <?php echo $ep->id; ?></h1>
        <p><?php echo date('l, d M Y g:i A', $ep->startTime); ?></p>
      </div>

      <h2>Team Standings</h2>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Score</th>
            <th>Owner</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $rank = 1;
            foreach($teams as $teamData){
              $team = $teamData['team'];
              $score = $teamData['score'];
          ?>

          <tr class="team-link" data-team-id="<?php echo $team->uuid; ?>">
            <td>#<php echo $rank; ?></td>
            <td><?php echo $team->name; ?></td>
            <td><?php echo $score; ?></td>
            <td><?php echo $team->Owner->username; ?></td>
          </tr>
          <?php
              $rank++;
            }
          ?>

        </tbody>
      </table>

<?php
  require('body_bottom.php');
?>