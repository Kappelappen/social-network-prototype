<?php

declare(strict_types=1);


require_once __DIR__ . "/private/classes/Database.php";
require_once __DIR__ . "/private/classes/DatabaseInstaller.php";


try {

    $database = new Database();
    $pdo = $database->getConnection();
    $installer = new DatabaseInstaller($pdo);
    $installed = $installer->installTables();

    if ($installed) {

        echo "
            <h1>Database installed</h1>
            <p>The database tables have been created successfully.</p>
        ";

    } else {

        echo "
            <h1>Database already exists</h1>
            <p>No installation was needed.</p>
        ";

    }

} catch (Throwable $e) {


    echo "
        <h1>Installation failed</h1>

        <p>"
        . htmlspecialchars(
            $e->getMessage(),
            ENT_QUOTES,
            "UTF-8"
        )
        . "</p>
    ";

}

?>