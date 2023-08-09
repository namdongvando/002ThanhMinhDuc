<?php
namespace Module\sanpham\Model;

use Model\FormOptions;
use Model\FormRender;
use Module\option\Model\Option;
use Module\option\Model\OptionForm;
use PFBC\Element\Hidden;
use PFBC\Element\Select;

class FormKiemHang
{
    const FormName = "FormKiemHang";


    function GetName($name)
    {
        return self::FormName . "[{$name}]";
    }


    function Hidden($val, $name)
    {
        $name = $this->GetName($name);
        return new FormRender(new Hidden($name, $val));
    }
    function SanPham($val)
    {
        $name = $this->GetName(__FUNCTION__);
        $op = [];
        $prop = ["class" => "form-control"];
        // return new FormRender(new Select("Sản Phẩm",$name,$op ,$prop));
        return OptionForm::SelectGroups("Danh Mục Sản Phẩm", $name, Option::DanhMucVatTu,["value"=>$val]);
    }

    function Status($val)
    {
        $name = $this->GetName(__FUNCTION__);
        return FormOptions::SelectFromSetting($val, $name, "TrangThaiKiemHang", [
            "class" => "form-control",
            "label" => "Tình Trạng"
        ]);
    }
    function Content($val)
    {
        $name = $this->GetName(__FUNCTION__);
        return FormOptions::TextArea($val, $name, [
            "class" => "form-control",
            "label" => "Ghi Chú",
            "value" => $val
        ]);
    }

}