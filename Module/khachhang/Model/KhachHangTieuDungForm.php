<?php

namespace Module\khachhang\Model;

use Model\FormRender;
use PFBC\Element\Textbox;

class KhachHangTieuDungForm extends \PFBC\Form implements IKhachHangTieuDungForm
{

    public function __construct($dv = null)
    {
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null)
    {
        //        return new \PFBC\Element\Hidden("khachhangtieudung[Id]", $Id, []);
        return new \PFBC\Element\Hidden("khachhangtieudung[Id]", $Id);
    }

    public static function Name($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option[FormRender::Required] = "";
        return new FormRender(new \PFBC\Element\Textbox("Tên Khách Hàng", "khachhangtieudung[Name]", $Option));
    }

    public static function KhuVuc($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $options = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::KhuVuc);
        //        return new \PFBC\Element\Select($label, $name, $options, $properties)
        return new FormRender(new \PFBC\Element\Select("Khu Vực Bảo Hành", "khachhangtieudung[KhuVuc]", $options, $Option));
    }

    public static function CMNN($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 15;
        return new  FormRender( new \PFBC\Element\Textbox("Chứng Minh Nhân Dân", "khachhangtieudung[CMNN]", $Option));
    }

    public static function DiaChi($value = null)
    {
        $Option = self::$Option;
        $Option["class"] = $Option["class"] . " textareaHeight";
        $Option["value"] = $value;
        $Option[FormRender::Required] = "1";
        return new FormRender(new Textbox("Địa Chỉ", "khachhangtieudung[DiaChi]", $Option));
    }

    public static function GhiChu($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new  FormRender(new \PFBC\Element\Textarea("Ghi Chú", "khachhangtieudung[GhiChu]", $Option));
    }

    public static function Phone($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 11;
        $Option["minlength"] = 10;
        $Option["oninvalid"] = "this.setCustomValidity('SĐT không hợp lệ')";
        $Option["oninput"] = "this.setCustomValidity('')";
        $Option[FormRender::Required] = "";

        return new FormRender(new \PFBC\Element\Textbox(
            "Số Điện Thoại Khách Hàng", "khachhangtieudung[Phone]", $Option));
    }

    public static function SubData($value = null)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new  FormRender(new \PFBC\Element\Textbox("Số Điện Thoại Bảo Hành", "khachhangtieudung[SubData]", $Option));
    }

    public static function TinhThanh($value)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["class"] = "form-control AjaxHTML";
        $Option["data-url"] = "/option/api/TinhThanhTagOption/";
        $Option["data-values"] = "true";
        $Option["data-object"] = "#khachhangtieudungQuanHuyen";
        $Option[FormRender::Required] = "";
        $options = \Module\option\Model\Option::GetTinhThanh2Option(0);
        return new  FormRender(new \PFBC\Element\Select("Tỉnh Thành Phố", "khachhangtieudung[TinhThanh]", $options, $Option));
    }

    public static function QuanHuyen($value, $tinhThanh = 1)
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["id"] = "khachhangtieudungQuanHuyen";
        $Option[FormRender::Required] = "";
        $options = \Module\option\Model\Option::GetTinhThanh2Option($tinhThanh);
        return new  FormRender(new \PFBC\Element\Select("Quận Huyện", "khachhangtieudung[QuanHuyen]", $options, $Option));
    }
}
