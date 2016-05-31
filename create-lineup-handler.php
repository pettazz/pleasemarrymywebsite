<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Sessions'));
  require('Bach.php');
  $brain = new Bach($JACKED);

  try{
    $thisWeek = $brain->getLatestEpisode();
    $lastWeek = $thisWeek->id - 1;
    $inheritedOwnerships = $JACKED->Syrup->Ownership->find(array('AND' => array('Contestant.alive' => 1, 'Team' => $_GET['team'], 'episode' => $lastWeek)));

    foreach($inheritedOwnerships as $inherited){
      $own = $JACKED->Syrup->Ownership->create();
      $own->Contestant = $inherited->Contestant;
      $own->Team = $inherited->Team;
      $own->episode = $thisWeek->id;
      $own->save();
    }
    
    $JACKED->Sessions->write('create-lineup.succeeded', 'true');
  }catch(Exception $e){
    $JACKED->Sessions->write('create-lineup.succeeded', 'false');
    $JACKED->Sessions->write('create-lineup.failed-reason', $e->getMessage());
  }

  header('Location: team.php');

?>