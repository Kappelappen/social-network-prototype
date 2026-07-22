<?php

class DatabaseInstaller
{
    private PDO $pdo;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function installTables(): bool
    {

        if ($this->isInstalled()) {

            return false;

        }


        $this->readFromFile(
            "resources/sql/general/create.sql"
        );


        $this->readFromFile(
            "resources/sql/general/insert.sql"
        );


        return true;
    }

    private function isInstalled(): bool
    {

        return $this->tableExists("Users");

    }
    
    private function readFromFile(string $filePath): void
    {

        if (!file_exists($filePath)) {

            throw new Exception(
                "SQL file missing: " . $filePath
            );

        }


        $sql = file_get_contents($filePath);


        if ($sql === false) {

            throw new Exception(
                "Could not read SQL file"
            );

        }



        $this->pdo->exec($sql);

    }

    private function tableExists(string $tableName): bool
    {

        $sql = "

            SELECT COUNT(*)
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
            AND table_name = :table

        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "table" => $tableName

        ]);

        return (int)$stmt->fetchColumn() > 0;

    }
}

?>