<?php

namespace Module\dashboard\Controller;

use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\YeuCauKichHoat as ModelYeuCauKichHoat;
use Module\khachhang\Model\KhachHang;
use Module\khachhang\Model\KhachHangTieuDung;
use Module\sanpham\Model\TemSanPham;

class yeucaukichhoat extends \ApplicationM
{

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    function __construct()
    {
        new \Controller\backend();
    }

    function index()
    {

        return $this->ViewThemeModlue([], null, "");
    }
    function put()
    {

        return $this->ViewThemeModlue([], null, "");
    }
    function dongy()
    {
        // cập nhật yêu cầu
        $id = $_GET["mayeucau"];

        $ngaybatdau = date("Y-m-d", strtotime($_GET["ngaybatdau"]));
        $yeuCau = new ModelYeuCauKichHoat($id);
        $yc = $yeuCau->GetByCode($id);
        $yc["TinhTrang"] = ModelYeuCauKichHoat::KichHoat;
        $yeuCau->UpdateSubmit($yc);
        //  cập nhật thông tin tem sản phẩm
        $khTieuDung = new KhachHangTieuDung($yeuCau->MaTem);
        $khtd["Name"] = $yeuCau->HoTen;
        $khtd["Code"] = $yeuCau->MaTem;
        $khtd["Phone"] = $yeuCau->SDT;
        $khtd["DiaChi"] = $yeuCau->DiaChi;
        $khtd["CMNN"] = "";
        $khtd["GhiChu"] = "";
        $khtd["SubData"] = "";
        $khtd["TinhThanh"] = $yeuCau->TinhThanh;
        $khtd["KhuVuc"] = "";
        $khtd["QuanHuyen"] = $yeuCau->QuanHuyen;
        $khtd["Parent"] = 0;

        if ($khTieuDung->Id == null) {
            $khTieuDung->InsertSubmit($khtd);
        } else {
            $khtd["Id"] = $khTieuDung->Id;
            $khTieuDung->UpdateSubmit($khtd);
        }
        $khTieuDung = new KhachHangTieuDung($khtd["Code"]);
        $temsp = new TemSanPham($yeuCau->MaTem);
        $item = $temsp->GetByCode($yeuCau->MaTem);
        $item["NgayBatDau"] = $ngaybatdau;
        $ngaybd = strtotime($item["NgayBatDau"]);
        $item["KhachHangTieuDung"] = $khTieuDung->Code;
        $ngayKetThuc = date("Y-m-d", $ngaybd  + (730 * 24 *  3600));
        $item["NgayKetThuc"] = $ngayKetThuc;
        $item["Status"] = TemSanPham::Active;
        $temsp->UpdateSubmit($item);
        echo json_encode($item, JSON_UNESCAPED_UNICODE);
    }
    function lamlai()
    {
        // cập nhật yêu cầu
        $id =  $this->getParam(0);
        $yeuCau = new ModelYeuCauKichHoat($id);
        $yc = $yeuCau->GetByCode($id);
        $yc["TinhTrang"] = ModelYeuCauKichHoat::MoiTao;
        $yeuCau->UpdateSubmit($yc);
        //  cập nhật thông tin tem sản phẩm
        $temsp = new TemSanPham($yeuCau->MaTem);
        $khTieuDung = new KhachHangTieuDung($temsp->KhachHangTieuDung);
        // xóa khách hàng cũ
        $khTieuDung->DeleteSubmit($temsp->KhachHangTieuDung);
        $temsp = new TemSanPham($yeuCau->MaTem);
        $model["Id"] = $temsp->Id;
        $model["Status"] = TemSanPham::YeuCauKichHoat;
        $temsp->UpdateSubmit($model);
        echo json_encode($yc, JSON_UNESCAPED_UNICODE);
    }
    function tuchoi()
    {
        // cập nhật yêu cầu
        $id =  $this->getParam(0);
        $yeuCau = new ModelYeuCauKichHoat($id);
        $yc = $yeuCau->GetByCode($id);
        $yc["TinhTrang"] = ModelYeuCauKichHoat::HuyKichHoat;
        $yeuCau->UpdateSubmit($yc);
        //  cập nhật thông tin tem sản phẩm
        $temsp = new TemSanPham($yeuCau->MaTem);
        $khTieuDung = new KhachHangTieuDung($temsp->KhachHangTieuDung);
        // xóa khách hàng cũ
        $khTieuDung->DeleteSubmit($temsp->KhachHangTieuDung);
        $temsp = new TemSanPham($yeuCau->MaTem);
        $model["Id"] = $temsp->Id;
        $model["Status"] = TemSanPham::YeuCauKichHoat;
        $temsp->UpdateSubmit($model);
        echo json_encode($yc, JSON_UNESCAPED_UNICODE);
    }
}
