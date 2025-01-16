<?php
//Funzione che genera i tasti appropriati in base allo stato dell'utente (autenticato, admin, non autenticato)
function generateNavbar($session_data)
{
    $risposta = array();
    //Caso utente loggato [profilo/admin  |  Logout]
    if (isset($session_data['Username'])) {
        if ($session_data['isAdmin'] == 1)
            $risposta[0] = "<a aria-label=\"Vai alla pagina del pannello Amministrazione\" href=\"pannelloAmministrazione.php\">Pannello Amministrazione</a>";
        else
            $risposta[0] = "<a aria-label=\"Vai alla tua pagina personale\" href=\"profilo.php\">Profilo</a>";
        $risposta[1] = "
                <a href=\"logout.php\" class=\"action-button\">
                    Logout <img src=\"./assets/right-to-bracket-solid.svg\" alt=\"Icona logout\" class=\"icon-logout\">
                </a>";
    } else { //Caso utente non loggato [Registrati | Accedi]
        $risposta[0] = "<a href=\"registrati.php\">Registrati</a>";
        $risposta[1] = "
                <a href=\"accedi.php\" class=\"action-button\">
                    Accedi <img src=\"./assets/right-from-bracket-solid.svg\" alt=\"Icona accedi\" class=\"icon-accedi\">
                </a>";




    }
    return $risposta;
}
?>