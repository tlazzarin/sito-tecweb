<?php
session_start();
if(isset($_SESSION["Username"])){
    header('Location: index.php');
}
else{
    require_once "grafica.php";

    $paginaHTML=grafica::getPage("accedi.html");


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
}
?>