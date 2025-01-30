<?php
ob_start();
session_start();
if(isset($_SESSION["Username"])){
    header('Location: index.php');
}
else{


    $paginaHTML=file_get_contents("registrati.html");
    
    unset($_SESSION['paginaPrecedente']);
    if(isset($_SERVER['HTTP_REFERER']))
    {
        if(str_contains($_SERVER['HTTP_REFERER'],"percorso"))//verifica se si proviene da pagina percorso per reindirizzamento in seguito
        $_SESSION['paginaPrecedente']=$_SERVER['HTTP_REFERER'];
    }
    
    

    if (isset($_SESSION["info"])) {
        $paginaHTML = str_replace("[alert]", $_SESSION["info"] , $paginaHTML);
        unset($_SESSION["info"]);
    }
    else {
        $paginaHTML = str_replace("[alert]", "", $paginaHTML);
    }

    
     
    echo $paginaHTML;
}
?>



