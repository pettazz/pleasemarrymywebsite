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

  $page = 'boys';
  require('body_top.php');

  require('Bach.php');
  $brain = new Bach($JACKED);

  $contestants = $brain->getContestants('rank');

?>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Score</th>
            <th>Alive</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($contestants as $contestantData){
              $contestant = $contestantData['contestant'];
              $score = $contestantData['score'];
          ?>

          <tr class="contestant-link clickable" data-contestant-id="<?php echo $contestant->uuid; ?>">
            <td><?php echo $contestant->name; ?></td>
            <td><?php echo $score; ?></td>
            <td><?php echo ($contestant->alive > 0)? 'YUP' : 'NAW'; ?></td>
          </tr>
          <?php
            }
          ?>

        </tbody>
      </table>

<?php

  $jsFooter = '
        $(\'tr.contestant-link\').click(function(){
          document.location = \'boy-detail.php?boy=\' + $(this).data(\'contestant-id\');
        });';
  require('body_bottom.php');
?>