<?php
ob_start();
session_start();
if(!isset($_SESSION["Username"]))
    header("Location: error/401.php");
if($_SESSION["isAdmin"]==1)
    header("Location: index.php");

$paginaHtml = file_get_contents("profilo.html");

$paginaHtml = str_replace("[username]", $_SESSION["Username"], $paginaHtml);
echo $paginaHtml;

?>