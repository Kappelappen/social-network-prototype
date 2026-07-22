<?php

$base = basename($_SERVER["PHP_SELF"]);

$classes = ($base === "index.php") 
    ? "private/classes/" 
    : "../private/classes/";

$app = ($base === "index.php") 
    ? "private/application/" 
    : "../private/application/";

$style = ($base === "index.php") 
    ? "resources/css/" 
    : "../resources/css/";

$index = ($base !== "index.php") 
    ? "../index.php" 
    : "index.php";

$pages = ($base === "index.php") 
    ? "pages/" 
    : "../pages/";

$flag = ($base === "index.php");

$path = ($flag) 
    ? "pages/" 
    : "../";

require_once $classes . "Auth.php";

$auth = new Auth();
$auth->startSession();

require_once $classes . "Database.php";

$database = new Database();
$pdo = $database->getConnection();

require_once $classes . "DatabaseManager.php";
require_once $classes . "DocReader.php";
require_once $classes . "SelectMenu.php";
require_once $classes . "TextComponent.php";
require_once $classes . "PageHandler.php";
require_once $classes . "ProfileManager.php";
require_once $classes . "Account.php";
require_once $classes . "Member.php";
require_once $classes . "ProfileDetails.php";
require_once $classes . "UserComments.php";
require_once $classes . "Dashboard.php";

new DatabaseManager($pdo);
$doc = new DocReader();
$select = new SelectMenu($pdo);
$text = new TextComponent($pdo);
$comments = new UserComments($pdo);
$member = new Member($pdo);
$account = new Account($pdo);
$profile = new ProfileManager($pdo);
$details = new ProfileDetails($pdo);
$dashboard = new Dashboard($pdo);


?>