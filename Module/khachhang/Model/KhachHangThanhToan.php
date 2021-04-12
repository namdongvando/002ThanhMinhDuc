<?php

namespace Module\khachhang\Model;

class KhachHangThanhToan extends KhachHangThanhToanData {

    public $Id, $Name, $MaKhachHang, $TenCongTy, $MaSoThue, $DiaChi, $STK, $NganHang, $Fax, $GhiChu;
    public static $GetByMaKhachHang = null;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->MaKhachHang = !empty($dv["MaKhachHang"]) ? $dv["MaKhachHang"] : null;
            $this->TenCongTy = !empty($dv["TenCongTy"]) ? $dv["TenCongTy"] : null;
            $this->MaSoThue = !empty($dv["MaSoThue"]) ? $dv["MaSoThue"] : null;
            $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
            $this->STK = !empty($dv["STK"]) ? $dv["STK"] : null;
            $this->NganHang = !empty($dv["NganHang"]) ? $dv["NganHang"] : null;
            $this->Fax = !empty($dv["Fax"]) ? $dv["Fax"] : null;
            $this->GhiChu = !empty($dv["GhiChu"]) ? $dv["GhiChu"] : null;
        }
    }

    public static function GetByMaKhachHang($param) {
        if (self::$GetByMaKhachHang)
            return self::$GetByMaKhachHang;
        $KhachHangThanhToan = new KhachHangThanhToan();
        $where = " `MaKhachHang` = '{$param}' ";
        return $KhachHangThanhToan->GetRowByWhere($where);
    }

}
?>

