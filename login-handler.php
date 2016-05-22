<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Flock'));

  try{
    $JACKED->Flock->login($_POST['inputUsername'], $_POST['inputPassword']);
    header("Location: index.php");
  }catch(FlockLoginException $e){
    $redirectReason = 'failed-login';
    require('login.php');
    exit();
  }

?>