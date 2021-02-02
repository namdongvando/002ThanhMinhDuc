<?php

namespace Module\sanpham\Model;

class TemSanPhamForm extends \PFBC\Form implements ITemSanPhamForm {

    public $Id;
    public $Code;
    public $Name;

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
//        return new \PFBC\Element\Hidden("temsanpham[Id]", $Id, []);
        return new \PFBC\Element\Hidden("temsanpham[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Tên Sản Phẩm", "temsanpham[Name]", $Option);
    }

    public static function btnSave() {
        return new \PFBC\Element\Button("Lưu", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function CreateDate($value = null) {

    }

    public static function KhachHangTieuDung($value = null, $hidden = false) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["readonly"] = true;
        if ($hidden == false)
            return new \PFBC\Element\Textbox("Khách Hàng Tiêu Dùng", "temsanpham[KhachHangTieuDung]", $Option);
        return new \PFBC\Element\Hidden("temsanpham[KhachHangTieuDung]", $value);
    }

    public static function MaSanPham($value = null, $hidden = false) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["readonly"] = true;
        if ($hidden = false)
            return new \PFBC\Element\Textbox("Mã Sản Phẩm", "temsanpham[MaSanPham]", $Option);
        return new \PFBC\Element\Hidden("temsanpham[MaSanPham]", $value);
    }

    public static function ModifyDate($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Mã Sản Phẩm", "temsanpham[ModifyDate]", $Option);
    }

    public static function NgayBatDau($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $Option["min"] = date("Y-m-d", time());
        return new \PFBC\Element\Textbox("Ngày Bắt Đầu", "temsanpham[" . __FUNCTION__ . "]", $Option);
    }

    public static function NgayKetThuc($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $Option["min"] = date("Y-m-d", time());
        return new \PFBC\Element\Textbox("Ngày Kết Thúc", "temsanpham[" . __FUNCTION__ . "]", $Option);
    }

    public static function Status($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $options = TemSanPham::GetStatus();
        return new \PFBC\Element\Select("Tình Trạng", "temsanpham[" . __FUNCTION__ . "]", $options, $Option);
    }

    public static function UserId($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("User", "temsanpham[" . __FUNCTION__ . "]", $Option);
    }

    public static function Parents($value = null, $title = "Tem Chính", $hidder = false) {
        $Option = self::$Option;
        $Option["value"] = $value;
        if ($hidder == false)
            return new \PFBC\Element\Textbox($title, "temsanpham[" . __FUNCTION__ . "]", $Option);
        return new \PFBC\Element\Hidden("temsanpham[" . __FUNCTION__ . "]", $value);
    }

}
?>

