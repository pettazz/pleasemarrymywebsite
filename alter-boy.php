<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup'));

  try{
    $boyID = $_GET['boy'];
    $contestant = $JACKED->Syrup->Contestant->findOne(array('uuid' => $boyID));
    $contestant->alive = $_GET['action'] == 'resurrect' ? 1 : 0;
    $contestant->save();
    
    $succeeded = True;
  }catch(Exception $e){
    $failedToKillBoy = True;
    print_r($e);
  }

  header('Location: boy-detail.php?boy=' . $boyID);

?>