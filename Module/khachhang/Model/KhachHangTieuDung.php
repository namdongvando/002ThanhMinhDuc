<?php

namespace Module\khachhang\Model;

class KhachHangTieuDung extends KhachHangData {

    public $Id, $Name, $Code, $Phone, $DiaChi, $CMNN, $GhiChu, $SubData;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : "";
            $this->Phone = !empty($dv["Phone"]) ? $dv["Phone"] : null;
            $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
            $this->CMNN = !empty($dv["CMNN"]) ? $dv["CMNN"] : null;
            $this->GhiChu = !empty($dv["GhiChu"]) ? $dv["GhiChu"] : null;
            $this->SubData = !empty($dv["SubData"]) ? $dv["SubData"] : null;
        }
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

    public static function KhachHangTieuDungs() {
        $khachHang = new KhachHangTieuDung();
        $where = " `Code` = '{$maKhachHangTieuDung}' ";
        return $khachHang->GetRowByWhere($where);
    }

    public static function KhachHangTieuDungsPt($pageNumber, $Number, &$Tong) {
        $start = ($pageNumber - 1) * $Number;
        $start = max(0, $start);
        $khachHang = new KhachHangTieuDung();
        $where = " `Phone` is not null and `Phone` != '' ";
        $Tong = $khachHang->GetRowsNumber($where);
        $where = " `Phone` is not null and `Phone` != '' limit {$start},{$Number}";
        return $khachHang->GetRowsByWhere($where);
    }

}
?>

