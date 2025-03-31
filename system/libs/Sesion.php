<?php

class Sesion
{
    public static function init(){
        session_start();
    }

    public static function set($key,$val){
        $_SESSION[$key] =   $val;
    }

    public static function get($key){
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }

    public static function checkSesion(){
        self::init();
        if (self::get('login') == false){
            // yetkisiz erişim yönlendirme
            self::destroy();
            header('Location: '.SITE_URL."/admin/login");
            exit();
        }
    }

    public static function destroy(){
        session_destroy();
    }



}

