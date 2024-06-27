<?php 

class FlashMessage {

    public static function render() {
        if (!isset($_SESSION['messages'])) {
            return null;
        }
        $messages = $_SESSION['messages'];
        unset($_SESSION['messages']);
        return implode('<br/>', $messages);
    }

    public static function add($message) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = array();
        }
        $_SESSION['messages'][] = $message;
    }
    
    public static function redirect($location){
        
        echo "<script type='text/javascript'>document.location='{$location}.php';</script>";exit();
    }

     public static function redirectlink($location){
        
        echo "<script type='text/javascript'>document.location='{$location}';</script>";exit();
    }

}



?>