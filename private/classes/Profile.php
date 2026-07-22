<?php

class Profile
{

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProfile(int $userId): array|false
    {

        $sql = "SELECT id, username,email,first_name," . 
        "last_name,created_at, last_login,profile_image  FROM Users " .
        "WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(array(

            "id" => $userId

        ));


        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}

?>