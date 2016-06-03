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
      <h2><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Alive Boys</h2>

      <ul id="boys" class="clearfix">
        <?php
          foreach($contestants as $contestantData){
            $contestant = $contestantData['contestant'];
            if($contestant->alive > 0){
              $score = $contestantData['score'];
        ?>

        <li class="boy contestant-link clickable" data-contestant-id="<?php echo $contestant->uuid; ?>">
          <img class="img-responsive img-circle" src="/assets/img/boys/<?php echo $contestant->uuid; ?>" />
          <h3><?php echo $contestant->name; ?></h3>
          <h1><?php echo $score; ?></h1>
        </li>

        <?php
            }
          }
        ?>

      </ul>

      <h2><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> Dead Boys</h2>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($contestants as $contestantData){
              $contestant = $contestantData['contestant'];
              if($contestant->alive == 0){
                $score = $contestantData['score'];
          ?>

          <tr class="contestant-link clickable" data-contestant-id="<?php echo $contestant->uuid; ?>">
            <td><?php echo $contestant->name; ?></td>
            <td><?php echo $score; ?></td>
          </tr>
          <?php
              }
            }
          ?>

        </tbody>
      </table>

<?php

  $jsFooter = '
        $(\'.contestant-link\').click(function(){
          document.location = \'boy-detail.php?boy=\' + $(this).data(\'contestant-id\');
        });';
  require('body_bottom.php');
?>