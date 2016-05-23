<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup'));

  try{
    $action = $JACKED->Syrup->Contestant->create();
    $action->name = $_POST['inputName'];
    $action->save();
    
    $succeeded = True;
  }catch(Exception $e){
    $failed = True;
    print_r($e);
  }

  require('create-contestant.php');

?>