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
      <img src="/assets/img/header.png" class="img-responsive" />

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

          <tr class="team-link clickable" data-team-id="<?php echo $team->uuid; ?>">
            <td>#<?php echo $rank; ?></td>
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

  $jsFooter = '
        $(\'tr.team-link\').click(function(){
          document.location = \'team-detail.php?team=\' + $(this).data(\'team-id\');
        });';
  require('body_bottom.php');
?>