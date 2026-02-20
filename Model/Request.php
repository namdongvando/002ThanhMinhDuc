<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Description of Request
 *
 * @author MSI
 */
class Request
{
    //put your code here

    public function __construct()
    {

    }

    public static function Files($name)
    {
        return $_FILES[$name] ?? null;
    }
    public static function Post($name, $value)
    {

        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return $value;
    }

    public static function Get($name, $value)
    {
        if ($name == null) {
            return $_GET;
        }
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }
        return $value;
    }

    public static function Request($name, $value)
    {
        if ($name) {
            if (isset($_REQUEST[$name])) {
                if (is_string($_REQUEST[$name])) {
                    return Common::TextInput($_REQUEST[$name]);
                } else {
                    return $_REQUEST[$name];
                }
            }
            return $value;
        }


        if ($_REQUEST) {
            foreach ($_REQUEST as $key => $value) {
                if (is_array($_REQUEST[$key]) == false) {
                    $_REQUEST[$key] = Common::TextInput($_REQUEST[$key]);
                }
            }
        }
        return $_REQUEST;
    }

}