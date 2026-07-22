<?php

class Account
{
    private PDO $pdo;

    private array $errors = [];

    private string $username = "";
    private string $email = "";
    private string $fname = "";
    private string $lname = "";
    private string $password = "";
    private string $confirmPassword = "";
    private string $profileVisibility = "";

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (isset($_POST["account"])) {

                $this->readForm();
                $this->validate();

                if (count($this->errors) === 0) {

                    $this->doUpdateAccount();
                    header("Location: ../pages/account.php");
                    exit;

                }
            }

            if (isset($_POST["delete"])) {

                $this->deleteUserAccount();

            }
        }
    }

    private function readForm(): void
    {
        
        $this->username = trim(strip_tags($_POST["username"] ?? ""));
        $this->email = trim(strip_tags($_POST["email"] ?? ""));
        $this->fname = trim(strip_tags($_POST["fname"] ?? ""));
        $this->lname = trim(strip_tags($_POST["lname"] ?? ""));

        $this->password = $_POST["password"] ?? "";
        $this->confirmPassword = $_POST["confirm_password"] ?? "";
        $this->profileVisibility = $_POST["visibility"] ?? "";

    }

    private function validate(): void
    {

        if ($this->username === "") {

            $this->errors[] = "Username is required.";

        }

        if ($this->email === "") {

            $this->errors[] = "Email is required.";

        }
    
        if ($this->password !== "") {


            if (strlen($this->password) < 8) {

                $this->errors[] =
                "Password must contain at least 8 characters.";

            }


            if (!preg_match('/[A-Z]/', $this->password)) {

                $this->errors[] =
                "Password must contain at least one uppercase letter.";

            }


            if (!preg_match('/[a-z]/', $this->password)) {

                $this->errors[] =
                "Password must contain at least one lowercase letter.";

            }


            if (!preg_match('/[0-9]/', $this->password)) {

                $this->errors[] =
                "Password must contain at least one number.";

            }


            if ($this->password !== $this->confirmPassword) {

                $this->errors[] =
                "Password confirmation does not match.";

            }
        }
    }

    public function deleteUserAccount(): void
    {

        $userId = isset($_SESSION["user_id"]) ? 
        intval($_SESSION["user_id"]) : NULL;

        $sql = "
        
            DELETE FROM Users
            WHERE id = :id
        
        ";

        if ($userId === NULL) return;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["id" => $userId ]);
        
        unset($_SESSION["user_id"]);
        session_destroy();

        header("Location: ../pages/register.php");
        exit;

    }

    private function doUpdateAccount(): void
    {

        $username = $this->getUsername();
        $email = $this->getEmail();
        $fname = $this->getFirstName();
        $lname = $this->getLastName();
        $password = $this->getPassword();
        $visibility = $this->getProfileVisibility();

        $stmt = $this->pdo->prepare("

            SELECT profile_image
            FROM ProfileImage
            WHERE user_id = :user_id
            LIMIT 1

        ");

        $stmt->execute([

            "user_id" => $_SESSION["user_id"]

        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imageName = $row ? $row["profile_image"] : null;

        if (isset($_FILES["profile_image"]) &&
            $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK) 
        
        {

            require_once "ImageWorker.php";

            $worker = new ImageWorker(

                $this->pdo,

                "../uploads/profile/"

            );

            $imageName = $worker->processImage(

                $_FILES["profile_image"]["tmp_name"],
                126,126,$_SESSION["user_id"]

            );
        }

        $stmt = $this->pdo->prepare("

            UPDATE Users
            SET
            username = :username,
            email = :email,
            first_name = :first_name,
            last_name = :last_name,
            profile_visibility = :visibility,
            password_hash = :password_hash
            WHERE id = :user_id

        ");

        $stmt->execute([

            "username" => $username,
            "email" => $email,
            "first_name" => $fname,
            "last_name" => $lname,
            "visibility" => $visibility,
            "password_hash" => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),

            "user_id" => $_SESSION["user_id"]

        ]);

        $stmt = $this->pdo->prepare("

            UPDATE ProfileImage SET
            profile_image = :profile_image
            WHERE user_id = :user_id

        ");

        $stmt->execute([

            "profile_image" => $imageName,
            "user_id" => $_SESSION["user_id"]

        ]);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function grabBySession($param): string 
    {

        $userId = isset($_SESSION["user_id"]) ? 
        intval($_SESSION["user_id"]) : 1;
        
        $sql = "SELECT * FROM Users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

            $stmt->execute([

                "id" => $userId

            ]            
        );

        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($info) {

            return $info[$param];
        
        }

        return "";

    }

    private function grabById(string $param): string
    {
    
        $id = isset($_GET["id"])
            ? (int) $_GET["id"]
            : (int) $_SESSION["user_id"];

        $sql = "SELECT * FROM Users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "id" => $id
        ]);

        $info = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$info) {
            return "public";
        }

        return isset($info[$param])
            ? (string) $info[$param]
            : "public";
    }

    public function getUsername(): string
    {        
        
        $value = (isset($_POST["account"])) ? $this->username : $this->grabBySession("username");
        return $value;
    
    }

    public function getEmail(): string
    {

        $value = (isset($_POST["account"])) ? $this->email : $this->grabBySession("email");
        return $value;

    }

    public function getFirstName(): string
    {

        $value = (isset($_POST["account"])) ? $this->fname : $this->grabBySession("first_name");
        return $value;

    }

    public function getLastName(): string
    {

        $value = (isset($_POST["account"])) ? $this->lname : $this->grabBySession("last_name");
        return $value;

    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function getProfileVisibility(): string 
    {

        $value = (isset($_POST["account"])) ? $this->profileVisibility :
        $this->grabById("profile_visibility");
        
        return $value;

    }

}

?>