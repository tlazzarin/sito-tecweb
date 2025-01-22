<?php
    ob_start();
    session_start();
    if(!isset($_SESSION["Username"]))
        header("Location: error/401.php");
    if(!isset($_POST['id']))
        header("Location: error/404.php");
    require_once("DB/database.php");
    use DB\Functions;

    $id=$_POST["id"];
    $connessione=new Functions();
    $checkConnection=$connessione->openConnection();
    if($checkConnection){
        $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);

        if($queryCancellaRecensione->get_errno() == 0)
        {
            
            echo "Recensione cancellata con successo";
        }
        else
        {
            echo "Impossibile cancellare la recensione";
        }

        

        $connessione->closeConnection();
    }
    else
    {
        echo "Errore";
    }
        
?>