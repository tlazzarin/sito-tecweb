<?php

session_start();

use DB\Functions;

require_once("DB/database.php");

$errore = false;

$username = $_POST["username"];
$password = $_POST["password"];

$connessione=new Functions();


$checkConnection=$connessione->openConnection();

if($checkConnection){
    
    $usernameCheck = (isset($username) && preg_match('/^[A-Za-z\s]\w{1,30}$/', $username));
    $passwordCheck = (isset($password) && preg_match('/^[^\s]{4,}$/', $password));

    
    if($usernameCheck && $passwordCheck)
    {
       
        $user = $connessione->registrati($username, $password);

        if($user->ok())
        {
            $connessione->closeConnection();
            $_SESSION["Username"] = $user->get_result()[0]['username'];
            $_SESSION["isAdmin"] = $user->get_result()[0]['isAdmin'];
            
            header("Location: index.php");
        } else {
            $connessione->closeConnection();
            $_SESSION["info"] = $user->get_error_message();
            header("Location: registrati.php");
        }
    }
    else {
        $connessione->closeConnection();
        $_SESSION["info"] = "Non tutti i campi sono stati inseriti correttamente";
        header("Location: registrati.php");
    }

}else {
   
    $_SESSION["error"] = "Impossibile connettersi al sistema";
    header("Location: registrati.php");
}
