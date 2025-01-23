<?php
session_start();
if(!isset($_SESSION["Username"]))
    header("Location: error/401.php");
if($_SESSION["isAdmin"]!=1)
    header("Location: error/403.php");
if(!isset($_GET["user"]) || isset($_GET["percorso"]))
    header("Location: error/404.php");
require_once("DB/database.php");
use DB\Functions;


$connessione=new Functions();
if(!$connessione->openConnection())
    header("Location: error/500.php");
try{
    $query = $connessione->cancella_recensione($_GET["percorso"], $_GET["user"]);
    $connessione->closeConnection();
}catch(Exception $e){
    header("Location: error/500.html");
}

header("Location: pannelloAmministrazione.php");
?>