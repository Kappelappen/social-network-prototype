<?php

class FormError
{

    private $pdo;
    public $formErrors;
    private $usernameFlag;

    public function __construct($pdo, $formErrors) 
    {

        $this->pdo = $pdo;
        $this->formErrors = $formErrors;

        if (isset($_POST["register"])) 
        {
            
            $this->usernameFlag = $this->usernameExists($_POST["username"]);
            $this->validateRegistration();            

        }

        if (isset($_POST["login"])) {

            $this->usernameFlag = $this->usernameExists($_POST["username"]);
            $this->validateLogin();

        }
    }

    public function initErrors() {

        if (count($this->formErrors) !== 0) {

            $this->showErrors();

        }
    }

    public function validateRegistration(): void
    {

        if ($_POST) 
        {

            if (empty($_POST["username"]))
            {

                $this->formErrors[] = "You must enter a Username";

            }


            if (empty($_POST["password"])) 
            {

                $this->formErrors[] = "You must enter a Password";

            }

            if (isset($_POST["username"]) && $this->usernameFlag) 
            {

                $this->formErrors[] = "The Username already exists";

            }

            if (strlen($_POST["password"]) < 8) 
            {

                $this->formErrors[] = "Password must contain at least 8 characters";

            }

            if (!preg_match('/[A-Z]/', $_POST["password"])) 
            {

                $this->formErrors[]= "Password must contain at least one uppercase letter";

            }

            if (!preg_match('/[a-z]/', $_POST["password"])) 
            {

                $this->formErrors[] = "Password must contain at least one lowercase letter";

            }

            if (!preg_match('/[0-9]/', $_POST["password"])) 
            {

                $this->formErrors[] = "Password must contain at least one number";

            }


            if (isset($_POST["password"]) && $_POST["password"] !== $_POST["confirmPassword"]) 
            {

                $this->formErrors[] = "The password must match the value Confirm Password"; 

            }
        }
    }

    public function validateLogin(): void
    {

        if ($_POST) 
        {

            if (empty($_POST["username"])) 
            {

                $this->formErrors[] = "You must enter a Username";

            }

            if (empty($_POST["password"])) 
            {

                $this->formErrors[] = "You must enter a Password";

            }

            if (isset($_POST["username"]) && !$this->usernameFlag) 
            {

                $this->formErrors[] = "The Username does not exist";

            }

            if (strlen($_POST["password"]) < 8) 
            {

                $this->formErrors[] = "Password must contain at least 8 characters";

            }


            if (!preg_match('/[A-Z]/', $_POST["password"])) 
            {

                $this->formErrors[] = "Password must contain at least one uppercase letter";

            }


            if (!preg_match('/[a-z]/', $_POST["password"])) 
            {

                $this->formErrors[] = "Password must contain at least one lowercase letter";

            }


            if (!preg_match('/[0-9]/', $_POST["password"])) 
            {

                $this->formErrors[] = "Password must contain at least one number";

            }
        }
    }

    public function usernameExists(string $username): bool
    {

        $sql = "
            SELECT COUNT(*)
            FROM Users
            WHERE username = :username
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "username" => $username
        ]);

        return (bool) ($stmt->fetchColumn() > 0);

    }

    public function showErrors() {

        $html = '<div class="form-message">' . "\n";
        $html .= '<ul>' . "\n";

        foreach ($this->formErrors as $error) 
        {

            $html .= '<li>'
            . htmlspecialchars($error)
            . '</li>' . "\n";

        }


        $html .= '</ul>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
        

    }

    public function getFormErrors() { return $this->formErrors; }

}

?>