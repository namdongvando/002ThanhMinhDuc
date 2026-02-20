<?php
namespace Module\trungtambaohanh\Model;

use Model\FormRender;
use PFBC\Element\Hidden;
use PFBC\Element\Select;
use PFBC\Element\Textbox;

class FormXuLyYeuCau
{
    const nameForm = "XuLyYeuCau";

    private static $Option = ["class" => "form-control"];
    private static $formValue;
    public function __construct($dv = null)
    {
        self::$formValue = $dv;
    }

    function getName($name)
    {
        return self::nameForm . "[{$name}]";
    }
    function getValue($val, $name)
    {
        if ($val === null) {
            return self::$formValue[$name] ?? null;
        }
        return $val;
    }
    function getProp($name)
    {
        $prop = self::$Option;
        if ($name) {
            foreach ($name as $k => $v) {
                $prop[$k] = $v;
            }
        }
        return $prop;
    }


    function Id($val = null, $prop = [])
    {

    }
    function MaYeuCau($val = null, $prop = [])
    {
        $Name = $this->getName(__FUNCTION__);
        $Value = $this->getValue($val, __FUNCTION__);
        return new FormRender(new Hidden($Name, $Value, $prop));
    }
    function NoiDung($val = null, $prop = ["Groups" => "PhuongAnXyLy"])
    {
        $prop["data-target"] = "#NoiDungKhac_XuLyYeuCau";
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups($prop["Groups"]);
        $lbl = $prop["lbl"]??"Phương án xử ly";
        if ($Options == null) {
            $lbl = $prop["Groups"];
        }
        return new FormRender(new Select($lbl, $Name, $Options, $prop));
    }
    function NoiDungKhac($val = null, $prop = [])
    {
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        return new FormRender(new Textbox("Nhập nội dung", $Name, $prop));
    }
    function Files($prop = [])
    {
        $prop = $this->getProp($prop);
        $prop["class"] = "form-control";
        $prop["type"] = "file";
        $Name = self::nameForm."[]";
        return new FormRender(new Textbox("File đính kèm", $Name, $prop));
    }
    function UserId($val = null, $prop = [])
    {

    }
    function Type($val = null, $prop = [])
    {

    }
    function CreateRecord($val = null, $prop = [])
    {

    }
    function UpdateRecord($val = null, $prop = [])
    {

    }


}


?>