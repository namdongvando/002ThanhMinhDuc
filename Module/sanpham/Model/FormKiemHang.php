<?php
namespace Module\sanpham\Model;

use Model\FormOptions;
use Model\FormRender;
use PFBC\Element\Hidden;

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