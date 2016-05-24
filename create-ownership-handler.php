<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Sessions'));

  try{
    $own = $JACKED->Syrup->Ownership->create();
    $own->Contestant = $_POST['inputContestant'];
    $own->Team = $_POST['inputTeam'];
    $own->episode = $_POST['inputWeek'];
    $own->save();
    
    $JACKED->Sessions->write('create-ownership.succeeded', 'true');
  }catch(Exception $e){
    $JACKED->Sessions->write('create-ownership.succeeded', 'false');
    $JACKED->Sessions->write('create-ownership.failed-reason', $e->getMessage());
  }

  header('Location: team.php');

?>