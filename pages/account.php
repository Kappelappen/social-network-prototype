<?php

declare(strict_types=1);

require_once "../private/application/engine.php";
require_once "../private/application/secret.php";

?>

<?php require_once ("../private/includes/header_inc.php"); ?>

<body>

<div class="page-headline">
<?php require_once ("../private/includes/headline_inc.php"); ?>
</div>

<div class="page-menubar">
<?php require_once ("../private/includes/main_nav_inc.php"); ?>
</div>

<div class="main-view">
<?php require_once ("../private/includes/account_inc.php"); ?>
</div>

<div class="page-footer">
<?php require_once ("../private/includes/footer_inc.php"); ?>
</div>

</body>
</html>