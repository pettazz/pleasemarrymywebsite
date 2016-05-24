<?php
  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock', 'Sessions'));

  require('form_body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);

  $contestants = $brain->getAvailableContestantsForEpisode($_GET['week']);

  $me = $JACKED->Flock->getUserSession();
  $meID = $me['userid'];
  $myTeam = $JACKED->Syrup->Team->findOne(array('Owner' => $meID));
?>

      <form class="form-signin" action="create-ownership-handler.php" method="POST">
        <h2 class="form-signin-heading">Claim a boy</h2>
        
        <label for="inputContestant" class="">Available Boys for week <?php echo $_GET['week']; ?></label>
        <select id="inputContestant" class="form-control input-lg" name="inputContestant">
          <option disabled selected value></option>
          <?php
            foreach($contestants as $contestant){
              $existingOwnership = $JACKED->Syrup->Ownership->find(array('AND' => array(
                'Team' => $myTeam->uuid,
                'Contestant' => $contestant->uuid,
                'episode' => $_GET['week']
              )));
              if(count($existingOwnership) == 0){
          ?>
            <option value="<?php echo $contestant->uuid; ?>"><?php echo $contestant->name ?></option>
          <?php
              }
            }
          ?>
        </select>
          
        <input type="hidden" name="inputWeek" value="<?php echo $_GET['week']; ?>" />
        <input type="hidden" name="inputTeam" value="<?php echo $myTeam->uuid ?>" />

        <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
      </form>

<?php
  require('body_bottom.php');
?>