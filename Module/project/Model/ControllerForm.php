<?php

namespace Module\project\Model;

use PFBC\Element;

class ControllerForm {

    public static $options = ["class" => "form-control"];

    function __construct($user = null) {

    }

    public static function Id($defaut = "") {

        return new Element\Hidden("controller[Id]", $defaut);
    }

    public static function PIdHidder($defaut = "") {

        return new Element\Hidden("controller[PId]", $defaut);
    }

    public static function Name($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;

        return new Element\Textbox("Name Controller", "controller[Name]", $properties);
    }

    public static function PId($value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $ControllerModel = new Project();
        $options = $ControllerModel->GetAll2Option();
        return new Element\Select("Project", "controller[PId]", $options, $properties);
    }

    public static function Lat($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("Lat", "controller[Lat]", $properties);
    }

    public static function Lon($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("Lon", "controller[Lon]", $properties);
    }

    public static function Ip($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;

        return new Element\Textbox("IP", "controller[Ip]", $properties);
    }

    public static function Username($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;

        return new Element\Textbox("Username", "controller[Username]", $properties);
    }

    public static function Password($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;

        return new Element\Textbox("Password", "controller[Password]", $properties);
    }

    public static function onSubmit() {
        return count($_POST) > 0;
    }

}
