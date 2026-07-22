
<?php 


    if (empty($_SERVER["QUERY_STRING"]) && 
        $_SERVER["SCRIPT_NAME"] === "/soulroom/index.php") {

        $welcomeText = $doc->getPage("welcome");
        echo $welcomeText;


    }


?>