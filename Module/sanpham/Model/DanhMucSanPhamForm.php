<?php

namespace Module\sanpham\Model;

use \Module\option\Model\Option;

class DanhMucSanPhamForm extends \Module\option\Model\OptionForm {

    public function __construct() {

    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
//        return new \PFBC\Element\Hidden("DanhMuc[Id]", $Id, []);
        return new \PFBC\Element\Hidden("DanhMuc[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Tên Danh Mục", "DanhMuc[Name]", $Option);
    }

    public static function Groups($value = null) {
        return new \PFBC\Element\Hidden("DanhMuc[Groups]", "DanhMucVatTu");
    }

    public static function Parents($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        $Option["style"] = "width:100%;";
        $options = \Module\option\Model\Option::GetAll2OptionsByGroupsID("ChungLoaiSP");
        return new \PFBC\Element\Select("Chủng Loại", "DanhMuc[Parents]", $options, $Option);
    }

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Mã Danh Mục", "DanhMuc[Code]", $Option);
    }

    public static function OrderBy($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "number";
        return new \PFBC\Element\Textbox("STT", "DanhMuc[OrderBy]", $Option);
    }

    public static function Note($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textarea("Ghi Chú", "DanhMuc[Note]", $Option);
    }

    public static function btnSubmit() {
        return new \PFBC\Element\Button("OK", "submit", ["class" => "btn-succes", "Name" => "OnSave"]);
    }

}
