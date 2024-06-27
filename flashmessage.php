<?php

class FlashMessage {
    public static function set($key, $message) {
        $_SESSION[$key] = $message;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        } else {
            return null;
        }
    }

    public static function redirect($url, $key = null, $message = null) {
        if ($key !== null && $message !== null) {
            self::set($key, $message);
        }
        header("Location: $url");
        exit;
    }
}
?>