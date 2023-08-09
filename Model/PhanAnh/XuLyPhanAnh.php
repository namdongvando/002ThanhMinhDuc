<?php

namespace Model\PhanAnh;

use Model\FormRender;
use Module\option\Model\Option;
use PFBC\Element\Hidden;
use PFBC\Element\Select;
use PFBC\Element\Textarea;

class XuLyPhanAnh
{


    static $itemsTieuTri = "itemsTieuTri";
    static $FormName = "XuLyPhanAnh";
    private static $Propertive = ["class" => "form-control"];
    public function __construct($dataValue = null)
    {
    }
    static public function SetName($name)
    {
        return self::$FormName . "[{$name}]";
    }
    public function Id($val = null)
    {
        $name = self::SetName(__FUNCTION__);
        return new FormRender(new Hidden($name, $val));
    }
    public function Comment($val = null)
    {
        $prop = self::$Propertive;
        $prop["value"] = $val;
        $prop["id"] = __FUNCTION__;
        $name = self::SetName(__FUNCTION__);
        // TinhTrangPhanAnh 
        return new FormRender(new Textarea("Nội dung", $name, $prop));
    }
    public function TinhTrang($val = null)
    {
        $prop = self::$Propertive;
        $prop["value"] = $val;
        $prop["id"] = __FUNCTION__;
        $name = self::SetName(__FUNCTION__);
        // TinhTrangPhanAnh
        $op = Option::GetAll2OptionsByGroups(Option::TinhTrangPhanAnh);
        return new FormRender(new Select("Tình trạng", $name, $op, $prop));
    }
}
