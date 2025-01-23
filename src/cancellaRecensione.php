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
    $response=array();
    $connessione=new Functions();
    $checkConnection=$connessione->openConnection();
    if($checkConnection){
        $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);

        if($queryCancellaRecensione->get_errno() == 0)
        {
            
            $response[0]= "Recensione cancellata con successo";
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
            else
            {
                $response[1] = 0;
            }
        }
        else
        {
            $response[0]= "Impossibile cancellare la recensione";
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