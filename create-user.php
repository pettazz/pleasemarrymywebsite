<?php
  require('form_body_top.php');
?>

      <form class="form-signin" action="create-user-handler.php" method="POST">
        <h2 class="form-signin-heading">Create user</h2>
        <?php
            if(isset($failed) && $failed){
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Oh dip!</strong> Couldn't create a user with those details.
        </div>
        <?php
            }
        ?>

        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
      </form>

<?php
  require('form_body_bottom.php');
?>