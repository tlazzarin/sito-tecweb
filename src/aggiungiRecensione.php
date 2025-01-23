<?php
    ob_start();
    session_start();
    if(!isset($_SESSION["Username"]))
        header("Location: error/401.php");
    if(!isset($_POST['id']) || !isset($_POST['voto'])|| !isset($_POST['testo']))
        header("Location: error/404.php");
    require_once("DB/database.php");
    
    use DB\Functions;

    $id=$_POST['id'];
    $voto=$_POST['voto'];
    $testo=$_POST['testo'];
    $response=array();
    $connessione=new Functions();
    $checkConnection=$connessione->openConnection();
    if($checkConnection){
        $queryRecensione=$connessione->get_recensioni($id,$_SESSION['Username']);
        if($queryRecensione->ok()){
            $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);
        }
        
        
        $queryAggiungiRecensione=$connessione->aggiungi_recensione($_SESSION['Username'],$id,$voto,$testo);
            
        if($queryAggiungiRecensione->ok()){
            $response[0] = "Recensione aggiunta con successo";
            $votoMedio=0;
            $queryMediaVoti=$connessione->get_recensioni($id);
            if($queryMediaVoti->ok())
            {
                foreach($queryMediaVoti->get_result() as $recensione){
                    $votoMedio+=$recensione['voto'];
                }
                $votoMedio=round($votoMedio/$queryMediaVoti->get_element_count(),1,PHP_ROUND_HALF_UP);

                
                $response[1] = $votoMedio;
            }
        }
        else
        {
            $response[0]= "Impossibile aggiungere la recensione";
        }
        
        echo json_encode($response);

        

        $connessione->closeConnection();
    }
    else
    {
        $response[0]= "Errore";
        echo json_encode($response);
    }
       
?>