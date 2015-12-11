<?php

class Session {

    protected static $flash_message;


    public static function setFlash($message)
    {
//        self::$flash_message = $message;
//        $_SESSION['flash_message'] = $message;
        self::set('flash_message', $message);
    }


    public static function hasFlash()
    {
//        return !is_null(self::$flash_message);
        return !is_null(self::get('flash_message'));
    }

    public static function flash() {
//        echo self::$flash_message;
//        self::$flash_message = null;
        echo self::get('flash_message');
        self::delete('flash_message');
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy() {
        session_destroy();
    }



}