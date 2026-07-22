<?php

class Database {

    private $connection;

    public function __construct() {

        $this->connection = new PDO(
            "mysql:host=localhost;dbname=soulroom;charset=utf8mb4",
            "root","kappe1980"
        );

        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }


    public function getConnection() {

        return $this->connection;
    
    }
}