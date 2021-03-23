<?php

namespace Module\khachhang\Model;

class KhachHang extends KhachHangData {

    const MaDoiTuongKhachHang = "MaPhanLoai";
    const MaNhomKinhDoanh = "MaNhomKinhDoanh";
    const KhuVuc = "KhuVuc";

    public $Id;
    public $Code;
    public $Name;
    public $Parents;
    public $KhuVuc;
    public $ThongTinThanhToan;
    public $LoaiHinhKinhDoanh;
    public $DiaChi;
    public $PhuongXa;
    public $QuanHuyen;
    public $TinhThanh;
    public $LaChuKinhDoanh;
    public $DienThoai;
    public $DiDong;
    public $Zalo;
    public $MaSoThue;
    public $DiaChiGiaoHang;
    public $NhomHangKinhDoanh;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Parents = !empty($dv["Parents"]) ? $dv["Parents"] : null;
            $this->KhuVuc = !empty($dv["KhuVuc"]) ? $dv["KhuVuc"] : null;
            $this->ThongTinThanhToan = !empty($dv["ThongTinThanhToan"]) ? $dv["ThongTinThanhToan"] : null;
            $this->LoaiHinhKinhDoanh = !empty($dv["LoaiHinhKinhDoanh"]) ? $dv["LoaiHinhKinhDoanh"] : null;
            $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
            $this->PhuongXa = !empty($dv["PhuongXa"]) ? $dv["PhuongXa"] : null;
            $this->QuanHuyen = !empty($dv["QuanHuyen"]) ? $dv["QuanHuyen"] : null;
            $this->TinhThanh = !empty($dv["TinhThanh"]) ? $dv["TinhThanh"] : null;
            $this->LaChuKinhDoanh = !empty($dv["LaChuKinhDoanh"]) ? $dv["LaChuKinhDoanh"] : null;
            $this->DienThoai = !empty($dv["DienThoai"]) ? $dv["DienThoai"] : null;
            $this->DiDong = !empty($dv["DiDong"]) ? $dv["DiDong"] : null;
            $this->Zalo = !empty($dv["Zalo"]) ? $dv["Zalo"] : null;
            $this->MaSoThue = !empty($dv["MaSoThue"]) ? $dv["MaSoThue"] : null;
            $this->DiaChiGiaoHang = !empty($dv["DiaChiGiaoHang"]) ? $dv["DiaChiGiaoHang"] : null;
            $this->NhomHangKinhDoanh = !empty($dv["NhomHangKinhDoanh"]) ? $dv["NhomHangKinhDoanh"] : null;
        }
    }

    public static function KhachHangs() {
        $Kh = new KhachHang();
        return $Kh->GetRows();
    }

    public static function GetALL2Options() {
        $Kh = new KhachHang();
        return $Kh->GetAll2Option();
    }

    public static function GetKhachHangById($id) {
        $Kh = new KhachHang();
        return $Kh->GetById($id);
    }

}
?>

