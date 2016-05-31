<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Sessions'));

  try{
    // please dont bobby tables me
    if(!$JACKED->MySQL->delete('Ownership', "episode = " . $_GET['week'] . " AND Team = '" . $_GET['team'] . "'")){
      throw new Exception('Unable to delete existing Ownerships');
    }

    $JACKED->Sessions->write('lineup-redraft-enabled', 'true');
    $JACKED->Sessions->write('delete-lineup.succeeded', 'true');
  }catch(Exception $e){
    $JACKED->Sessions->write('delete-lineup.succeeded', 'false');
    $JACKED->Sessions->write('delete-lineup.failed-reason', $e->getMessage());
  }

  header('Location: team.php');

?>