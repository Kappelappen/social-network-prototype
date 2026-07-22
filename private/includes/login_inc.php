<?php $self = htmlspecialchars($_SERVER["PHP_SELF"]); ?>

<?php 

    $regError = $member->getLoginErrors();
    
    $username = $member->getUserName();
    $password = $member->getDefaultPassword();    

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

<h1 class="main-headline">Login</h1>

<div class="login-container">

    <div class="login-card">

        <p class="subtitle">Sign in to your account</p>

        <form name="login" method="post" action="<?= $self ?>">

            <div class="form-group">

                <label for="username">Username</label>

                <input 
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    autocomplete="username"
                    class="login-field">

            </div>

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    class="login-field">

            </div>

            <input type="submit" name="login" class="login-button" value="Login">

        </form>

        <div class="register-link">
            Don't have an account?

            <a href="register.php">
                Create account
            </a>

        </div>

    </div>
</div>