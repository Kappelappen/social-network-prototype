<?php $self = htmlspecialchars($_SERVER["PHP_SELF"]); ?>

<?php 

    $regError = $member->getRegisterErrors();
    
    $username = $member->getUserName();
    $firstName = $member->getFirstName();
    $lastName = $member->getLastName();
    $email = $member->getEmailAddress();
    $password = $member->getDefaultPassword();
    $confirmPassword = $member->getConfirmPassword();    

    if ($_POST && count($regError) !== 0)
    {

        $html = '<div class="form-message">' . "\n";
        $html .= '<ul>' . "\n";

        foreach ($regError as $item) {

            $html .= '<li>' . $item . '</li>' . "\n";

        }

        $html .= '</div>' . "\n";
        echo $html;
    
    }

?>

<h1 class="main-headline">Register</h1>

<div class="form-area">
<form name="register" method="post" action="<?php echo $self; ?>">

<div class="form-group">
<label for="username">Username</label>
<input type="text" name="username" class="text-component" value="<?php echo $username; ?>">
</div>

<div class="form-group">
<label for="email">Email-address</label>
<input type="text" name="email" class="text-component" value="<?php echo $email; ?>">
</div>

<div class="form-group">
<label for="password">Password</label>
<input type="password" name="password" class="text-component" value="<?php echo $password; ?>">
</div>

<div class="form-group">
<label for="confirm_password">Confirm Password</label>
<input type="password" name="confirm_password" class="text-component" value="<?php echo $confirmPassword; ?>">
</div>

<div class="form-group">
<label for="fname">First Name</label>
<input type="text" name="fname" class="text-component" value="<?php echo $firstName; ?>">
</div>

<div class="form-group">
<label for="lname">Last Name</label>
<input type="text" name="lname" class="text-component" value="<?php echo $lastName; ?>">
</div>

<div class="form-group">
<label for="terms">Do you accept our terms of use?
<input type="checkbox" name="terms" class="checkbox"></label>
</div>

<input type="submit" name="register" value="Register" class="save-btn">

</form>
</div>