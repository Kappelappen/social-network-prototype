<?php

    require_once $path . "classes/Database.php";

    $database = new Database();
    $pdo = $database->getConnection();
    
?>