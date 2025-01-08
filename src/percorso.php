<?php

session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "grafica.php";

$paginaHTML=grafica::getPage("percorso.html");

$caratteristiche_array=array("bambini"=>"<abbr title=\"Adatto ai bambini\">Bambini</abbr>",
"escursionisti"=>"<abbr title=\"Adatto solo ad utenti esperti\">Escursionisti</abbr>",
"ipovedente_cieco"=>"<abbr title=\"Adatto alle persone ipovedenti / cieche\">Persone cieche</abbr>",
"mobilita_ridotta"=>"<abbr title=\"Adatto alle persone con mobilità ridotta\">Persone con bastone</abbr>",
"passeggini"=>"<abbr title=\"Adatto ai passeggini\">Passeggini</abbr>",
"sedia_a_rotelle"=>"<abbr title=\"Adatto alle sedie a rotelle\">Sedie a rotelle</abbr>",
"dislivello_salita"=>"<abbr title=\"Dislivello in salita\">Freccia in su</abbr>",
"dislivello_discesa"=>"<abbr title=\"Dislivello in discesa\">Freccia in giù </abbr>",
"lunghezza"=>"<abbr title=\"Lunghezza del percorso\">Percorso</abbr>"); 


if(isset($_GET["id"])){

    
    

    if(isset($_SESSION['Username'])){
        if(!isset($_SESSION['isAdmin']))
        {
            $prima_opzione="<a aria-label=\"Vai alla pagina del pannello Amministrazione\" href=\"pannelloAmministrazione.php\">Pannello Amministrazione</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
        else{
            $prima_opzione="<a aria-label=\"Vai alla tua pagina personale\" href=\"profilo.php\">Profilo</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
       
    }
    else
    {
        $prima_opzione="<a href=\"registrati.php\">Registrati</a>";
        $seconda_opzione = "
        <section class=\"accedi\">
            <a href=\"accedi.php\" class=\"accedi-button\">
                Accedi <img src=\"./assets/right-from-bracket-solid.svg\" alt=\"Icona accedi\" class=\"icon-accedi\">
            </a>
        </section>";


    }

    $id=$_GET["id"];
    
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
            $keyword=$percorso[0]['tag_keywords'];
            $tagdescrizione=$percorso[0]['tag_description'];
            $tagtitolo=$percorso[0]['tag_title'];
            $filegpx="./assets/gpx/".strtolower($percorso[0]['file_gpx']);
            $peso=round(filesize($filegpx)*pow(10,-6),2,PHP_ROUND_HALF_UP);

            $descrizione.="<br>".$caratteristiche_array['dislivello_salita']." ".$percorso[0]['dislivello_salita']."m   ".$caratteristiche_array['dislivello_discesa']." ".$percorso[0]['dislivello_discesa']."m  ".$caratteristiche_array['lunghezza']." ".$percorso[0]['lunghezza']."km  ";
            
        }

        $queryCaratteristiche=$connessione->get_caratteristiche($id);
        $Caratteristiche="<p>Accesibile a: ";
        if($queryCaratteristiche->ok() && !$queryCaratteristiche->is_empty())
        {
            foreach($queryCaratteristiche->get_result() as $caratteristica)
            {
                $Caratteristiche.=$caratteristiche_array[$caratteristica['caratteristica']]." ";
            }

            $Caratteristiche.="</p>";

            
        }

        $Immagini="";
        $stringId=strval($id)."%";

        $queryImg=$connessione->get_immagini($stringId);

        if($queryImg->ok() && !$queryImg->is_empty())
        {
            foreach($queryImg->get_result() as $immagine){
                $Immagini.="<img src=\"./assets/img/percorsi/".$immagine['id_immagine']."\" 
                            alt=\"".$immagine['alt']."\" 
                            class=\"slide\">";
            }
            
        }

        

        if(!isset($_SESSION['Username'])){
            $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\"><p>Fai <a href=\"accedi.php\">accedi</a> per scrivere la tua Recensione!</p></section>",$paginaHTML);
             
        }else{
            if(isset($_POST["annulla"]))
            {
                $_POST['aggiungiRecensione']=true;
                $voto=$_POST['voto'];
                $testo=$_POST['testoRecensione'];
                unset($_POST["annulla"]);

            }
            if(isset($_POST["cancellaRecensione"]))
            {
                $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);
                if($queryCancellaRecensione->get_errno() == 0)
                    unset($_POST["cancellaRecensione"]);
                else
                    $_SESSION["error"] = "Impossibile connettersi al sistema per cancellare la tua recensione";
            }   
                



            $queryRecensioneUtente=$connessione->get_recensioni($id,$_SESSION['Username']);
            if($queryRecensioneUtente->ok()&&!isset($_POST["modificaRecensione"]))
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                        <h4>".$queryRecensioneUtente->get_result()[0]['utente']."</h4>
                        <p>".$queryRecensioneUtente->get_result()[0]['testo']."
                        <br>Voto: ".$queryRecensioneUtente->get_result()[0]['voto']."
                        </p>
                        <form method=\"post\">
                            <button aria-label=\"Pulsante per Modificare la Recensione\" name=\"modificaRecensione\" type=\"submit\" class=\"button\">Modifica Recensione</button>
                            <button aria-label=\"Pulsante per Cancellare la Recensione\" name=\"cancellaRecensione\" type=\"submit\" class=\"button\">Cancella Recensione</button>
                        </form>
                        </section>",$paginaHTML);
            }
            else if(!isset($_POST["aggiungiRecensione"]))
            {
                if(!isset($_POST["modificaRecensione"]))
                {
                    $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                    <h4>".$_SESSION['Username']."</h4>
                    <form  method=\"post\">
                        <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\"></textarea>
                        <select aria-label=\"Scelta Multipla per il voto della recensione\" class=\"\" id=\"voto\" name=\"voto\">
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

                    $tempTest=$queryRecensioneUtente->get_result()[0]['testo'];
                    $tempVoto=$queryRecensioneUtente->get_result()[0]['voto'];
                    $queryCancellaRecensione=$connessione->cancella_recensione($id,$_SESSION['Username']);
                    
                    if($queryCancellaRecensione->get_errno() == 0)
                    {
                        $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                        <h4>".$_SESSION['Username']."</h4>
                        <form method=\"post\">
                            <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\">".$tempTest."</textarea>
                            <select aria-label=\"Scelta Multipla per il voto della recensione\" class=\"\" id=\"voto\" name=\"voto\" value=\"".$tempVoto."\">
                              <option value=\"5\">5</option>
                              <option value=\"4\">4</option>
                              <option value=\"3\">3</option>
                              <option value=\"2\">2</option>
                              <option value=\"1\">1</option>
                            </select>
                            <button aria-label=\"Pulsante per Inserire Recensione\" name=\"aggiungiRecensione\" type=\"submit\" class=\"button\">Inserisci Recensione</button>
                            <button aria-label=\"Pulsante per tornare indietro e non modificare la recensione\" name=\"annulla\" type=\"submit\" a class=\"button\">Annulla</button>
                        </form>
                        </section>",$paginaHTML);
                    }
                    else
                    {
                        $_SESSION["error"] = "Impossibile connettersi al sistema per modificare la tua recensione";
                        $paginaHTML=str_replace("[miaRecensione]"," <section class=\"recensione\">
                        <h4>".$_SESSION["Username"]."</h4>
                        <p>".$tempTest."
                        <br>Voto: ".$tempVoto."
                        </p>
                        <form method=\"post\">
                        <button aria-label=\"Pulsante per Modificare Recensione\" name=\"modificaRecensione\" type=\"submit\" class=\"button\">Modifica Recensione</button>
                        <button aria-label=\"Pulsante per Cancellare la Recensione\" name=\"cancellaRecensione\" type=\"submit\" class=\"button\">Cancella Recensione</button>
                        </form>
                        </section>",$paginaHTML);
                    }
                    
                    
                    

                }
                
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
                        <br>Voto: ".$queryRecensioneUtente->get_result()[0]['voto']."
                        <form method=\"post\">
                            <button aria-label=\"Pulsante per Modificare Recensione\" name=\"modificaRecensione\" type=\"submit\" class=\"button\">Modifica Recensione</button>
                            <button aria-label=\"Pulsante per Cancellare la Recensione\" name=\"cancellaRecensione\" type=\"submit\" class=\"button\">Cancella Recensione</button>
                        </form>
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
        $votoMedio=0;
        if($queryRecensioni->ok()){
            
            
            foreach($queryRecensioni->get_result() as $recensione){
                if(!isset($_SESSION["Username"])||$recensione['utente']!=$_SESSION["Username"])
                {
                    $Recensioni.="<section class=\"recensione\">
                    <h4>".$recensione['utente']."</h4>
                    <p>".$recensione['testo']."
                    <br>Voto: ".$recensione['voto']."</p>
                    </section>";
                    
                }
                $votoMedio+=$recensione['voto'];
            }
            $votoMedio=round($votoMedio/$queryRecensioni->get_element_count(),1,PHP_ROUND_HALF_UP);
            
        }

        $connessione->closeConnection();
    }
    else
    {
        $_SESSION["error"] = "Impossibile connettersi al sistema";
    }

    
    $paginaHTML = str_replace("[tag_titolo]", $tagtitolo, $paginaHTML);
    $paginaHTML = str_replace("[tag_keyword]", $keyword, $paginaHTML);
    $paginaHTML = str_replace("[tag_descrizione]", $tagdescrizione, $paginaHTML);
    $paginaHTML = str_replace("[titolo]", $titolo, $paginaHTML);
    $paginaHTML = str_replace("[descrizione]", $descrizione, $paginaHTML);
    $paginaHTML = str_replace("[caratteristiche]", $Caratteristiche, $paginaHTML);
    $paginaHTML = str_replace("[indicazioni]", $indicazioni, $paginaHTML);
    $paginaHTML = str_replace("[sottotitolo]", $sottotitolo, $paginaHTML);
    $paginaHTML = str_replace("[recensioni]",$Recensioni,$paginaHTML);
    $paginaHTML =str_replace("[file_gpx]",$filegpx,$paginaHTML);
    $paginaHTML =str_replace("[immagini]",$Immagini,$paginaHTML);
    $paginaHTML =str_replace("[prima_opzione]",$prima_opzione,$paginaHTML);
    $paginaHTML =str_replace("[seconda_opzione]",$seconda_opzione,$paginaHTML);
    $paginaHTML =str_replace("[peso]",$peso,$paginaHTML);
    $paginaHTML =str_replace("[media_voti]",$votoMedio,$paginaHTML);
    

    
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
    
    header('Location: percorsi.php');
    
}
?>