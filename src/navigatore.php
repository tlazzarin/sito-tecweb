<?php
require_once "generate_navbar.php";
ob_start();
session_start();


$paginaHTML = file_get_contents("navigatore.html");
$tasti_navbar = generateNavbar($_SESSION);


$paginaHTML = str_replace("[prima_opzione]", $tasti_navbar[0], $paginaHTML);
$paginaHTML = str_replace("[seconda_opzione]", $tasti_navbar[1], $paginaHTML);

echo $paginaHTML;

?>