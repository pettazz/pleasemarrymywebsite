<?php

  require('JACKED/jacked_conf.php');
  $JACKED = new JACKED(array('Syrup', 'Flock'));

  try{
    $JACKED->Flock->requireLogin();

  }catch(NotLoggedInException $e){
    $redirectReason = 'no-login';
    require('login.php');
    exit();
  }

  $page = 'scoring';
  require('body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);

  $actions = $JACKED->Syrup->Action->find(NULL, array('field' => 'tag', 'direction' => 'ASC'));
  $weeks = $JACKED->Syrup->Episode->find(NULL, array('field' => 'id', 'direction' => 'DESC'));

?>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Available Weeks</h3>
        </div>
        <div class="panel-body">
          Choose a Week to give some sweet boys some sweet points
        </div>
        <?php
          foreach($weeks as $week){
            $weekFuture = $week->startTime > time();
        ?>
        <a href="<?php echo $weekFuture ? '#' : 'create-score.php?week=' . $week->id; ?>" 
           class="list-group-item <?php echo $weekFuture ? 'disabled' : '' ?>">
          <h4 class="list-group-item-heading">Week <?php echo $week->id; ?></h4>
          <p class="list-group-item-text">
            <?php echo date('l, d M Y g:i A', $week->startTime); ?><br />
            Team size: <?php echo $week->teamSize; ?>
          </p>
        </a>
        <?php
          }
        ?>
      </div>

      <h2>Scoring Actions</h2>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Value</th>
            <th>Tag</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($actions as $action){
          ?>

          <tr class="action-link clickable" data-action-id="<?php echo $action->uuid; ?>">
            <td><?php echo $action->name; ?></td>
            <td><?php echo $action->description; ?></td>
            <td><?php echo (($action->value > 0)? '+' : '') . $action->value; ?></td>
            <td><?php echo $action->tag; ?></td>
          </tr>
          <?php
            }
          ?>

        </tbody>
      </table>

<?php

  $jsFooter = '
        $(\'tr.action-link\').click(function(){
          document.location = \'action-detail.php?action=\' + $(this).data(\'action-id\');
        });';
  require('body_bottom.php');
?>