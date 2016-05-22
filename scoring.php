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

  $page = 'scoring';

  require('body_top.php');
?>

      <h2>Scoring</h2>

<?php
  require('body_bottom.php');
?>