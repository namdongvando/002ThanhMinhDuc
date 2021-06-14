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
            $this->TinhThanh = !empty($dv["TinhThanh"]) ? $dv["TinhThanh"] : 32;
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

    function Parents() {
        if ($this->Parents == 0)
            return new KhachHang();
        return new KhachHang($this->Parents);
    }

    public static function GetKhachHangById($id, $isDecode = false) {
        $Kh = new KhachHang();
        if ($isDecode) {
            $where = "sha1(`id`) = '{$id}'";
            return $Kh->GetRowByWhere($where);
        }
        return $Kh->GetById($id);
    }

    public function KhachHangThanhToan() {
        return new KhachHangThanhToan(KhachHangThanhToan::GetByMaKhachHang($this->Code));
    }

    public function KhuVuc() {
        $options = new \Module\rmm\Model\Option();
        $Groups = \Module\option\Model\Option::KhuVuc;
        $where = "`Code` = '{$this->KhuVuc}' and `Groups`='{$Groups}'";
        return new \Module\option\Model\Option($options->GetRowByWhere($where));
//        return $options->;
    }

    public function TinhThanh() {
        $tinhThanh = new \Module\option\Model\TinhThanh();
        $tinhThanh = $tinhThanh->GetById($this->TinhThanh);
        return new \Module\option\Model\TinhThanh($tinhThanh);
    }

    public function QuanHuyen() {
        $tinhThanh = new \Module\option\Model\TinhThanh();
        $tinhThanh = $tinhThanh->GetById($this->QuanHuyen);
        return new \Module\option\Model\TinhThanh($tinhThanh);
    }

    public static function KhachHangsPT($name = "", $pagesIndex, $pageNumber, &$tong) {
        $Kh = new KhachHang();
        $pagesIndex = max($pagesIndex, 1);
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $where = " 1";
        if ($name != "") {
            $where = "`Name` like '%{$name}%' or `Code` like '%{$name}%'";
        }
        $tong = $Kh->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";

        return $Kh->GetRowsByWhere($where);
    }

    public function LinkChiTiet() {
        return "/khachhang/index/edit/" . sha1($this->Id);
    }

}
?>

