<?php
session_start();
require_once "../generate_navbar.php";

$paginaHTML = file_get_contents("404.html");

$tasti_navbar = generateNavbar($_SESSION);


$paginaHTML =str_replace("[prima_opzione]",$tasti_navbar[0],$paginaHTML);
$paginaHTML =str_replace("[seconda_opzione]",$tasti_navbar[1],$paginaHTML);

echo $paginaHTML;
?>