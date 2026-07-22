<?php

class DatabaseManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        
        $this->pdo->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->install();

    }

    public function install(): bool
    {

        if ($this->isInstalled()) {

            return false;
        }


        $this->createDatabaseTables();
        $this->markAsInstalled();

        return true;

    }

    private function isInstalled(): bool
    {

        $sql = "
            SELECT COUNT(*)
            FROM information_schema.tables
            WHERE table_schema = DATABASE()
            AND table_name = 'SystemSettings'
        ";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchColumn() > 0;

    }

    private function createDatabaseTables(): void
    {
        $this->readFromFile(
            "resources/sql/general/create.sql"
        );

        //$this->readFromFile(
        // "resources/sql/general/insert.sql"
        //);

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

    private function markAsInstalled(): void
    {

        $sql = "
            CREATE TABLE IF NOT EXISTS SystemSettings
            (
                id INT AUTO_INCREMENT PRIMARY KEY,

                installed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        $this->pdo->exec($sql);

        $this->pdo->exec(
            "
            INSERT INTO SystemSettings
            VALUES ()
            "
        );

    }

}

?>