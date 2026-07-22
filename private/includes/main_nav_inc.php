
<ul class="menu">

    <li>
        <a href="<?= $index; ?>">Home </a>    
    </li>

     <li>
        <a href="<?= $pages; ?>about.php" target="_top">About</a>    
    </li>

    <li>
        <a href="<?= $pages; ?>members.php" target="_top">Members</a>    
    </li>

    <?php if ($auth->isLoggedIn()): ?>
    
    <li class="dropdown">

         <a href="<?= $pages; ?>profile.php<?php echo $auth->getPageId(); ?>" target="_top">
            My Profile ▾
        </a>

        <ul class="dropdown-menu">

            <li>
                <a href="<?= $pages; ?>edit_profile.php" target="_top">Edit Profile</a>
            </li>

            <li>
                <a href="<?= $pages; ?>account.php" target="_top">Edit Account</a>
            </li>

            <li>
                <a href="<?= $pages; ?>logout.php">Logout</a>
            </li>

        </ul>
    </li>

    <?php endif; ?>

    <?php if (!$auth->isLoggedIn()): ?>

    <li>

        <a href="<?= $pages; ?>register.php" target="_top">Register</a>

    </li>

    <li>
        <a href="<?= $pages; ?>login.php" target="_top">Login</a>
    </li>

    <?php endif; ?>

</ul>