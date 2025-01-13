<?php

class grafica {
    public static function getPage($page){
        $paginaHTML = file_get_contents($page);
        return $paginaHTML;
    }
    
    public static function createAlert($type, $message) {
        $class = '';
        switch ($type) {
            case "error":
                $class = 'alert-error';
                break;
            case "info":
                $class = 'alert-info';
                break;
            case "success":
                $class = 'alert-success';
                break;
            default:
                $class = 'alert';
        }
        return "<section class='contenitore-alert'><p class='" . $class . "'>" . $message . "</p></section>";
    }
}