<?php

class Auth
{

    public $userId;

    public function __construct()
    {

        $this->userId = isset($_SESSION["user_id"]) ? 
        intval($_SESSION["user_id"]) : NULL;

    }

    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function isLoggedIn(): bool
    {
        
        $login = isset($_SESSION["user_id"]) ? TRUE : FALSE;
        return $login;

    }

    public function logout(): void
    {
        session_destroy();
    }

    public function getPageId(): string 
    {

        $id = NULL;

        if (empty($_GET["id"])) {

            $id = '?id=' . $this->userId;

        }

        if (isset($_SESSION["user_id"])) {

            $id = '?id=' . $_SESSION["user_id"];


        }

        return $id;

    }

    public function getUserId(): int
    {
        
        return isset($this->user_id) ? $this->userId : 0;

    }
}