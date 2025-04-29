<?php

namespace Module\sanpham\Controller;

use Common\Common;
use Exception;
use lib\input;
use Module\khachhang\Model\KhachHangTieuDung;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\TemSanPham;

class tools extends \ApplicationM
{

    static public $UserLayout = "backend";

    function __construct()
    {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    public function index()
    {
        return $this->ViewThemeModlue();
    }
    public function khachhang()
    {
        return $this->ViewThemeModlue();
    }

    public function GetTemChuaKichHoat()
    {
        $total = 0;
        $TemSanPhams = \Module\sanpham\Model\Tools::GetTemChuaKichHoat(1, 100, $total);
        echo json_encode($TemSanPhams);
    }
    public function UpdateTemChuaKichHoat()
    {
        $total = 0;
        $TemSanPhams = \Module\sanpham\Model\Tools::GetTemChuaKichHoat_1(
            1,
            1,
            $total
        );
        if ($TemSanPhams[0]) {
            $temSanPham = new TemSanPham($TemSanPhams[0]);
            $khachHangTieuDung = $temSanPham->KhachHangTieuDung();

            if ($khachHangTieuDung->Code == null) {
                // chưa có mã khách hàng
                $temSanPham->KhachHangTieuDung = $temSanPham->Code;
                $temSanPham->UpdateSubmit($temSanPham->ToArray());
                $KH = KhachHangTieuDung::TaoKhachHangMacDinh($temSanPham->Code);
                if ($KH) {
                    echo $total;
                }
            } else {
                //  đã có mã
                $kh = $temSanPham->KhachHangTieuDung()->GetByCode($temSanPham->KhachHangTieuDung);
                $kh["Name"] = "Khách hàng của Thành Minh Đức";
                $kh["Phone"] = "0329.68.79.89";
                $kh["TinhThanh"] = "32";
                $kh["QuanHuyen"] = "45";
                $kh["DiaChi"] = "Đang cập nhật …";
                $kh["GhiChu"] = 'Nhấn "Sửa thông tin" để khai báo đúng thông tin người sử dụng SP để đảm bảo quyền lợi bảo hành. Hỗ trợ: 0329.68.79.89';
                $kh["Parent"] = "0";
                KhachHangTieuDung::Update($kh);
                echo $total;
            }
            $temSanPham = new TemSanPham($TemSanPhams[0]);
            $temSanPham->UpdateSubmit([
                "Id" => $temSanPham->Id,
                "Status" => 1,
                "NgayBatDau" => Common::DBNow(),
                "ModifyDate" => Common::DBNow()
            ]);
            $temSanPham->UpdateSubmit([
                "Id" => $temSanPham->Id,
                "Status" => 1,
                "NgayKetThuc" => $temSanPham->TinhNgayKetThuc(),
                "ModifyDate" => Common::DBNow()
            ]);

        } else {
            echo $total;
        }
    }

    public function UpdateNgayKichHoat()
    {
        $total = 0;
        $TemSanPhams = \Module\sanpham\Model\Tools::GetTemKichHoatKhongNgay(1, 1, $total);
        if ($TemSanPhams[0]) {
            $temSanPham = new TemSanPham($TemSanPhams[0]);
            $temSanPham->UpdateSubmit([
                "Id" => $temSanPham->Id,
                "Status" => 1,
                "NgayBatDau" => Common::DBNow(),
                "ModifyDate" => Common::DBNow()
            ]);
            $temSanPham->UpdateSubmit([
                "Id" => $temSanPham->Id,
                "NgayKetThuc" => $temSanPham->TinhNgayKetThuc(),
                "ModifyDate" => Common::DBNow()
            ]);
        }
        echo $total;
    }


    public function GetTemChuKichHoatKhongCoThongTinSanPham()
    {
        $TemSanPhams = \Module\sanpham\Model\Tools::GetTemChuKichHoatKhongCoThongTinSanPham();
        echo json_encode($TemSanPhams);
    }
    public function UpdateSanPham()
    {
        $id = $this->getParam(0);
        $sanPham = new SanPham($id);
        echo json_encode((array) $sanPham);
    }
    public function temchuakichhoat()
    {
        return $this->ViewThemeModlue();
    }
    public function temkhongngaykichhoat()
    {
        return $this->ViewThemeModlue();
    }

}
