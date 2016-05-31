<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock', 'Sessions'));

  try{
    switch($_POST['inputAction']){
      case 'edit':
        $teamID = $_POST['inputTeam'];
        $team = $JACKED->Syrup->Team->findOne(array('uuid' => $teamID));
        break;
      case 'create':
      default:
        $me = $JACKED->Flock->getUserSession();
        $meID = $me['userid'];

        $checkExistingTeam = $JACKED->Syrup->Team->findOne(array('Owner' => $meID));
        if($checkExistingTeam){
          throw new Exception('You already have a team!');
        }

        $team = $JACKED->Syrup->Team->create();
        $team->Owner = $meID;
    }
    $team->name = $_POST['inputName'];
    $team->avatar = isset($_POST['inputAvatar'])? $_POST['inputAvatar'] : 'NULL';
    $team->save();
    
    $JACKED->Sessions->write('alter-team.succeeded', 'true');
  }catch(Exception $e){
    $JACKED->Sessions->write('alter-team.succeeded', 'false');
    $JACKED->Sessions->write('alter-team.failed-reason', $e->getMessage());
  }

  header('Location: team.php');

?>