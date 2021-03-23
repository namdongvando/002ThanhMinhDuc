<?php

namespace Module\khachhang\Model;

class KhachHangTieuDungForm extends \PFBC\Form implements IKhachHangTieuDungForm {

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
//        return new \PFBC\Element\Hidden("khachhangtieudung[Id]", $Id, []);
        return new \PFBC\Element\Hidden("khachhangtieudung[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;

        return new \PFBC\Element\Textbox("Tên Khách Hàng", "khachhangtieudung[Name]", $Option);
    }

    public static function KhuVuc($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $options = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::KhuVuc);
//        return new \PFBC\Element\Select($label, $name, $options, $properties)
        return new \PFBC\Element\Select("Khu Vực", "khachhangtieudung[KhuVuc]", $options, $Option);
    }

    public static function CMNN($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 15;
        return new \PFBC\Element\Textbox("Chứng Minh Nhân Dân", "khachhangtieudung[CMNN]", $Option);
    }

    public static function DiaChi($value = null) {
        $Option = self::$Option;
        $Option["class"] = $Option["class"] . " textareaHeight";
        $Option["value"] = $value;
        return new \PFBC\Element\Textarea("Địa Chỉ", "khachhangtieudung[DiaChi]", $Option);
    }

    public static function GhiChu($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textarea("Ghi Chú", "khachhangtieudung[GhiChu]", $Option);
    }

    public static function Phone($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 11;

        return new \PFBC\Element\Textbox("Số Điện Thoại Khách Hàng", "khachhangtieudung[Phone]", $Option);
    }

    public static function SubData($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Số Điện Thoại Bảo Hành", "khachhangtieudung[SubData]", $Option);
    }

}
?>

