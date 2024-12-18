<?php
session_start();
if(isset($_SESSION["Username"])){
    header('Location: index.php');
}
else{
    require_once "grafica.php";

    $paginaHTML=grafica::getPage("registrati.html");

    if(isset($_SESSION['Username'])){
        if(!isset($_SESSION['isAdmin']))
        {
            $prima_opzione="<a href=\"pannelloAmministrazione.php\">Pannello Amministrazione</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
        else{
            $prima_opzione="<a href=\"profilo.php\">Profilo</a>";
            $seconda_opzione="<a href=\"logout.php\">Logout</a>";
        }
       
    }
    else
    {
        $prima_opzione="<a href=\"registrati.php\">Registrati</a>";
        $seconda_opzione="<a href=\"accedi.php\">Accedi</a>";
    }
    

    if (isset($_SESSION["error"])) {
        $paginaHTML = str_replace("</alert>", grafica::createAlert("error", $_SESSION["error"]), $paginaHTML);
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["info"])) {
        $paginaHTML = str_replace("</alert>", grafica::createAlert("info", $_SESSION["info"]), $paginaHTML);
        unset($_SESSION["info"]);
    }
    if (isset($_SESSION["success"])) {
        $paginaHTML = str_replace("</alert>", grafica::createAlert("success", $_SESSION["success"]), $paginaHTML);
        unset($_SESSION["success"]);
    } else {
        $paginaHTML = str_replace("</alert>", "", $paginaHTML);
    }

    $paginaHTML =str_replace("[prima_opzione]",$prima_opzione,$paginaHTML);
    $paginaHTML =str_replace("[seconda_opzione]",$seconda_opzione,$paginaHTML);

    echo $paginaHTML;
}
?>



