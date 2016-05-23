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
?>
      <div class="jumbotron">
        <h1>WEEK <?php echo $ep->id; ?></h1>
        <p><?php echo date('l, d M Y g:i A', $ep->startTime); ?></p>
      </div>

      <h2>League Standings</h2>

      <table class="table table-striped">

      </table>

<?php
  require('body_bottom.php');
?>