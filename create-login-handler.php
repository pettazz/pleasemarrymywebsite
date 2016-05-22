<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Flock'));

  try{
    if($JACKED->Flock->createUser($_POST['inputUsername'], $_POST['inputEmail'], $_POST['inputPassword'])){
      header("Location: index.php");
    }else{
      $failed = true;
      require('create-user.php');
      exit();
    }
  }catch(ExistingUserException $e){
    $failed = true;
    require('create-user.php');
    exit();
  }

?>