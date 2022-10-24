<?php

namespace Model;

use Model\FormRender;
use PFBC\Element\File;
use PFBC\Element\Hidden;
use PFBC\Element\Radio;
use PFBC\Element\Select;
use PFBC\Element\Textarea;
use PFBC\Element\Textbox;

class FormTieuTriDanhGia
{


    static $itemsTieuTri = "itemsTieuTri";
    static $FormName = "FormTieuTriDanhGia";
    private static $Option = ["class" => "form-control"];
    public function __construct($dataValue = null)
    {
    }
    static public function SetValueTieuTri($itemsTieuTri)
    {
        self::$itemsTieuTri = $itemsTieuTri;
    }
    static public function GetValueTieuTri($val, $code)
    {
        if ($val == null) {
            return self::$itemsTieuTri[$code] ?? null;
        }
        return $val;
    }
    static public function SetName($name)
    {
        return self::$FormName . "[{$name}]";
    }
    static public function SetNameTieuTri($name)
    {
        return self::$FormName . "[TieuTri][{$name}]";
    }
    public static function File($val = null, $id = "")
    {
        $Option = self::$Option;
        $Option["value"] = $val;
        $Option["style"] = "display:none";
        $Option["id"] = $id;
        return new FormRender(new File("Chọn file", __FUNCTION__, $Option));
    }
    public static function Comment($val = null)
    {

        $Option = self::$Option;
        $Option["value"] = $val;
        $name = self::SetName(__FUNCTION__);
        return new FormRender(new Textarea("Ý kiến khác", $name, $Option));
    }
    public static function MaTem($val = null)
    {
        $name = self::SetName(__FUNCTION__);
        return new FormRender(new Hidden($name, $val));
    }
    public static function TieuTri($val = null, $codeOption, $title)
    {
        $Option["value"] = self::GetValueTieuTri($val, $codeOption);
        $Option["labelclass"] = "block";
        $Option["id"] = $codeOption;
        $name = self::SetNameTieuTri($codeOption);
        return new FormRender(new Radio($title, $name, ["Co" => "Có", "Khong" => "Không"], $Option));
    }
}
