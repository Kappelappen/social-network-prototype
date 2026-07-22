<?php

$self = htmlspecialchars($_SERVER["PHP_SELF"]);
$errors = $account->getErrors();

?>

<?php if (count($errors) > 0): ?>

<div class="form-message">

    <ul>

        <?php foreach ($errors as $error): ?>

            <li><?= htmlspecialchars($error) ?></li>

        <?php endforeach; ?>

    </ul>
</div>

<?php endif; ?>

<h2 class="main-headline">Edit your account information</h2>

<div class="form-area">
<form method="post" action="<?= $self ?>" enctype="multipart/form-data">

    <div class="form-group">

        <label>Username</label>
        <input type="text" name="username" class="text-component" value="<?= $account->getUsername() ?>">

    </div>

    <div class="form-group">

        <label>Email</label>
        <input type="text" name="email" class="text-component" value="<?= $account->getEmail() ?>">

    </div>

    <div class="form-group">

        <label>First name</label>
        <input type="text" name="fname" class="text-component" value="<?= $account->getFirstName() ?>">

    </div>


    <div class="form-group">

        <label>Last name</label>
        <input type="text" name="lname" class="text-component" value="<?= $account->getLastName() ?>">

    </div>

    <div class="form-group">

        <label>Password</label>
        <input type="password" name="password" class="text-component" value="<?= $account->getPassword() ?>">

    </div>

    <div class="form-group">

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" class="text-component" value="<?= $account->getConfirmPassword() ?>">

    </div>

    <div class="form-group">

        <label for="profile_image">Choose profile picture</label>
        
        <input type="file" id="profile_image" name="profile_image"
        accept="image/jpeg,image/png,image/webp" class="browser">

    </div>


    <div class="form-group">

        <?php 


        if (isset($_POST["visibility"])) {
                    
            $select->updateVisibility();
                
        }            

        $select->makeSelectMenu(
        $select->getCurrentVisibility(),
        $select->getVisibilityOptions(),
        "Profile visibility",
        "visibility");


        ?>

    </div>

    <div class="account-actions">

        <input type="submit" name="account" value="Save" class="save-btn">

    </div>


    <div class="danger-zone">

        <h3>
            Danger Zone
        </h3>

        <p>
            Permanently delete your account and all associated data.
        </p>

        <input type="submit" name="delete" value="Delete Account" class="delete-btn">

    </div>

</form>
</div>