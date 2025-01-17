<?php
session_start();

if(!isset($_SESSION["Username"]))
    header("Location: error/401.php");
else if($_SESSION["isAdmin"]!=true)
    header("Location: error/403.php");

$paginaHTML = file_get_contents("pannelloAmministrazione.html");
$paginaHTML = str_replace("[username]", $_SESSION["Username"], $paginaHTML);
echo $paginaHTML;
?>