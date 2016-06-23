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

  $teams = $brain->getTeams('rank');
?>
      <img src="/assets/img/daniel.jpg" id="damn-daniel" class="img-responsive" />

      <h2>Team Standings</h2>
      <?php
        $rank = 1;
        foreach($teams as $teamData){
          $team = $teamData['team'];
          $score = $teamData['score'];
      ?>

        <div class="team-link media clickable" data-team-id="<?php echo $team->uuid; ?>">
          <div class="media-left">
            <h2>#<?php echo $rank; ?></h2>
          </div>
          <div class="media-left">
            <img width="100px" class="media-object" src="<?php echo $team->avatar; ?>" >
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?php echo $team->name; ?> <small><?php echo $team->Owner->username; ?></small></h4>
            <h1><?php echo $score; ?></h1>
          </div>
        </div>
      <?php
          $rank++;
        }
      ?>

<?php

  $jsFooter = '
        $(\'.team-link\').click(function(){
          document.location = \'team-detail.php?team=\' + $(this).data(\'team-id\');
        });';
  require('body_bottom.php');
?>