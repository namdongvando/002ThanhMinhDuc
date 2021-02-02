<?php

namespace Common;

class Form {

    static function isPost() {
        return (isset($_POST["Save"]) || !empty($_POST));
    }

    public static function RequestPost($name, $defaut) {
        return isset($_POST[$name]) ? $_POST[$name] : $defaut;
    }

    public static function RequestGet($name, $defaut) {
        return isset($_GET[$name]) ? $_GET[$name] : $defaut;
    }

}

?>