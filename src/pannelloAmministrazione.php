<?php
session_start();

if(!isset($_SESSION["Username"]))
    header("Location: error/401.php");
else if($_SESSION["isAdmin"]!=true)
    header("Location: error/403.php");

use DB\Functions;
require_once("DB/database.php");

$connessione=new Functions();

if(!$connessione->openConnection())
    header("Location: error/500.html");

$tabella="
    <caption>Tabella recensioni</caption>
    <thead>
        <tr>
            <th scope=\"col\">Percorso</th>
            <th scope=\"col\">Testo</th>
            <th scope=\"col\">Autore</th>
            <th scope=\"col\">Valutazione</th>
            <th scope=\"col\" abbr=\"\">Elimina</th>
        </tr>
    </thead>
    <tbody>
";

$query=$connessione->get_all_recensioni();
$connessione->closeConnection();
if(!$query->is_empty()){
    $result = $query->get_result();
    foreach($result as $recensione){
        $tabella.="
        <tr>
            <th data-title=\"Percorso\" scope=\"row\"><a href=\"percorso.php?id=".$recensione["id"]."\">".$recensione["titolo"]."</a></th>
            <td data-title=\"Testo\">".$recensione["testo"]."</td>
            <td data-title=\"Utente\">".$recensione["utente"]."</td>
            <td data-title=\"Voto\"class=\"cella-voto\">".$recensione["voto"]."/5</td>
            <td class=\"rimuovi-intestazione-mobile\"><a class=\"icona-elimina\"href=\"adminCancellaRecensione.php?user=".$recensione["utente"]."&percorso=".$recensione["id"]."\">Elimina</a></td>
        </tr>
        ";
    }
}else{
    $tabella.="
    <tr>
        <th>Non sono presenti recensioni.</th>
    </tr>
    ";
}
$tabella .= "</tbody>";
$paginaHTML = file_get_contents("pannelloAmministrazione.html");
$paginaHTML = str_replace("[username]", $_SESSION["Username"], $paginaHTML);
$paginaHTML = str_replace("[corpo-tabella]", $tabella, $paginaHTML);
echo $paginaHTML;
?>