<?php

class grafica{
    public static function getPage($page){

        $paginaHTML = file_get_contents($page);


        return $paginaHTML;
    }

    public static function createAlert($type, $message)
    {
        
        switch ($type) {
            case "error":
                
                break;
            case "info":
                
                break;
            case "success":
                
                break;
        }

        return "<div class='divAlert'><p class='alert " . $type . "'>" . $message . "</p></div>";
    }
}