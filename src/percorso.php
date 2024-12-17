<?php
session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "grafica.php";

$paginaHTML=grafica::getPage("percorso.html");
$_SESSION["id"]=1;
if(isset($_SESSION["id"])){

    

    $id=$_SESSION["id"];
    
    $errore=false;
    $connessione=new Functions();
    $checkConnection=$connessione->openConnection();

    if($checkConnection){

        

        $queryId=$connessione->get_percorso($id);

        if($queryId->ok() && !$queryId->is_empty())
        {
            $percorso=$queryId->get_result();

            $sottotitolo=$percorso[0]['sottotitolo'];
            $titolo=$percorso[0]['titolo'];
            $descrizione=$percorso[0]['descrizione'];
            $indicazioni=$percorso[0]['indicazioni'];
            $filegpx="/src/assets/gpx/".strtolower($percorso[0]['file_gpx']);

            
        }

        if(!isset($_SESSION['Username'])){
            $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\"><p>Fai <a href=\"accedi.php\">login</a> per scrivere la tua Recensione!</p></section>",$paginaHTML);
             
        }else{
            if(isset($_POST['aggiungiRecensione']))
            {
                echo "ciao";
                //per test
                $voto=4;
                $testo=$_POST["testoRecensione"];
                $queryAggiungiRecensione=$connessione->aggiungi_recensione($_SESSION['Username'],$id,$voto,$testo);
                if($queryAggiungiRecensione->ok())
                {
                    unset($_SESSION['aggiungiRecensione']);
                }
            }
            
            $queryRecensioneUtente=$connessione->get_recensioni($id,$_SESSION['Username']);
            if($queryRecensioneUtente->ok()){
                
                $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                    <h4>".$queryRecensioneUtente->get_result()[0]['utente']."</h4>
                    <p>".$queryRecensioneUtente->get_result()[0]['testo']."
                    </p>
                    </section>",$paginaHTML);
                $_SESSION['aggiungiRecensione']=true;
            }
            else if(!isset($_SESSION['aggiungiRecensione']))
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                    <h4>".$_SESSION['Username']."</h4>
                    <form method=\"post\">
                        <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\"></textarea>
                        <button aria-label=\"Pulsante per Inserire Recensione\" name=\"aggiungiRecensione\" type=\"submit\" class=\"button\">Inserisci Recensione</button>
                    </form>
                    </section>",$paginaHTML);
            }
            


            
        }
        

        $queryRecensioni=$connessione->get_recensioni($id);


        $Recensioni="";
        
        if($queryRecensioni->ok()){
            
            
            foreach($queryRecensioni->get_result() as $recensione){
                
                $Recensioni.="<section class=\"recensione\">
                <h4>".$recensione['utente']."</h4>
                <p>".$recensione['testo']."
                </p>
                </section>";
            }

        }
    }

    

    $paginaHTML = str_replace("[titolo]", $titolo, $paginaHTML);
    $paginaHTML = str_replace("[descrizione]", $descrizione, $paginaHTML);
    $paginaHTML = str_replace("[indicazioni]", $indicazioni, $paginaHTML);
    $paginaHTML = str_replace("[sottotitolo]", $sottotitolo, $paginaHTML);
    $paginaHTML = str_replace("[recensioni]",$Recensioni,$paginaHTML);
    $paginaHTML =str_replace("[file_gpx]",$filegpx,$paginaHTML);

    
    
    echo $paginaHTML;
}
else{
    

    
}
?>