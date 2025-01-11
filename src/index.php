<?php
require_once("DB/database.php");
use DB\Functions;
session_start();

$paginaHTML = file_get_contents("index.html");

$connessione = new Functions();
$checkConnection = $connessione->openConnection();

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


$PercorsiTop = "";

if($checkConnection){
    $queryPercorsiTop = $connessione->get_percorsi_top();
    
    if($queryPercorsiTop->ok() && !$queryPercorsiTop->is_empty()) {
        $PercorsiTop = "<div class=\"percorsi-top-container\">"; 
        
        foreach($queryPercorsiTop->get_result() as $percorso){
            
            $PercorsiTop .= "<a href=\"percorso.php?id=" . $percorso['id'] . "\">
                <section class=\"carta\">
                    <img src=\"./assets/img/percorsi/".$percorso['id_immagine']."\" alt=\"".$percorso['alt']."\">
                    <h3 class=\"link-percorso\">".$percorso['titolo']."</h3>                
                </section>
            </a>";
        }
        
        $PercorsiTop .= "</div>";  
    }
    
    
    $connessione->closeConnection();
} else {
    $_SESSION["error"] = "Impossibile connettersi al sistema";
}


$paginaHTML = str_replace("[percorsi_top]", $PercorsiTop, $paginaHTML);
$paginaHTML =str_replace("[prima_opzione]",$prima_opzione,$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$seconda_opzione,$paginaHTML);

echo $paginaHTML;