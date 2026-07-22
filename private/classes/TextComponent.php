<?php

class TextComponent 
{

    private $pdo;

    public function __construct(PDO $pdo) {

        $this->pdo = $pdo;        

    }

    public function makeTextArea($title,$name) {

        $value = $this->getCurrentValue($name);

        $html = '<label for="' . $name . '">' . $title . 
        '</label>' . "\n";
        
        $html .= '<textarea id="' . $name . '" name="' . 
        $name . '" rows="6" maxlength=500 class="text-area" ' . 
        'placeholder="Tell other people a little about yourself...">' . 
        $value . '</textarea>' . "\n";

        echo $html;

    }

    public function makeTextField($title, $name, $plaecHolder) {

        $value = $this->getCurrentValue($name);

        $html = '<label for="' . $name . '">' . $title . '</label>' . "\n";
        $html .= '<input type="text" id="' . $name . '" name="' . 
        $name . '" class="text-component" placeholder="' . 
        $plaecHolder . '" value="' . $value . '">' . "\n";

        echo $html;

    }

    public function makeDateField($title, $name) {

        $html = '<label for="' . $name . '">' . $title . '</label>' . "\n";
        $html .= '<input type="date" id="' . $name . '" name="' . 
        $name . '" class="date-component">' . "\n";

        echo $html;

    }

    private function updateBiography(): void 
    {

        $data = $_POST['biography'] ?? NULL;
        $userId = $_SESSION['user_id'] ?? NULL;

        if (!$userId) {

            throw new Exception("No user logged in.");
        
        }
        
        $sql = "
            UPDATE ProfileDetails
            SET biography = :biography
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "biography" => $data,
            "user_id" => $userId
       
        ]);
    }

    private function updateCity(): void 
    {

        $data = $_POST['city'] ?? 'Uppsala';
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            throw new Exception("No user logged in.");
        }
        
        $sql = "
            UPDATE ProfileDetails
            SET city = :city
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "city" => $data,
            "user_id" => $userId
       
        ]);
    }

    private function updateOccupation(): void 
    {

        $data = $_POST['occupation'] ?? NULL;
        $userId = $_SESSION['user_id'] ?? NULL;

        if (!$userId) {
            throw new Exception("No user logged in.");
        }
        
        $sql = "
            UPDATE ProfileDetails
            SET occupation = :occupation
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "occupation" => $data,
            "user_id" => $userId
       
        ]);
    }

    private function updateWebsite(): void 
    {

        $data = $_POST['website'] ?? NULL;
        $userId = $_SESSION['user_id'] ?? NULL;

        if (!$userId) {
            throw new Exception("No user logged in.");
        }
        
        $sql = "
            UPDATE ProfileDetails
            SET website = :website
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "website" => $data,
            "user_id" => $userId
       
        ]);
    }

    private function updateInterests(): void 
    {

        $data = $_POST['interests'] ?? NULL;
        $userId = $_SESSION['user_id'] ?? NULL;

        if (!$userId) {
            throw new Exception("No user logged in.");
        }
        
        $sql = "
            UPDATE ProfileDetails
            SET interests = :interests
            WHERE user_id = :user_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([

            "interests" => $data,
            "user_id" => $userId
       
        ]);
    }

    public function updateBirthdate($title, $name): void
    {
    
        $birthday = $_POST['birthday'] ?? null;

        if (!empty($birthday)) {

            $result = date('Y-m-d', strtotime($birthday));

            $sql = "

                UPDATE ProfileDetails
                SET birthday = :birthday
                WHERE user_id = :user_id
            ";


            $stmt = $this->pdo->prepare($sql);


            $stmt->execute([

            "birthday" => $result,
            "user_id" => $_SESSION['user_id']

            ]);
        }
    }

    private function getCurrentValue(string $name): string
    {

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            throw new Exception("No user logged in.");
        }

        $sql = "
            SELECT $name
            FROM ProfileDetails
            WHERE user_id = :user_id
            LIMIT 1
        ";


        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "user_id" => $userId
        ]);


        return (string)($stmt->fetchColumn() ?? "");
    
    }
}

?>