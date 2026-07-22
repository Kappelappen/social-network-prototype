<?php

$self = htmlspecialchars($_SERVER["PHP_SELF"]);
$errors = $settings->getErrors();

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


<div class="form-area">

<form method="post" action="<?= $self ?>">

    <div class="form-group">

        <label>Username</label>
        <input type="text" name="username"
        value="<?= $settings->getUsername() ?>">

    </div>

    <div class="form-group">

        <label>Email</label>

        <input type="text" name="email"
        value="<?= $settings->getEmail() ?>">

    </div>


    <div class="form-group">

        <label>First name</label>

        <input type="text" name="fname"
        value="<?= $settings->getFirstName() ?>">

    </div>


    <div class="form-group">

        <label>Last name</label>
        <input type="text" name="lname" value="<?= $settings->getLastName() ?>">

    </div>

    <input type="submit" name="settings" value="Save">

</form>

</div>