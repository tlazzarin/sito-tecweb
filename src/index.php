<?php

session_start();

use DB\Functions;

// Include i file necessari
require_once("DB/database.php");
require_once "grafica.php";

// Carica la pagina HTML di base
$paginaHTML = file_get_contents("index.html");

if(isset($_SESSION['Username'])){
    if(!isset($_SESSION['isAdmin']))
    {
        $prima_opzione="<a aria-label=\"Vai alla pagina del pannello Amministrazione\" href=\"pannelloAmministrazione.php\">Pannello Amministrazione</a>";
        $seconda_opzione = "
            <section class=\"logout\">
                <a href=\"accedi.php\" class=\"logout-button\">
                    Logout <img src=\"./assets/right-to-bracket-solid.svg\" alt=\"Icona logout\" class=\"icon-logout\">
                </a>
            </section>";
    }
    else{
        $prima_opzione="<a aria-label=\"Vai alla tua pagina personale\" href=\"profilo.php\">Profilo</a>";
        $seconda_opzione = "
            <section class=\"logout\">
                <a href=\"accedi.php\" class=\"logout-button\">
                    Logout <img src=\"./assets/right-to-bracket-solid.svg\" alt=\"Icona logout\" class=\"icon-logout\">
                </a>
            </section>";
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

$paginaHTML =str_replace("[prima_opzione]",$prima_opzione,$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$seconda_opzione,$paginaHTML);

echo $paginaHTML;