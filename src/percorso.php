<?php
session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "grafica.php";

$paginaHTML=grafica::getPage("percorso.html");
$_SESSION["id"]=1;
if(isset($_SESSION["id"])){

    //per breadcrumb
    $url=explode("/", $_SERVER['REQUEST_URI']);
    $paginaCorrente= end($url);



    

    if(isset($_SESSION['Username'])){
        if(!isset($_SESSION['isAdmin']))
        {
            $prima_opzione="<a href=\"pannelloAmministrazione.php\">Pannello Amministrazione</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
        else{
            $prima_opzione="<a href=\"profilo.php\">Profilo</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
       
    }
    else
    {
        $prima_opzione="<a href=\"registrati.php\">Registrati</a>";
        $seconda_opzione="<a href=\"accedi.php\">Accedi</a>";
    }

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
            $filegpx="./assets/gpx/".strtolower($percorso[0]['file_gpx']);
            

            
        }

        $Immagini="";
        $navImmagini="";
        $countimg=0;
        $stringId=strval($id)."%";

        $queryImg=$connessione->get_immagini($stringId);

        if($queryImg->ok() && !$queryImg->is_empty())
        {
            foreach($queryImg->get_result() as $immagine){
                $countimg++;
                $Immagini.="<img src=\"./assets/img/percorsi/".$immagine['id_immagine']."\" 
                            alt=\"".$immagine['alt']."\" 
                            id=\"slide".$countimg."\">";
                $navImmagini.="<a href=\"#slide".$countimg."\"></a>";
            }
            
        }

        

        if(!isset($_SESSION['Username'])){
            $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\"><p>Fai <a href=\"accedi.php\">login</a> per scrivere la tua Recensione!</p></section>",$paginaHTML);
             
        }else{
            if(isset($_POST['aggiungiRecensione']))
            {
                
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

        $connessione->closeConnection();
    }

    

    $paginaHTML = str_replace("[titolo]", $titolo, $paginaHTML);
    $paginaHTML = str_replace("[descrizione]", $descrizione, $paginaHTML);
    $paginaHTML = str_replace("[indicazioni]", $indicazioni, $paginaHTML);
    $paginaHTML = str_replace("[sottotitolo]", $sottotitolo, $paginaHTML);
    $paginaHTML = str_replace("[recensioni]",$Recensioni,$paginaHTML);
    $paginaHTML =str_replace("[file_gpx]",$filegpx,$paginaHTML);
    $paginaHTML =str_replace("[immagini]",$Immagini,$paginaHTML);
    $paginaHTML =str_replace("[nav_immagini]",$navImmagini,$paginaHTML);
    $paginaHTML =str_replace("[prima_opzione]",$prima_opzione,$paginaHTML);
    $paginaHTML =str_replace("[seconda_opzione]",$seconda_opzione,$paginaHTML);

    
    
    
    echo $paginaHTML;
}
else{
    

    
}
?>