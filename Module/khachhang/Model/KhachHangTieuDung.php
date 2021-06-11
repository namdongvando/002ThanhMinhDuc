<?php

namespace Module\khachhang\Model;

class KhachHangTieuDung extends KhachHangTieuDungData {

    public $Id, $KhuVuc, $Name, $Code, $Phone, $DiaChi, $CMNN, $GhiChu, $SubData, $TinhThanh, $QuanHuyen, $PhuongXa;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $code = $dv;
                $dv = $this->GetById($code);
                if (!$dv) {
                    $dv = $this->GetByCode($code);
                }
            }
        }
        $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
        $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
        $this->Code = !empty($dv["Code"]) ? $dv["Code"] : "";
        $this->Phone = !empty($dv["Phone"]) ? $dv["Phone"] : null;
        $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
        $this->CMNN = !empty($dv["CMNN"]) ? $dv["CMNN"] : null;
        $this->GhiChu = !empty($dv["GhiChu"]) ? $dv["GhiChu"] : null;
        $this->SubData = !empty($dv["SubData"]) ? $dv["SubData"] : null;
        $this->TinhThanh = !empty($dv["TinhThanh"]) ? $dv["TinhThanh"] : 32;
        $this->QuanHuyen = !empty($dv["QuanHuyen"]) ? $dv["QuanHuyen"] : null;
        $this->KhuVuc = !empty($dv["KhuVuc"]) ? $dv["KhuVuc"] : null;
    }

    function TinhThanh() {
        return new \Module\option\Model\TinhThanh($this->TinhThanh);
    }

    public static function TaoKhachHang($maKhachHangTieuDung) {
        $kh["Code"] = $maKhachHangTieuDung;
        $kh["Name"] = "";
        $khachHang = new KhachHangTieuDung();
        $khachHang->InsertRowsTable($kh);
        return self::GetKhachHangByCode($maKhachHangTieuDung);
    }

    public static function GetKhachHangByCode($maKhachHangTieuDung) {
        $khachHang = new KhachHangTieuDung();
        $where = " `Code` = '{$maKhachHangTieuDung}' ";
        return $khachHang->GetRowByWhere($where);
    }

    public static function Update($model) {
        $KH = new KhachHangTieuDung();
        $KH->UpdateSubmit($model);
    }

    public static function KhachHangTieuDungs() {
        $khachHang = new KhachHangTieuDung();
        $where = " `Code` = '{$maKhachHangTieuDung}' ";
        return $khachHang->GetRowByWhere($where);
    }

    public static function KhachHangTieuDungsPt($pageNumber, $Number, &$Tong) {
        $start = ($pageNumber - 1) * $Number;
        $start = max(0, $start);
        $khachHang = new KhachHangTieuDung();
        $where = "`Phone` is not null and `Phone` != '' ";
        $Tong = $khachHang->GetRowsNumber($where);
        $where = "`Phone` is not null and `Phone` != '' limit {$start},{$Number}";
        return $khachHang->GetRowsByWhere($where);
    }

    public function GetByCode($dv) {
        return $this->GetRowByWhere("`Code` = '{$dv}'");
    }

}
?>

