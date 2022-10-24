<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

use PFBC\Element;
use PFBC\Element\Hidden;

class FormOptions
{

    private static $FormClass = ["class" => "form-control"];

    static function HienThi($val, $pro = [])
    {
        $properties = self::$FormClass;
        $properties["value"] = $val;
        if ($pro) {
            foreach ($pro as $key => $value) {
                $properties[$key] = $value;
            }
        }
        $options = [
            10 => "10 dòng", 20 => "20 dòng", 50 => "50 dòng", 100 => "100 dòng"
        ];
        $properties["name"] = isset($properties["name"]) ? $properties["name"] : __FUNCTION__;
        return new FormRender(new Element\Select("Hiện Thị", $properties["name"], $options, $properties));
    }

    public static function TimKiem($val = null, $pro = [])
    {
        $properties = self::$FormClass;
        $properties["value"] = $val;
        if ($pro) {
            foreach ($pro as $key => $value) {
                $properties[$key] = $value;
            }
        }
        $name = isset($properties["name"]) ? $properties["name"] : __FUNCTION__;
        return new FormRender(new Element\Search("Tìm Kiếm", $name, $properties));
    }
    public static function SapXep($val = null, $pro = [])
    {
        $properties = self::$FormClass;
        $properties["value"] = $val;
        if ($pro) {
            foreach ($pro as $key => $value) {
                $properties[$key] = $value;
            }
        }
        $name = isset($properties["name"]) ? $properties["name"] : __FUNCTION__;
        $options = ["1" => "Ngày mới nhất", "0" => "Ngày cũ nhất"];
        return new FormRender(new Element\Select("Sắp Xếp", $name, $options, $properties));
    }
    //indexPage=[i]&numberPage
    public static function indexPage($val = null)
    {
        return new FormRender(new Hidden(__FUNCTION__, $val));
    }
    public static function numberPage($val = null)
    {
        return new FormRender(new Hidden(__FUNCTION__, $val));
    }

    public static function BtnModal($title, $target, $propertiesCustom = "")
    {
        $properties["data-toggle"] = 'modal';
        $properties["data-target"] = $target;
        $properties["class"] = $propertiesCustom["class"];
        if (!empty($propertiesCustom["permistion"])) {
            $properties["disabled"] = $propertiesCustom["permistion"];
        }

        return new FormRender(new Element\Button($title, "button", $properties));
    }

    public static function Select($val, $name, $options, $pro)
    {
        $properties = self::$FormClass;
        $properties["value"] = $val;
        if ($pro) {
            foreach ($pro as $key => $value) {
                $properties[$key] = $value;
            }
        }
        $properties["label"] =  $properties["label"] ?? '';
        $name = isset($properties["name"]) ? $properties["name"] : __FUNCTION__;
        return new FormRender(new Element\Select($properties["label"], $name, $options, $properties));
    }
}
