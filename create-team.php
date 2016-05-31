<?php
  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock'));

  require('form_body_top.php');
  
  $existingTeam = isset($_GET['team']) ? $_GET['team'] : False;
  if($existingTeam){
    $team = $JACKED->Syrup->Team->findOne(array('uuid' => $existingTeam));
  }
?>

      <form class="form-signin" action="create-team-handler.php" method="POST">
        <h2 class="form-signin-heading"><?php echo $existingTeam? 'Edit' : 'Create'; ?> team</h2>
        <?php
            if($JACKED->Sessions->check('alter-team.succeeded') && $JACKED->Sessions->read('alter-team.succeeded') == 'false'){
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
          <strong>Oh dip!</strong> Bad news bears: <?php echo $JACKED->Sessions->read('alter-team.failed-reason'); ?>
        </div>
        <?php
              $JACKED->Sessions->delete('alter-team.succeeded');
              $JACKED->Sessions->delete('alter-team.failed-reason');
            }
        ?>

        <?php
            if($JACKED->Sessions->check('create-team.redirect-reason')){
        ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          <strong>C'mon</strong> <?php echo $JACKED->Sessions->read('create-team.redirect-reason'); ?>
        </div>
        <?php
              $JACKED->Sessions->delete('create-team.redirect-reason');
            }
        ?>

        <label for="inputName" class="sr-only">Team Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Name" required autofocus value="<?php echo $existingTeam? $team->name : ''; ?>">

        <label for="inputAvatar" class="sr-only">Team Icon</label>
        <input type="text" id="inputAvatar" name="inputAvatar" class="form-control" placeholder="Icon URL" autofocus value="<?php echo $existingTeam? $team->avatar : ''; ?>">

        <?php
          if($existingTeam){
        ?>

        <input type="hidden" name="inputTeam" value="<?php echo $team->uuid; ?>" />

        <?php
          }
        ?>
          
        <input type="hidden" name="inputAction" value="<?php echo $existingTeam? 'edit' : 'create'; ?>" />

        <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
      </form>

<?php
  require('body_bottom.php');
?>