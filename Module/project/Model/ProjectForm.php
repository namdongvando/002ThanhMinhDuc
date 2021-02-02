<?php

namespace Module\project\Model;

use PFBC\Element;

class ProjectForm {

    public $Id;
    public $Name;
    public $Address;
    public $Phone;
    public $Email;
    public static $options = ["class" => "form-control"];

    function __construct($user = null) {

    }

    public static function Id($defaut = "") {

        return new Element\Hidden("project[Id]", $defaut);
    }

    public static function Name($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;

        return new Element\Textbox("Tên Dự Án", "project[Name]", $properties);
    }

    public static function Email($value = "") {
        $properties = self::$options;
        $properties["type"] = "email";
        $properties["value"] = $value;

        return new Element\Textbox("Email Liên Hệ", "project[Email]", $properties);
    }

    public static function Phone($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;

//        $properties["type"] = "email";
        return new Element\Textbox("SĐT Liên Hệ", "project[Phone]", $properties);
    }

    public static function Address($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textarea("Địa Chỉ", "project[Address]", $properties);
    }

    public static function onSubmit() {
        return count($_POST) > 0;
    }

    public static function MaxNumberController($value) {
        $properties = self::$options;
        $properties["value"] = $value;

//        $properties["type"] = "email";
        return new Element\Textbox("Số Thiết Bị Tối Đa", "project[MaxNumberController]", $properties);
    }

}
