<?php

class Settings
{
    private PDO $pdo;

    private array $errors = [];

    private string $username = "";
    private string $email = "";
    private string $fname = "";
    private string $lname = "";

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $this->readForm();
            $this->validate();

            if (count($this->errors) === 0) {

                $this->success();

            }
        }
    }


    private function readForm(): void
    {
        $this->username = trim(strip_tags($_POST["username"] ?? ""));
        $this->email = trim(strip_tags($_POST["email"] ?? ""));
        $this->fname = trim(strip_tags($_POST["fname"] ?? ""));
        $this->lname = trim(strip_tags($_POST["lname"] ?? ""));
    }


    private function validate(): void
    {

        if ($this->username === "") {

            $this->errors[] = "Username is required.";

        }


        if ($this->email === "") {

            $this->errors[] = "Email is required.";

        }

    }


    private function success(): void
    {
        // Spara till databasen här senare.
    }


    public function getErrors(): array
    {
        return $this->errors;
    }


    public function getUsername(): string
    {
        return htmlspecialchars($this->username);
    }


    public function getEmail(): string
    {
        return htmlspecialchars($this->email);
    }


    public function getFirstName(): string
    {
        return htmlspecialchars($this->fname);
    }


    public function getLastName(): string
    {
        return htmlspecialchars($this->lname);
    }
}