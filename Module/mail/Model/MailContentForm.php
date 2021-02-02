<?php

namespace Module\mail\Model;

use PFBC\Element;

class MailContentForm extends \Model\Form {

    public $Id;
    public $Code;
    public $Name;
    public $Content;

    function __construct($user = null) {
        
    }

    public static function Id($value, $defaut = "") {
        $lable = isset($value["lable"]) ? $value["lable"] : "";
        $name = isset($value["name"]) ? $value["name"] : "Name";
        $value["value"] = isset($value["value"]) ? $value["value"] : "";
        if ($defaut) {
            $value["value"] = $defaut;
        }
        return new Element\Textbox($lable, $name, $value);
    }

    public static function IdHidden($name, $value = "") {
        return new Element\Hidden($name, $value);
    }

    public static function Code($value, $defaut = "") {
        $lable = isset($value["lable"]) ? $value["lable"] : "";
        $name = isset($value["name"]) ? $value["name"] : "Code";
        $value["value"] = isset($value["value"]) ? $value["value"] : "";
        unset($value["name"]);
        unset($value["label"]);
        if ($defaut) {
            $value["value"] = $defaut;
        }
        return new Element\Textbox($lable, $name, $value);
    }

    public static function Name($value, $defaut = "") {
        $lable = isset($value["lable"]) ? $value["lable"] : "";
        $name = isset($value["name"]) ? $value["name"] : "Name";
        $value["value"] = isset($value["value"]) ? $value["value"] : "";
        unset($value["name"]);
        unset($value["label"]);
        if ($defaut) {
            $value["value"] = $defaut;
        }
        return new Element\Textbox($lable, $name, $value);
    }

    public static function Content($value, $defaut = "") {
        $name = isset($value["name"]) ? $value["name"] : "Code";
        $value["value"] = isset($value["value"]) ? $value["value"] : "";
        if ($defaut) {
            $value["value"] = $defaut;
        }
        return new Element\Textarea("", $name, $value);
    }

}
