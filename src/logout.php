<?php
    ob_start();
    session_start();
    if(isset($_SESSION["Username"]))
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
?>