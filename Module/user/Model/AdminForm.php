<?php

namespace Module\user\Model;

use PFBC\Element;

class AdminForm {

    public $Id;
    public $Username;
    public $Password;
    public $Random;
    public $Name;
    public $Email;
    public $Phone;
    public $Address;
    public $Note;
    public $Groups;
    public static $options = ["class" => "form-control"];

    function __construct($uf = null) {

    }

    public static function onSubmit() {
        return count($_POST) > 0;
    }

    public static function Id($value = "") {
        return new Element\Hidden("users[Id]", $value);
    }

    public static function Password($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["type"] = "password";
        $properties["required"] = true;
        return new Element\Textbox("Mật Khẩu", "users[Password]", $properties);
    }

    public static function Username($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;
        return new Element\Textbox("Tài Khoản", "users[Username]", $properties);
    }

    public static function Email($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["type"] = "email";
        $properties["required"] = true;
        return new Element\Textbox("Email", "users[Email]", $properties);
    }

    public static function Phone($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("SĐT", "users[Phone]", $properties);
    }

    public static function Address($value = "", $custom = null) {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("Địa Chỉ", "users[Address]", $properties);
    }

    public static function Note($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("Ghi Chú", "users[Note]", $properties);
    }

    public static function Groups($value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $properties["required"] = true;
        $UserGroups = new userGroups();
        $options = $UserGroups->GetAll2Option();
//        $options = array_merge($all, $options);
        return new Element\Select("Nhóm", "users[Groups]", $options, $properties);
    }

    public static function Name($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;
        return new Element\Textbox("Họ & Tên", "users[Name]", $properties);
    }

    public static function Active($value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $properties["required"] = true;
        $ModelAdmin = new AdminStatus();
        $options = $ModelAdmin->Get2Option();
        return new Element\Select("Tình Trạng", "users[Active]", $options, $properties);
    }

}
?>

