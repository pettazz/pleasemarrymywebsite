<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock', 'Sessions'));

  try{
    $me = $JACKED->Flock->getUserSession();

    $score = $JACKED->Syrup->Score->create();
    $score->Contestant = $_POST['inputContestant'];
    $score->Action = $_POST['inputAction'];
    $score->episode = $_POST['inputEpisode'];
    $score->Scorer = $me['userid'];
    $score->save();
    
    $JACKED->Sessions->write('create-score.succeeded', True);
  }catch(Exception $e){
    $JACKED->Sessions->write('create-score.succeeded', False);
    $JACKED->Sessions->write('create-score.failed-reason', $e->getMessage());
  }

  header('Location: create-score.php?week=' . $_POST['inputEpisode']);

?>