<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup'));

  try{
    $action = $JACKED->Syrup->Action->create();
    $action->name = $_POST['inputName'];
    $action->description = $_POST['inputDescription'];
    $action->value = $_POST['inputValue'];
    $action->tag = $_POST['inputTag'];
    $action->save();
    
    $succeeded = True;
  }catch(Exception $e){
    $failed = True;
    print_r($e);
  }

  require('create-action.php');

?>