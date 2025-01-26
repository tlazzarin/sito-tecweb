<?php
ob_start();
session_start();

use DB\Functions;

require_once("DB/database.php");

$errore = false;

$username = strip_tags($_POST["username"]);
$password = $_POST["password"];

$connessione=new Functions();


$checkConnection=$connessione->openConnection();

if($checkConnection){
    
    $usernameCheck = (isset($username) && preg_match('/^[A-Za-z\s]\w{1,30}$/', $username));
    $passwordCheck = (isset($password) && preg_match('/^[^\s]{4,}$/', $password));

    
    if( $usernameCheck && $passwordCheck)
    {
       
        $user = $connessione->accedi($username, $password);

        if($user->ok())
        {
            $connessione->closeConnection();
            $_SESSION["Username"] = $user->get_result()[0]['username'];
            $_SESSION["isAdmin"] = $user->get_result()[0]['isAdmin'];
            
            if(isset($_SESSION['paginaPrecedente']))//caso in cui si provenga da una pagina percorso
            {
                header("Location: ".$_SESSION['paginaPrecedente']);
            }
            else//caso in cui non sia in una pagina percorso quindi direzionato in pagina profilo
            {
                if($_SESSION["isAdmin"]!=true)//controllo se utente e' amministratore o no per direzionarlo nella pagina "profilo" corretta
                {
                    header("Location: profilo.php");
                }
                else
                {
                    header("Location: pannelloAmministrazione.php");
                }
            }

        } else {
            $connessione->closeConnection();
            $_SESSION["info"] = $user->get_error_message();
            header("Location: accedi.php");
        }
    }
    else {
        $connessione->closeConnection();
        $_SESSION["info"] = "Non tutti i campi sono stati inseriti correttamente";
        header("Location: accedi.php");
    }

}else {
   
    header("Location: ./error/500.html");
}
