<?php
ob_start();
session_start();

use DB\Functions;

require_once("DB/database.php");
require_once "generate_navbar.php";

$paginaHTML = file_get_contents("percorsi.html");
$tasti_navbar = generateNavbar($_SESSION);


$errore = false;
$connessione = new Functions();
$checkConnection = $connessione->openConnection();

if ($checkConnection) {

    $queryPercorsi = $connessione->get_tutti_percorsi();

    $Percorsi = "";

    if ($queryPercorsi->ok()) {
        foreach ($queryPercorsi->get_result() as $percorso) {

            $Percorsi .= "<section class=\"carta\"><a href=\"percorso.php?id=" . $percorso['id'] . "\">
                <img src=\"./assets/img/percorsi/" . $percorso['id_immagine'] . "\"alt=\"" . $percorso['alt'] . "\">
                <h3 class=\"link-percorso\">" . $percorso['titolo'] . "</h3>
                </a></section>";


        }

    }
    else
    {
        header("Location: ./error/404.php");
    }
} else {
    
    header("Location: ./error/500.html");
}






$paginaHTML = str_replace("[prima_opzione]", $tasti_navbar[0], $paginaHTML);
$paginaHTML = str_replace("[seconda_opzione]", $tasti_navbar[1], $paginaHTML);
$paginaHTML = str_replace("[percorsi]", $Percorsi, $paginaHTML);


echo $paginaHTML;


