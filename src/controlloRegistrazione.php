<?php

session_start();

use DB\Functions;

require_once("DB/database.php");

$errore = false;

$username = $_POST["username"];
#$email = $_POST["email"];
$password = $_POST["password"];

$connessione=new Functions();


$checkConnection=$connessione->openConnection();

if($checkConnection){
    
    $usernameCheck = (isset($username) && preg_match('/^[A-Za-z\s]\w{2,30}$/', $username));
    #$emailCheck = (isset($email) && filter_var($email,FILTER_VALIDATE_EMAIL));
    //$passwordCheck = (isset($password) && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$.,-;:<>!%*?&_=])[A-Za-z\d@$.,-;:<>!%*?&_=]{8,16}/', $password));
    $passwordCheck = (isset($password) && strlen($password)>=4);

    
    if($usernameCheck && $passwordCheck)
    {
       
        $user = $connessione->registrati($username, $password);

        if($user->ok())
        {
            $connessione->closeConnection();
            $_SESSION["Username"] = $user->get_result()[0]['username'];
            #$_SESSION["Email"] = $user->get_result()[0]['email'];
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
