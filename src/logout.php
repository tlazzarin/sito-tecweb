<?php
    ob_start();
    session_start();
    if(isset($_SESSION["Username"]))
    {
        session_unset();
        session_destroy();
        if(!str_contains($_SERVER['HTTP_REFERER'],"profilo")&&!str_contains($_SERVER['HTTP_REFERER'],"pannelloAmministrazione"))
            header("Location: ".$_SERVER['HTTP_REFERER']);
        else
            header("Location: index.php");
        exit();
    }
?>