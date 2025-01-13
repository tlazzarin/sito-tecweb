<?php

session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "grafica.php";
require_once "generate_navbar.php";

$paginaHTML=grafica::getPage("percorsi.html");
$tasti_navbar = generateNavbar($_SESSION);


$errore=false;
$connessione=new Functions();
$checkConnection=$connessione->openConnection();

if($checkConnection){

    $queryPercorsi=$connessione->get_tutti_percorsi();

    $Percorsi="";

    if($queryPercorsi->ok() && !$queryPercorsi->is_empty())
        {
            foreach($queryPercorsi->get_result() as $percorso){
                
                $Percorsi.="<section class=\"carta\"><a href=\"percorso.php?id=" . $percorso['id'] . "\">
                <img src=\"./assets/img/percorsi/".$percorso['id_immagine']."\"alt=\"".$percorso['alt']."\">
                <h3 class=\"link-percorso\">".$percorso['titolo']."</h3>
                </a></section>";
                
                
            }
            
        }
}
else
{
    $_SESSION["error"] = "Impossibile connettersi al sistema";
}






$paginaHTML =str_replace("[prima_opzione]",$tasti_navbar[0],$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$tasti_navbar[1],$paginaHTML);
$paginaHTML =str_replace("[percorsi]",$Percorsi,$paginaHTML);

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


