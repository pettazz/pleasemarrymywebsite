<?php
  require('form_body_top.php');
?>

      <form class="form-signin" action="create-contestant-handler.php" method="POST">
        <h2 class="form-signin-heading">Create boy</h2>
        <?php
            if(isset($failed) && $failed){
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Oh dip!</strong> Couldn't create a boy with those details.
        </div>
        <?php
            }
        ?>
        <?php
            if(isset($succeeded) && $succeeded){
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Nice</strong> Created boy successfully.
        </div>
        <?php
            }
        ?>

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Name" required autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
      </form>

<?php
  require('body_bottom.php');
?>