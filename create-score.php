<?php
  require_once('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock'));

  require('form_body_top.php');

  $week = $_GET['week'];
  $boys = $JACKED->Syrup->Contestant->find(array('alive' => 1), array('field' => 'name', 'direction' => 'ASC'));
  $actions = $JACKED->Syrup->Action->find(NULL, array('field' => 'name', 'direction' => 'ASC'));
  $actionGroups = array(
    'ACTION' => array(),
    'CONVERSATION' => array(),
    'FUCKERY' => array(),
    'NEGATIVE' => array(),
    'HOMETOWNS' => array(),
    'FANTASY_SUITE' => array(),
    'FINALE' => array()
  );
  foreach($actions as $action){
    $actionGroups[$action->tag][] = $action;
  }
?>

      <form class="form-signin" action="create-score-handler.php" method="POST">
        <h2 class="form-signin-heading">Add Score</h2>
        <?php
            if($JACKED->Sessions->check('create-score.succeeded') && $JACKED->Sessions->read('create-score.succeeded') == 'false'){
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
          <strong>Oh dip!</strong> Bad news bears: <?php echo $JACKED->Sessions->read('create-score.failed-reason'); ?>
        </div>
        <?php
              $JACKED->Sessions->delete('create-score.succeeded');
              $JACKED->Sessions->delete('create-score.failed-reason');
            }
        ?>
        <?php
            if($JACKED->Sessions->check('create-score.succeeded') && $JACKED->Sessions->read('create-score.succeeded') == 'true'){
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
          <strong>Nice</strong> A boy has received his points
        </div>
        <?php
              $JACKED->Sessions->delete('create-score.succeeded');
            }
        ?>

        <label for="inputEpisode" class="">When it do?</label>
        <select id="inputEpisode" class="form-control input-lg" readonly name="inputEpisode">
          <option value="<?php echo $week; ?>">Week <?php echo $week; ?></option>
        </select>

        <label for="inputContestant" class="">Who chyaboi?</label>
        <select id="inputContestant" class="form-control input-lg" name="inputContestant">
          <option disabled selected value></option>
          <?php
            foreach($boys as $boy){
          ?>
            <option value="<?php echo $boy->uuid; ?>"><?php echo $boy->name ?></option>
          <?php
            }
          ?>
        </select>

        <label for="inputAction" class="">O shit what he done now?</label>
        <select id="inputAction" class="form-control input-lg" name="inputAction" required>
          <optgroup><option disabled selected value></option></optgroup>
          <?php
            foreach($actionGroups as $tagName => $actionGroup){
          ?>
            <optgroup label="<?php echo $tagName; ?>">
            <?php
              foreach($actionGroup as $action){
            ?>
              <option value="<?php echo $action->uuid; ?>" data-description="<?php echo htmlentities($action->description); ?>" data-value="<?php echo $action->value; ?>"><?php echo $action->name ?></option>
          <?php
              }
            echo '
            </opgroup>';
            }
          ?>
        </select>
        <span id="scoreDescription" class="help-block"></span>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
        <a class="btn btn-lg btn-warning btn-block" href="scoring.php">Done Scoring</a>
      </form>

      <script type="text/css">
        
      </script>

<?php
  $jsFooter = "var updateDescriptionHelp = function(){
          var desc = $(this).find('option:selected').data('description');
          if(!desc || desc.length === 0){
            desc = '<span class=\"text-muted\">no description</span>'
          }
          $('#scoreDescription').html('<p><strong>' + $(this).find('option:selected').data('value') + ' points:</strong> ' + desc + '</p>');
        };
        $('#inputAction').change(updateDescriptionHelp);";
  require('body_bottom.php');
?>