<?php
namespace Module\sanpham\Model\XuatNhapKho;

use datatable\ZendData;
use Model\FormRender;
use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\TemSanPham;
use Module\user\Model\Admin;
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
        return new FormRender(new Textarea("Ghi Chú", $Name, $prop));
    }
    public function UserId($val = null, $prop = [])
    {
        // FormOptions::Select(
        //     "",
        //     "Chon[NhanVien]",
        //     Admin::GetUsersOptions(Admin::NVKT),
        //     ["label" => 'Nhân Viên Kỹ Thuật &nbsp &nbsp &nbsp <a href="/user/users/" target="_blank" > Thêm Nhân Viên</a> ', 'style' => "width:100%;"]
        // )->renderHtml();
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop['style'] = "width:100%;";
        $prop["class"] = "form-control ";
        $Name = $this->getName(__FUNCTION__);
        return new FormRender(
            new Select(
                "Nhân viên bán hàng",
                $Name,
                Admin::GetUsersOptions(),
                $prop
            )
        );


    }
    public function KhacHang($value = null, $prop = [])
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
        $Name = $this->getName(__FUNCTION__);
        return new Select("Đại Lý", $Name, $ops, $Option);
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
        $prop["data-target"] = "#NoiDungKhac_" . __FUNCTION__;
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups("DoiTra_LyDo");
        return new Select("Lý Do", $Name, $Options, $prop);

    }
    public function LyDoXuatKho($val = null)
    {
        $prop["data-target"] = "#NoiDungKhac_" . __FUNCTION__;
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName("LyDo");
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups("XuatKho_LyDo");
        $lbl = "";
        $lbl = "<a href='/option/index/groups/XuatKho_LyDo/' ><i class='fa fa-plus' ></i></a>";

        return new Select("Lý Do Xuất Kho {$lbl}", $Name, $Options, $prop);

    }
}