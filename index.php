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

  $page = 'league';

  require('body_top.php');
?>

      <h2>League Standings</h2>

      <table class="table table-striped">

      </table>

<?php
  require('body_bottom.php');
?>