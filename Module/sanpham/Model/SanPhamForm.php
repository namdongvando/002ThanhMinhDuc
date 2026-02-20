<?php

namespace Module\sanpham\Model;

use Model\FormRender;
use Module\user\Model\Admin;

class SanPhamForm extends \PFBC\Form implements ISanPhamForm
{

    public $Id;
    public $Code;
    public $Name;

    const formName = 'sanpham';

    public function __construct($dv = null)
    {
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null)
    {
        //        return new \PFBC\Element\Hidden("sanpham[Id]", $Id, []);
        return new \PFBC\Element\Hidden("sanpham[Id]", $Id);
    }

    public static function Name($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["readonly"] = true;
        }
        return new \PFBC\Element\Textbox("Tên Sản Phẩm", "sanpham[Name]", $Option);
    }

    public static function Code($value = null)
    {
        $Option = self::$Option;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["readonly"] = true;
        }
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Mã Sản Phẩm", "sanpham[Code]", $Option);
    }

    public static function Gia($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["readonly"] = true;
        }
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Giá", "sanpham[Gia]", $Option);
    }

    public static function HinhAnh($value = null)
    {
        $Option = [];
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["disabled"] = true;
        }
        return new FormRender(new \PFBC\Element\File("Hình Ảnh", "HinhAnhSanPham", $Option));
    }

    public static function Mota($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["readonly"] = true;
        }
        return new FormRender(new \PFBC\Element\Textarea("Mô Tả", "sanpham[Mota]", $Option));
    }

    public static function DanhMuc($value = null, $pro = [])
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if ($pro) {
            foreach ($pro as $key => $value) {
                $Option[$key] = $value;
            }
        }
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["disabled"] = true;
        }
        $ops = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::DanhMucVatTu);
        $TaiCty = ["--Chọn Danh Mục--"];
        $ops = $TaiCty + $ops;
        return new FormRender(new \PFBC\Element\Select("Danh Mục Sản Phẩm", "sanpham[DanhMuc]", $ops, $Option));
    }

    public static function TinhTrang($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["disabled"] = true;
        }
        $ops = SanPham::ListTinhTrangToOptions();
        $Option["style"] = "width:100%;";
        return new \PFBC\Element\Select("Tình Trạng Sản Phẩm", "sanpham[TinhTrang]", $ops, $Option);
    }

    public static function ChungLoaiSP($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["disabled"] = true;
        }
        $ops = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::ChungLoaiSP);
        return new \PFBC\Element\Select("Chung Loại Sản Phẩm", "sanpham[ChungLoaiSP]", $ops, $Option);
    }

    public static function btnSave()
    {
        return new \PFBC\Element\Button("OK", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function MaDaiLy($value = null, $prop = [])
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["style"] = "width:100%;";
        if ($prop) {
            foreach ($prop as $k => $v) {
                $Option[$k] = $v;
            }
        }
        $ops = \Module\khachhang\Model\KhachHang::GetALL2Options();
        $TaiCty = ["all" => "Tất cả", -1 => "Đang Ở Công Ty"];
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin], true)) {
            $Option["disabled"] = true;
        }
        $ops = $TaiCty + $ops;
        return new \PFBC\Element\Select("Đại Lý", "sanpham[MaDaiLy]", $ops, $Option);
    }
}