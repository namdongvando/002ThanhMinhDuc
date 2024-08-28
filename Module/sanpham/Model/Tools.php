<?php
namespace Module\sanpham\Model;

use Core\Adapter;
use datatable\ZendData;

class Tools
{
    //  danh sách các tem "Chưa kích hoạt" có "Ngày bắt đầu" nhỏ hơn "Ngày kết thúc" và không có thông tin sản
    // phẩm
    public static function GetTemChuKichHoatKhongCoThongTinSanPham()
    {
        $where = "Status = 0 and `NgayBatDau` < `NgayKetThuc` AND `MaSanPham` in (SELECT `Id` FROM `thanhminhduc_sanpham` WHERE `Name` = '' or `Name` is null)";
        $Tem = new TemSanPham();
        return $Tem->GetRowsByWhere($where);
    }
    public static function GetTemKichHoatKhongCoThongTinKhachHang()
    {
        $where = " `NgayBatDau` < `NgayKetThuc` AND `KhachHangTieuDung` in (SELECT `Id` FROM `thanhminhduc_khachhang_tieudung` WHERE `Name` = '' or `Name` is null)";
        $Tem = new TemSanPham();
        return $Tem->GetRowsByWhere($where);
    }
    public static function GetTemChuaKichHoat($index = 1, $pageSize = 10, &$Total)
    {
        $index = ($index - 1) * $pageSize;
        $where = "SELECT count(*) as `Tong` FROM `thanhminhduc_tembaohanh` as a , `thanhminhduc_khachhang_tieudung` as b WHERE a.Status != 1 and a.KhachHangTieuDung = b.Code and (a.KhachHangTieuDung is not null or a.KhachHangTieuDung is null or a.KhachHangTieuDung = '') AND (b.Name = '' or b.Name is null)";
        $Tem = new ZendData();
        $TotalCout = $Tem->runsqlToArray($where);
        $Total = $TotalCout[0]["Tong"] ?? 0;
        $where = "SELECT a.* FROM `thanhminhduc_tembaohanh` as a , `thanhminhduc_khachhang_tieudung` as b WHERE a.Status != 1 and a.KhachHangTieuDung = b.Code and (a.KhachHangTieuDung is not null or a.KhachHangTieuDung is null or a.KhachHangTieuDung = '') AND (b.Name = '' or b.Name is null)";
        $where .= " limit {$index},{$pageSize}";
        return $Tem->runsqlToArray($where);
    }
    public static function GetTemChuaKichHoat_1($index = 1, $pageSize = 10, &$Total)
    {
        $temSP = new TemSanPham();
        $items = $temSP->GetByChuaKichHoat($index, $pageSize, $Total);
        return $items;
    }
    public static function GetTemKichHoatKhongNgay($index = 1, $pageSize = 10, &$Total)
    {
        $temSP = new TemSanPham();
        $items = $temSP->GetTemKichHoatKhongNgay($index, $pageSize, $Total);

        return $items;
    }
}

?>