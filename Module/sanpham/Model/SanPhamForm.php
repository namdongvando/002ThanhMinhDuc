<?php

namespace Module\sanpham\Model;

class SanPhamForm extends \PFBC\Form implements ISanPhamForm {

    public $Id;
    public $Code;
    public $Name;

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
//        return new \PFBC\Element\Hidden("sanpham[Id]", $Id, []);
        return new \PFBC\Element\Hidden("sanpham[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Tên Sản Phẩm", "sanpham[Name]", $Option);
    }

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Mã Sản Phẩm", "sanpham[Code]", $Option);
    }

    public static function Gia($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Giá", "sanpham[Gia]", $Option);
    }

    public static function HinhAnh($value = null) {
        return new \PFBC\Element\File("Hình Ảnh", "HinhAnhSanPham");
    }

    public static function Mota($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textarea("Mô Tả", "sanpham[Mota]", $Option);
    }

    public static function DanhMuc($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $ops = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::DanhMucVatTu);
        return new \PFBC\Element\Select("Danh Mục Sản Phẩm", "sanpham[DanhMuc]", $ops, $Option);
    }

    public static function TinhTrang($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $ops = SanPham::ListTinhTrangToOptions();
        return new \PFBC\Element\Select("Tình Trạng Sản Phẩm", "sanpham[TinhTrang]", $ops, $Option);
    }

    public static function ChungLoaiSP($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
//        $ops = SanPham::ListTinhTrangToOptions();
        $ops = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::ChungLoaiSP);
        return new \PFBC\Element\Select("Chung Loại Sản Phẩm", "sanpham[ChungLoaiSP]", $ops, $Option);
    }

    public static function btnSave() {
        return new \PFBC\Element\Button("Lưu", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

}
?>

