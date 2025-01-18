<?php
require_once("DB/database.php");
require_once "generate_navbar.php";
use DB\Functions;
ob_start();
session_start();


$paginaHTML = file_get_contents("index.html");

$connessione = new Functions();
$checkConnection = $connessione->openConnection();
$tasti_navbar = generateNavbar($_SESSION);


$PercorsiTop = "";

if($checkConnection){
    $queryPercorsiTop = $connessione->get_percorsi_top();
    
    if($queryPercorsiTop->ok() && !$queryPercorsiTop->is_empty()) {
        $PercorsiTop = "<div class=\"percorsi-top-container\">"; 
        
        foreach($queryPercorsiTop->get_result() as $percorso){
            
            $PercorsiTop .= "
                <section class=\"carta\">
                    <a href=\"percorso.php?id=" . $percorso['id'] . "\">
                        <img src=\"./assets/img/percorsi/".$percorso['id_immagine']."\" alt=\"".$percorso['alt']."\">
                        <h3 class=\"link-percorso\">".$percorso['titolo']."</h3> 
                    </a>               
                </section>";
        }
        
        $PercorsiTop .= "</div>";  
    }
    else
    {
        header("Location: ./error/404.php");
    }
    
    
    $connessione->closeConnection();
} else {
    
    header("Location: ./error/500.html");
}


$paginaHTML = str_replace("[percorsi_top]", $PercorsiTop, $paginaHTML);
$paginaHTML =str_replace("[prima_opzione]",$tasti_navbar[0],$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$tasti_navbar[1],$paginaHTML);

echo $paginaHTML;