<?php
session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "grafica.php";

//per breadcrumb
//$url=explode("/", $_SERVER['REQUEST_URI']);
//$paginaCorrente= end($url);

$breadcrumb="";
if(isset($_SESSION['paginaPrecedente']))
{
    $breadcrumb=$_SESSION['paginaPrecedente'];

}

$breadcrumb.=" &gt;&gt; Percorso";


$paginaHTML=grafica::getPage("percorso.html");

$paginaHTML = str_replace("[breadcrumb]", $breadcrumb, $paginaHTML);

$_SESSION["id"]=1;
if(isset($_SESSION["id"])){

    
    

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
        $seconda_opzione = "
        <section class=\"Login\">
            <a href=\"accedi.php\" class=\"login-button\">
                Accedi <img src=\"./assets/right-from-bracket-solid.svg\" alt=\"Icona Login\" class=\"icon-login\">
            </a>
        </section>";


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


            $queryRecensioneUtente=$connessione->get_recensioni($id,$_SESSION['Username']);
            if($queryRecensioneUtente->ok())
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                <h4>".$queryRecensioneUtente->get_result()[0]['utente']."</h4>
                <p>".$queryRecensioneUtente->get_result()[0]['testo']."
                </p>
                </section>",$paginaHTML);
            }
            else if(!isset($_POST["aggiungiRecensione"]))
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                <h4>".$_SESSION['Username']."</h4>
                <form method=\"post\">
                    <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\"></textarea>
                    <select class=\"\" id=\"voto\" name=\"voto\">
                      <option value=\"5\">5</option>
                      <option value=\"4\">4</option>
                      <option value=\"3\">3</option>
                      <option value=\"2\">2</option>
                      <option value=\"1\">1</option>
                    </select>
                    <button aria-label=\"Pulsante per Inserire Recensione\" name=\"aggiungiRecensione\" type=\"submit\" class=\"button\">Inserisci Recensione</button>
                    
                </form>
                </section>",$paginaHTML);
            }
            else
            {
                $voto=$_POST["voto"];
                $testo=$_POST["testoRecensione"];
                $queryAggiungiRecensione=$connessione->aggiungi_recensione($_SESSION['Username'],$id,$voto,$testo);
                if($queryAggiungiRecensione->ok())
                {
                    unset($_POST['aggiungiRecensione']);
                    $queryRecensioneUtente=$connessione->get_recensioni($id,$_SESSION['Username']);
                    if($queryRecensioneUtente->ok())
                    {
                        $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                        <h4>".$queryRecensioneUtente->get_result()[0]['utente']."</h4>
                        <p>".$queryRecensioneUtente->get_result()[0]['testo']."
                        </p>
                        </section>",$paginaHTML);
                    }
                    else
                    {
                        $_SESSION["error"] = "Impossibile connettersi al sistema";
                    }

                }
                else
                {
                    $_SESSION["error"] = "Impossibile connettersi al sistema per aggiungere la tua recensione";
                }
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

    
    if (isset($_SESSION["error"])) {
        $paginaHTML = str_replace("[alert]", grafica::createAlert("error", $_SESSION["error"]), $paginaHTML);
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["info"])) {
        $paginaHTML = str_replace("[alert]", grafica::createAlert("info", $_SESSION["info"]), $paginaHTML);
        unset($_SESSION["info"]);
    }
    if (isset($_SESSION["success"])) {
        $paginaHTML = str_replace("[alert]", grafica::createAlert("success", $_SESSION["success"]), $paginaHTML);
        unset($_SESSION["success"]);
    } else {
        $paginaHTML = str_replace("[alert]", "", $paginaHTML);
    }
    
    echo $paginaHTML;
}
else{
    

    
}
?>