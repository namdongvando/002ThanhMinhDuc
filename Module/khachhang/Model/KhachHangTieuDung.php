<?php

namespace Module\khachhang\Model;

class KhachHangTieuDung extends KhachHangTieuDungData {

    public $Id, $KhuVuc, $Name, $Code, $Phone, $DiaChi, $CMNN, $GhiChu, $SubData, $TinhThanh, $QuanHuyen, $PhuongXa;

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
            $this->TinhThanh = !empty($dv["TinhThanh"]) ? $dv["TinhThanh"] : null;
            $this->QuanHuyen = !empty($dv["QuanHuyen"]) ? $dv["QuanHuyen"] : null;
            $this->PhuongXa = !empty($dv["PhuongXa"]) ? $dv["PhuongXa"] : null;
            $this->KhuVuc = !empty($dv["KhuVuc"]) ? $dv["KhuVuc"] : null;
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

}
?>

