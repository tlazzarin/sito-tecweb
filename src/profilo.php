<?php
ob_start();
session_start();
if(!isset($_SESSION["Username"]))
    header("Location: error/401.php");
if($_SESSION["isAdmin"]==1)
    header("Location: index.php");
require_once("DB/database.php");
use DB\Functions;
$paginaHtml = file_get_contents("profilo.html");


$connessione = new Functions();
$checkConnection = $connessione->openConnection();
if(!$checkConnection)
    header("Location: /error/500.html");

$tabella="
    <thead>
        <tr>
            <th scope=\"col\">Percorso</th>
            <th scope=\"col\">Testo</th>
            <th scope=\"col\">Voto</th>
        </tr>
    </thead>
    <tbody>
";
$query = $connessione->get_recensioni_utente($_SESSION["Username"]);
if(!$query->is_empty()){
    $result = $query->get_result();
    foreach($result as $recensione){
        $tabella.="
        <tr>
            <th scope=\"row\" data-title=\"Percorso\"><a href=\"percorso.php?id=".$recensione["id"]."\">".$recensione["titolo"]."</a></th>
            <td data-title=\"Testo\">".$recensione["testo"]."</td>
            <td data-title=\"Voto\" class=\"cella-voto\">".$recensione["voto"]."/5</td>
            </tr>
            ";
            }
}else
    $tabella.="<tr><td colspan=\"3\">Nessuna recensione trovata.</tr>";


$tabella.="</tbody>";
$paginaHtml = str_replace("[username]", $_SESSION["Username"], $paginaHtml);
$paginaHtml = str_replace("[corpo-tabella]", $tabella, $paginaHtml);
echo $paginaHtml;

?>