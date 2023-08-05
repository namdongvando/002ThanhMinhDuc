<?php
namespace Module\sanpham\Model\XuatNhapKho;

use datatable\ZendData;
use Model\FormRender;
use Module\sanpham\Model\TemSanPham;
use PFBC\Element\Select;
use PFBC\Element\Textarea;
use Zend\Db\TableGateway\TableGateway;

class FormPhieuXuatNhap extends ZendData
{


    // public $Code;
    // public $Name;
    // public $Content;
    // public $UserId;
    // public $KhacHang;
    // public $Type;

    const nameForm = "FormPhieuXuatNhap";

    private static $formValue;
    public function __construct($dv = null)
    {
        self::$formValue = $dv;
    }

    private static $Option = ["class" => "form-control"];

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


    public function Id($val = null)
    {

    }
    public function Code($val = null)
    {

    }
    public function Name($val = null)
    {

    }
    // noi dung 
    public function Content($val = null, $prop = [])
    {
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control ";
        $Name = $this->getName(__FUNCTION__);
        return new FormRender(new Textarea("Nội Dung", $Name, $prop));
    }
    public function UserId($val = null)
    {

    }
    public function KhacHang($val = null)
    {

    }
    public function Type($val = null)
    {

    }
    public function CreateRecorde($val = null)
    {

    }
    public function DieuKienNhapKho($val = null)
    {
        $prop["data-target"] = "#NoiDungKhac";
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups("DoiTra_DieuKienNhapKho");
        return new Select("Điều kiện nhập kho", $Name, $Options, $prop);
    }
    public function TinhTrangSanPham($val = null)
    {
        $prop["data-target"] = "#NoiDungKhac";
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups("DoiTra_TinhTrangSanPham");
        return new Select("Tinh trạng sản phẩm", $Name, $Options, $prop);
    }
    public function LyDo($val = null)
    {
        $prop["data-target"] = "#NoiDungKhac";
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups("DoiTra_LyDo");
        return new Select("Lý Do", $Name, $Options, $prop);

    }
}