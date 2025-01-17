<?php
    ob_start();
    session_start();
    require_once("DB/database.php");
    
    use DB\Functions;

    $id=$_POST['id'];
    $voto=$_POST['voto'];
    $testo=$_POST['testo'];
    $connessione=new Functions();
    $checkConnection=$connessione->openConnection();
    if($checkConnection){
        $queryRecensione=$connessione->get_recensioni($id,$_SESSION['Username']);
        if($queryRecensione->ok()&&!$queryRecensione->is_empty()){
            $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);
        }
        
        
        $queryAggiungiRecensione=$connessione->aggiungi_recensione($_SESSION['Username'],$id,$voto,$testo);
            
        if($queryAggiungiRecensione->ok()){
            echo "Recensione aggiunta con successo";
        }
        else
        {
            echo "Impossibile aggiungere la recensione";
        }
        

        

        $connessione->closeConnection();
    }
    else
    {
        echo "Errore";
    }
       
?>