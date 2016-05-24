<?php
  require('form_body_top.php');
?>

      <form class="form-signin" action="create-action-handler.php" method="POST">
        <h2 class="form-signin-heading">Create action</h2>
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
        <?php
            if(isset($succeeded) && $succeeded){
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Nice</strong> Created Action successfully.
        </div>
        <?php
            }
        ?>

        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" name="inputName" class="form-control" placeholder="Name" required autofocus>

        <label for="inputDescription" class="sr-only">Description</label>
        <input type="text" id="inputDescription" name="inputDescription" class="form-control" placeholder="Description">

        <label for="inputValue" class="sr-only">Value</label>
        <input type="text" id="inputValue" name="inputValue" class="form-control" placeholder="Value" required>

        <label for="inputTag" class="">Tag</label>
        <select id="inputTag" class="form-control input-lg" name="inputTag">
          <option value="ACTION">ACTION</option>
          <option value="CONVERSATION">CONVERSATION</option>
          <option value="FUCKERY">FUCKERY</option>
          <option value="NEGATIVE">NEGATIVE</option>
          <option value="HOMETOWNS">HOMETOWNS</option>
          <option value="FANTASY_SUITE">FANTASY_SUITE</option>
          <option value="FINALE">FINALE</option>
        </select>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
      </form>

<?php
  require('form_body_bottom.php');
?>