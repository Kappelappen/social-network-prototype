<?php

declare(strict_types=1);

require_once __DIR__ . "/private/application/engine.php";
require_once __DIR__ . "/private/includes/header_inc.php";

?>

<body>

<div class="page-header">

    <div class="page-headline">
        <?php require_once __DIR__ . "/private/includes/headline_inc.php"; ?>
    </div>


    <div class="page-menubar">
        <?php require_once __DIR__ . "/private/includes/main_nav_inc.php"; ?>
    </div>

</div>

<div class="main-view">
    <?php require_once __DIR__ . "/private/includes/index_inc.php"; ?>
</div>

<div class="page-footer">
    <?php require_once __DIR__ . "/private/includes/footer_inc.php"; ?>
</div>


</body>

</html>