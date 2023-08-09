<?php

namespace Module\trungtambaohanh\Model;

use Model\FormRender;
use Module\user\Model\Admin;
use PFBC\Element\Hidden;
use PFBC\Element\Select;
use PFBC\Element\Textarea;
use PFBC\Element\Textbox;

class FormYeuCauBaoHanh implements IFormYeuCauBaoHanh
{

    const nameForm = "yecaubaphanh";

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

    /**
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function Id($val = null, $prop = array())
    {
        $Name = $this->getName(__FUNCTION__);
        $val = $this->getValue($val, __FUNCTION__);
        return new FormRender(new Hidden($Name, $val));
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function Code($val = null, $prop = array())
    {

    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function MaTem($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function Name($val = null, $prop = array())
    {

    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function KhachHangTieuDung($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function SDT($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function TinhThanh($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function QuanHuyen($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function DiaChi($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function NgayBaoHanh($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function NoiDung($val = null, $prop = array())
    {
        $prop["data-target"] = "#NoiDungKhac";
        $prop["Id"] = __FUNCTION__;
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control OpionOrther";
        $Name = $this->getName(__FUNCTION__);
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::SuCoMacPhai);
        return new Select("Lỗi Bảo Hành", $Name, $Options, $prop);
    }

    public function NoiDungKhac($val = null, $prop = array())
    {
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $prop["class"] = "form-control ";
        $Name = $this->getName(__FUNCTION__);
        return new Textarea("Lỗi khác", $Name, $prop);
    }
    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function Status($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function IdTrungTamBaoHanh($val = null, $prop = array())
    {
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $op = (new TrungTamBaoHanh())->GetToOption();
        $Name = $this->getName(__FUNCTION__);
        return new FormRender(new Select("Trung tâm bảo hành", $Name, $op, $prop));

    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function CreateDate($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function idNhanVien($val = null, $prop = array())
    {
        $prop = $this->getProp($prop);
        $prop["value"] = $this->getValue($val, __FUNCTION__);
        $op = Admin::GetUsersByGroups2Options([Admin::NVKT]);
        $Name = $this->getName(__FUNCTION__);
        return new FormRender(new Select("Nhân Viên Kỹ Thuật", $Name, $op, $prop));
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function UpdateDate($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function HinhAnh($val = null, $prop = array())
    {
    }

    /**
     *
     * @param mixed $val
     * @param mixed $prop
     * @return mixed
     */
    public function Note($val = null, $prop = array())
    {
    }
}