<?php
ob_start();
session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "generate_navbar.php";

$paginaHTML=file_get_contents("percorso.html");

$caratteristiche_array=array(
    "bambini"=>"<abbr title=\"Adatto ai bambini\" class=\"abbr-icon\">Bambini</abbr>",
    "escursionisti"=>"<abbr title=\"Adatto solo ad utenti esperti\" class=\"abbr-icon\">Escursionisti</abbr>",
    "ipovedente_cieco"=>"<abbr title=\"Adatto alle persone ipovedenti / cieche\" class=\"abbr-icon\">Persone cieche</abbr>",
    "mobilita_ridotta"=>"<abbr title=\"Adatto alle persone con mobilità ridotta\" class=\"abbr-icon\">Persone con bastone</abbr>",
    "passeggini"=>"<abbr title=\"Adatto ai passeggini\" class=\"abbr-icon\">Passeggini</abbr>",
    "sedia_a_rotelle"=>"<abbr title=\"Adatto alle sedie a rotelle\" class=\"abbr-icon\">Sedie a rotelle</abbr>",
    "dislivello_salita"=>"<abbr title=\"Dislivello in salita\" class=\"abbr-icon\">Freccia in su</abbr>",
    "dislivello_discesa"=>"<abbr title=\"Dislivello in discesa\" class=\"abbr-icon\">Freccia in giù </abbr>",
    "lunghezza"=>"<abbr title=\"Lunghezza del percorso\" class=\"abbr-icon\">Percorso</abbr>"
); 


if(!isset($_GET["id"]))
    header('Location: percorsi.php');
$tasti_navbar = generateNavbar($_SESSION);

$id=$_GET["id"];

$connessione=new Functions();
$checkConnection=$connessione->openConnection();

if($checkConnection){
    $queryId=$connessione->get_percorso($id);
    if($queryId->ok())//informazioni del percorso
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
        $peso=round(filesize(filename: $filegpx)*pow(10,-6),2,PHP_ROUND_HALF_UP);
        $mappa_embed=$percorso[0]['map_embed'];
        $statistiche=$caratteristiche_array['dislivello_salita']." ".$percorso[0]['dislivello_salita']."<abbr title=\"metri\">m</abbr>   ".$caratteristiche_array['dislivello_discesa']." ".$percorso[0]['dislivello_discesa']."<abbr title=\"metri\">m</abbr>  ".$caratteristiche_array['lunghezza']." ".$percorso[0]['lunghezza']."<abbr title=\"chilometri\">km</abbr>  ";
    }
    else
    {
        header("Location: ./error/404.php");
    }
    $queryCaratteristiche=$connessione->get_caratteristiche($id);
    $Caratteristiche="Accessibile a: ";
    if($queryCaratteristiche->ok())//aggiunta delle caratteristiche del percroso usando l'array di abbr creato sopra
    {
        foreach($queryCaratteristiche->get_result() as $caratteristica)
        {
            $Caratteristiche.=$caratteristiche_array[$caratteristica['caratteristica']]." ";
        }
    }

    $Immagini="";
    $stringId=strval($id)."%";

    $queryImg=$connessione->get_immagini($stringId);

    if($queryImg->ok())//inserimento immagini del percorso
    {
        foreach($queryImg->get_result() as $immagine){
            $Immagini.="<img src=\"./assets/img/percorsi/".$immagine['id_immagine']."\" 
                        alt=\"".$immagine['alt']."\" 
                        class=\"slide\">";
        }
        
    }

    if(!isset($_SESSION['Username'])){//controllo che l'utente sia loggato
        $paginaHTML=str_replace("[miaRecensione]"," <section id=\"recensioneUtente\" class=\"recensione\"><p><a href=\"accedi.php\">Accedi</a> per scrivere la tua Recensione!</p></section>",$paginaHTML);
            
    }else{

        $queryRecensioneUtente=$connessione->get_recensioni($id,$_SESSION['Username']);
        if($queryRecensioneUtente->get_errno()==0)
        {
            if($queryRecensioneUtente->ok())//controllo se utente ha una recensione scritta in questo percorso
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section id=\"recensioneUtente\" class=\"recensione\">
                    <h5>La tua Recensione</h5>
                    <noscript>Abilita <span lang=\"en\">Javascript</span> per poter interagire con la tua recensione.</noscript>
                    <p>Testo della recensione:</p>
                    <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\" aria-label=\"Zona dove inserire il testo della propria recensione, non può essere lasciata vuota\" disabled>".$queryRecensioneUtente->get_result()[0]['testo']."</textarea>
                    <p name=\"voto\" class=\"valutazione-".$queryRecensioneUtente->get_result()[0]['voto']."\">Voto: ".$queryRecensioneUtente->get_result()[0]['voto']." su 5</p>


                    <button name=\"modificaRecensione\" type=\"button\" id=\"modifica\" aria-label=\"Modifica recensione\"><img src=\"./assets/pen-to-square-solid.svg\" alt=\"Modifica\"></button>
                    <button name=\"cancellaRecensione\" type=\"button\" id=\"elimina\" aria-label=\"Elimina recensione\"><img src=\"./assets/trash-solid.svg\" alt=\"Elimina\"></button>

                    </section>",$paginaHTML);
            }
            else
            {
                $paginaHTML=str_replace("[miaRecensione]"," <section id=\"recensioneUtente\" class=\"recensione\">
                    <h5>La tua Recensione</h5>
                    <noscript>Abilita <span lang=\"en\">Javascript</span> per poter interagire con la tua recensione.</noscript>
                    <p>Testo della recensione:</p>
                    <textarea name=\"testoRecensione\" class=\"inputRecensione\" type=\"text\" aria-label=\"Zona dove inserire il testo della propria recensione, non può essere lasciata vuota\"></textarea>
                    <p id=\"testoOption\">Inserire una valutazione da 1 a 5:</p>
                    <select aria-label=\"Scelta Multipla per il voto della recensione\" id=\"voto\" name=\"voto\">
                        <option value=\"5\">5</option>
                        <option value=\"4\">4</option>
                        <option value=\"3\">3</option>
                        <option value=\"2\">2</option>
                        <option value=\"1\">1</option>
                    </select>
                    <button id=aggiungi name=\"aggiungiRecensione\" type=\"button\" class=\"button\">Inserisci</button>

                    </section>",$paginaHTML);
            }
        }
        else
        {
            header("Location: /error/404.php");
        }

    }

    $queryRecensioni=$connessione->get_recensioni($id);
    $Recensioni="";
    $votoMedio=0;
    if($queryRecensioni->get_errno()==0){
        foreach($queryRecensioni->get_result() as $recensione){//stampa recensioni di tutti gli utenti di questo percorso
            if(!isset($_SESSION["Username"])||$recensione['utente']!=$_SESSION["Username"])
            {
                $Recensioni.="<section class=\"recensione\">
                <h5>".$recensione['utente']."</h5>
                <p>".$recensione['testo']."</p>
                <p class=\"valutazione-".$recensione['voto']."\">Voto: ".$recensione['voto']." su 5</p>
                </section>";
            }
            $votoMedio+=$recensione['voto'];
        }
        if($votoMedio!=0)
            $votoMedio=round($votoMedio/$queryRecensioni->get_element_count(),1,PHP_ROUND_HALF_UP);
    }
    else
    {
        header("Location: /error/404.php");
    }
    $connessione->closeConnection();
}
else
{
    
    header("Location: /error/500.html");
}


$paginaHTML = str_replace("[tag_titolo]", $tagtitolo, $paginaHTML);
$paginaHTML = str_replace("[tag_keyword]", $keyword, $paginaHTML);
$paginaHTML = str_replace("[tag_descrizione]", $tagdescrizione, $paginaHTML);
$paginaHTML = str_replace("[titolo]", $titolo, $paginaHTML);
$paginaHTML = str_replace("[descrizione]", $descrizione, $paginaHTML);
$paginaHTML = str_replace("[statistiche]", $statistiche, $paginaHTML);
$paginaHTML = str_replace("[caratteristiche]", $Caratteristiche, $paginaHTML);
$paginaHTML = str_replace("[indicazioni]", $indicazioni, $paginaHTML);
$paginaHTML = str_replace("[sottotitolo]", $sottotitolo, $paginaHTML);
$paginaHTML = str_replace("[recensioni]",$Recensioni,$paginaHTML);
$paginaHTML =str_replace("[file_gpx]",$filegpx,$paginaHTML);
$paginaHTML =str_replace("[immagini]",$Immagini,$paginaHTML);
$paginaHTML =str_replace("[prima_opzione]",$tasti_navbar[0],$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$tasti_navbar[1],$paginaHTML);
$paginaHTML =str_replace("[peso]",$peso,$paginaHTML);
$paginaHTML =str_replace("[media_voti]",$votoMedio,$paginaHTML);
$paginaHTML = str_replace("[mappa]", $mappa_embed, $paginaHTML);


echo $paginaHTML;
?>