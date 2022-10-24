<?php

namespace Module\trungtambaohanh\Model;

use Model\FormRender;

class YeuCauBaoHanhForm implements IYeuCauBaoHanh
{

    const nameForm = "yecaubaphanh";

    public function __construct($dv = null)
    {
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($values = null, $title = null)
    {
        $nameForm = self::nameForm;
        return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $values);
    }
    public static function HoTen($value = null, $title = null, $id = null)
    {
        if ($title == null)
            $title = "Họ & Tên";
        $prop = self::$Option;
        $prop["value"] = $value;
        $prop["id"] = $id;
        $prop[FormRender::Required] = true;
        $nameForm = self::nameForm;
        return new FormRender(new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $prop));
    }

    public static function Code($value = null, $title = null)
    {
        if ($title == null)
            $title = "Mã yêu cầu";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function MaTem($value = null, $title = null, $isHidden = false)
    {
        if ($title == null)
            $title = "Mã Tem Bảo Hành";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        if ($isHidden == true)
            return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function CreateDate($value = null, $title = null)
    {
        if ($title == null)
            $title = "Ngày Tạo";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function TinhThanh($value, $id = null, $dataobject = "#khachhangtieudungQuanHuyen")
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["id"] = $id;
        $Option["class"] = "form-control AjaxHTML";
        $Option["data-url"] = "/api/TinhThanhTagOption/";
        $Option["data-values"] = "true";
        $Option["data-object"] = $dataobject;
        $Option[FormRender::Required] = "";
        $options = \Module\option\Model\Option::GetTinhThanh2Option(0);
        $nameForm = self::nameForm;
        return new  FormRender(new \PFBC\Element\Select("Tỉnh Thành Phố", "{$nameForm}[" . __FUNCTION__ . "]", $options, $Option));
    }

    public static function QuanHuyen($value, $tinhThanh = 1, $id = "khachhangtieudungQuanHuyen")
    {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["id"] = $id;
        $Option[FormRender::Required] = "";
        $options = \Module\option\Model\Option::GetTinhThanh2Option($tinhThanh);
        $nameForm = self::nameForm;
        return new  FormRender(new \PFBC\Element\Select("Quận Huyện",  "{$nameForm}[" . __FUNCTION__ . "]", $options, $Option));
    }

    public static function DiaChi($value = null, $title = null)
    {
        if ($title == null)
            $title = "Địa Chỉ";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        $Option[FormRender::Required] = true;
        return new FormRender(new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option));
    }

    public static function KhachHangTieuDung($value = null, $title = null, $isHidden = false)
    {
        if ($title == null)
            $title = "Khách Hàng Tiêu Dùng";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        if ($isHidden == true)
            return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Name($value = null, $title = null)
    {
        if ($title == null)
            $title = "Nội Dung Công Việc";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function NgayBaoHanh($value = null, $title = null, $max = null)
    {
        if ($title == null)
            $title = "Ngày Bảo Hành";
        $Option = self::$Option;

        if ($value == null) {
            $value = date("Y-m-d", time() + 3600 * 24);
        }
        $Option["value"] = $value;
        $Option["type"] = "date";
        $Option["min"] = date("Y-m-d", time() + 3600 * 24);
        if ($max != null) {
            $Option["max"] = $max;
        }
        $nameForm = self::nameForm;
        return new  FormRender(new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option));
    }

    public static function NoiDung($value = null, $title = null)
    {
        if ($title == null)
            $title = "Sự Cố Mắc Phải";
        $properties = self::$Option;
        $properties["value"] = $value;
        $properties["required"] = true;
        $nameForm = self::nameForm;
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::SuCoMacPhai);
        return new \PFBC\Element\Select("Sự Cố Mắc Phải", "{$nameForm}[" . __FUNCTION__ . "]", $Options, $properties);
    }

    public static function SDT($value = null, $title = null)
    {
        if ($title == null)
            $title = "SĐT Liên Hệ";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 11;
        $Option["required"] = true;
        $Option[FormRender::Required] = true;
        $nameForm = self::nameForm;
        return new FormRender(new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option));
    }

    public static function UpdateDate($value = null, $title = null)
    {
        if ($title == null)
            $title = "Ngày Cập Nhật";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }
}
