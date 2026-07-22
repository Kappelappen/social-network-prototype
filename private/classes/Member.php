<?php

    class Member 
    {
        private $pdo;
        public $error;
        public $login;
        public $register;
        
        public function __construct($pdo)
        {

            $this->pdo = $pdo;

            $this->error = [];
            $this->login = [];
            $this->register = [];
            
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                
                if (isset($_POST["login"])) {

                    $this->validateLogin();

                    if (count($this->login) == 0) {

                        $this->doLoginUser();

                    }
                }

                if (isset($_POST["register"])) {
            
                    $this->validateRegistration();

                    if (count($this->register) === 0) {

                        $this->doRegisterUser();

                    }
                }
            }
        }

        private function validateLogin()
        {

            if ($_POST && empty($_POST["username"])) 
            {

                $this->login[] = "The value Username must not be empty";

            }

            if ($_POST && empty($_POST["password"])) 
            {

                $this->login[] = "You must enter a Password";

            }

            if ($_POST && strlen($_POST["password"]) < 8) 
            {

                $this->login[] = "Password must contain at least 8 characters";

            }

            if ($_POST && !preg_match('/[A-Z]/', $_POST["password"])) 
            {

                $this->login[] = "Password must contain at least one uppercase letter";

            }

            if ($_POST && !preg_match('/[a-z]/', $_POST["password"])) 
            {

                $this->login[] = "Password must contain at least one lowercase letter";

            }

            if ($_POST && !preg_match('/[0-9]/', $_POST["password"])) 
            {

                $this->login[] = "Password must contain at least one number";

            }
        }

        private function validateRegistration() 
        {

            if ($_POST && empty($_POST["username"])) 
            {

                $this->register[] = "The value Username must not be empty";

            }

            if ($_POST && empty($_POST["email"])) 
            {

                $this->register[] = "The value Email-address must not be empty";

            }

            if ($_POST && empty($_POST["password"])) 
            {

                $this->register[] = "You must enter a Password";

            }

            if ($_POST && strlen($_POST["password"]) < 8) 
            {

                $this->register[] = "Password must contain at least 8 characters";

            }

            if ($_POST && !preg_match('/[A-Z]/', $_POST["password"])) 
            {

                $this->register[] = "Password must contain at least one uppercase letter";

            }

            if ($_POST && !preg_match('/[a-z]/', $_POST["password"])) 
            {

                $this->register[] = "Password must contain at least one lowercase letter";

            }

            if ($_POST && !preg_match('/[0-9]/', $_POST["password"])) 
            {

                $this->register[] = "Password must contain at least one number";

            }


            if ($_POST && isset($_POST["password"]) && $_POST["password"] !== $_POST["confirm_password"]) 
            {

                $this->register[] = "The password must match the value Confirm Password"; 

            }
        }

        public function getUsername() 
        {

            $username = isset($_POST["username"]) ? 
            stripslashes(strip_tags($_POST["username"])) : NULL;
            return $username;

        }

        public function getFirstName() 
        {

            $firstName = isset($_POST["fname"]) ? 
            stripslashes(strip_tags($_POST["fname"])) : NULL;
            return $firstName;

        }

        public function getLastName() 
        {

            $lastName = isset($_POST["lname"]) ? 
            stripslashes(strip_tags($_POST["lname"])) : NULL;
            return $lastName;

        }

        public function getEmailAddress() 
        {

            $email = isset($_POST["email"]) ? 
            stripslashes(strip_tags($_POST["email"])) : NULL;
            return $email;

        }

        public function getDefaultPassword() 
        {

            $password = isset($_POST["password"]) ? 
            stripslashes(strip_tags($_POST["password"])) : NULL;
            return $password;

        }

        public function getConfirmPassword() 
        {

            $password = isset($_POST["confirm_password"]) ? 
            stripslashes(strip_tags($_POST["confirm_password"])) : NULL;
            return $password;

        }       

        private function doLoginUser()
        {

            $username = stripslashes(strip_tags($_POST["username"]));         
            $password = $_POST["password"];

            $this->login($username,$password);

        }

        private function doRegisterUser() 
        {

            require_once ("member.php");            

            $username = stripslashes(strip_tags($_POST["username"]));
            $fname = stripslashes(strip_tags($_POST["fname"]));
            $lname = stripslashes(strip_tags($_POST["lname"]));
            $email = stripslashes(strip_tags($_POST["email"]));
            $password = $_POST["password"];
            $terms = isset($_POST["terms"]) ? TRUE : FALSE;

            $passwordHash = password_hash(
            $password,PASSWORD_DEFAULT);
            
            $list = array("username" => 
            $username,"first_name" => $fname,
            "last_name" => $lname,
            "email" => $email,
            "password_hash" => $passwordHash,
            "terms" => $terms ? 1 : 0);

            $sql = "INSERT INTO Users (username,email,password_hash," . 
            "first_name,last_name,terms) VALUES (:username,:email," . 
            ":password_hash,:first_name,:last_name,:terms)";

            $stmt = $this->pdo->prepare($sql);
            $success = $stmt->execute($list);

            if ($success) {                
                
                $this->login($username, $password);

            }            
        }

        public function login(
        string $username,
        string $password): bool
        {

            $sql = "
                SELECT *
                FROM Users
                WHERE username = :username
                LIMIT 1
            ";


            $stmt = $this->pdo->prepare($sql);

            $stmt->execute(array(

                "username" => $username

            ));

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {

                return false;

            }

            if (!password_verify($password, $user["password_hash"])) 
            {

                return false;

            }


            if (password_verify($password, $user["password_hash"])) 
            {

                $sql = "UPDATE Users " . 
                "SET last_login = NOW() " . 
                "WHERE id = :id";

                $stmt = $this->pdo->prepare($sql);

                $stmt->execute(array(

                    "id" => $user["id"]

                ));

                $this->initSession($user);
                
            }   

            return true;

        }

        private function initSession(array $user): void
        {

            if (session_status() === PHP_SESSION_NONE) {

                session_start();

            }

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["logged_in"] = true;

            header("Location: ../pages/profile.php");
            exit;

        }

        public function getRegisterErrors() { return $this->register; }
        public function getLoginErrors() { return $this->login; }

    }
?>