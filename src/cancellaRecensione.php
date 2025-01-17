<?php
    ob_start();
    session_start();
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
        $connessione->closeConnection();
        header("Location:./error/500.html");
    }
        
?>