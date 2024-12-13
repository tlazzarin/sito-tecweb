<?php

class grafica{
    public static function getPage($page){

        $paginaHTML = file_get_contents($page);


        return $paginaHTML;
    }

    public static function createAlert($type, $message)
    {
        $class = "";
        switch ($type) {
            case "error":
                $class = "fa fa-times";
                break;
            case "info":
                $class = "fa fa-exclamation-triangle";
                break;
            case "success":
                $class = "fa fa-check";
                break;
        }

        return "<div class='divAlert'><p class='alert " . $type . "'><i class='" . $class . "'  aria-hidden='true'></i> " . $message . "</p></div>";
    }
}