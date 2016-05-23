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

  $page = 'team';

  require('body_top.php');
?>

      <table class="table table-striped">

      </table>

<?php
  require('body_bottom.php');
?>