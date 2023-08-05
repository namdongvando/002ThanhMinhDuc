<?php

namespace Module\trungtambaohanh\Model;

use lib\redDirectory;
use Module\option\Model\Option;

class YeuCauBaoHanh extends YeuCauBaoHanhData
{

    public $Id,
    $Code,
    $Name,
    $IdTrungTamBaoHanh,
    $Status,
    $TinhThanh,
    $QuanHuyen,
    $KhachHangTieuDung,
    $MaTem,
    $SDT,
    $DiaChi,
    $idNhanVien,
    $NgayBaoHanh,
    $NoiDung,
    $HinhAnh,
    $NoiDungKhac,
    $CreateDate,
    $UpdateDate;

    const MoiTao = "MoiTao";
    const DangXuLy = "DangXuLy";
    const YeuCauKiemTra = "YeuCauKiemTra";
    const DaXuLy = "DaXuLy";

    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $code = $dv;
                $dv = $this->GetById($code);
                if (!$dv) {
                    $dv = $this->GetByCode($code);
                }
            }
            $this->Id = $dv["Id"] ?? null;
            $this->Code = $dv["Code"] ?? null;
            $this->Name = $dv["Name"] ?? null;
            $this->TinhThanh = $dv["TinhThanh"] ?? null;
            $this->QuanHuyen = $dv["QuanHuyen"] ?? null;
            $this->KhachHangTieuDung = $dv["KhachHangTieuDung"] ?? null;
            $this->SDT = $dv["SDT"] ?? null;
            $this->Status = $dv["Status"] ?? null;
            $this->IdTrungTamBaoHanh = $dv["IdTrungTamBaoHanh"] ?? null;
            $this->MaTem = $dv["MaTem"] ?? null;
            $this->DiaChi = $dv["DiaChi"] ?? null;
            $this->idNhanVien = $dv["idNhanVien"] ?? null;
            $this->NgayBaoHanh = $dv["NgayBaoHanh"] ?? null;
            $this->NoiDung = $dv["NoiDung"] ?? null;
            $this->NoiDungKhac = $dv["NoiDungKhac"] ?? null;
            $this->HinhAnh = $dv["HinhAnh"] ?? null;
            $this->CreateDate = $dv["CreateDate"] ?? null;
            $this->UpdateDate = $dv["UpdateDate"] ?? null;
        }
    }


    function GetItems($params, $indexPage = 1, $numberPage = 10, &$total)
    {


        $where = "1=1";

        return $this->GetRowsTablePt($where, $indexPage, $numberPage, $total);
    }

    function KhachHangTieuDung()
    {
        return new \Module\khachhang\Model\KhachHangTieuDung($this->KhachHangTieuDung);
    }

    function NoiDungBaoHanh()
    {

        if ($this->NoiDung == "Khac") {
            return new Option(["Name" => $this->NoiDungKhac]);
        }
        return new \Module\option\Model\Option(
            \Module\option\Model\Option::GetOptionByGroupsCode(
                \Module\option\Model\Option::SuCoMacPhai, $this->NoiDung
            )
        );
    }

    public static function YeuCauSuaChuas()
    {
        $TTKH = new YeuCauBaoHanh();

        if (\Module\user\Model\Admin::CheckQuyen([\Module\user\Model\Admin::SuperAdmin, \Module\user\Model\Admin::TTBH, \Module\user\Model\Admin::Admin])) {
            $lisStaTus = [self::MoiTao, self::DangXuLy, self::DaXuLy];
            $lisStaTus = implode("','", $lisStaTus);
            $where = "Status in ('{$lisStaTus}')  order by `CreateDate` DESC";
        } else {
            $lisStaTus = [self::MoiTao, self::DangXuLy];
            $lisStaTus = implode("','", $lisStaTus);
            $idNhanVien = \Module\user\Model\Admin::getCurentUser(true)->Id;
            $where = "Status in ('{$lisStaTus}') and `idNhanVien` = '{$idNhanVien}' order by `CreateDate` DESC";
        }

        return $TTKH->GetRowsByWhere($where);
    }

    public static function ListStatusToOption()
    {
        $listStatus = self::ListStatus();
        $options = [];
        foreach ($listStatus as $key => $value) {
            $option["id"] = $key;
            $option["name"] = $value;
            $options[] = $option;
        }
        return $options;
    }

    public static function ListStatus()
    {
        return [
            self::MoiTao => "Mới Tạo",
            self::DangXuLy => "Đang Xử Lý",
            self::YeuCauKiemTra => "Yêu cầu xử lý",
            self::DaXuLy => "Đã Xử Lý"
        ];
    }

    public function Status()
    {
        if (isset(self::ListStatus()[$this->Status]))
            return self::ListStatus()[$this->Status];
    }

    public static function GetByCode($code)
    {
        $TTKH = new YeuCauBaoHanh();
        $where = "`Code` = '{$code}' ";
        return $TTKH->GetRowByWhere($where);
    }

    public function UpdateStatus($id, $ModelUpdate)
    {
        $a = self::GetByCode($id);
        $a["Status"] = $ModelUpdate["Status"];
        $a["IdTrungTamBaoHanh"] = $ModelUpdate["IdTrungTamBaoHanh"];
        $a["idNhanVien"] = $ModelUpdate["idNhanVien"];
        $this->UpdateRowTable($a, "`Code` = '{$id}'");
    }

    public function TemSanPham()
    {
        return new \Module\sanpham\Model\TemSanPham($this->MaTem);
    }

    function PhuongAnXuLy()
    {
        $XuLyYeuCau = new XuLyYeuCau();
        $PN = $XuLyYeuCau->GetByStatus($this->Code, "PhuongAnXuLy");
        return new XuLyYeuCau($PN);
    }
    function KetQuaXuLy()
    {
        $XuLyYeuCau = new XuLyYeuCau();
        $PN = $XuLyYeuCau->GetByStatus($this->Code, "KetQuaBaoHanh");
        return new XuLyYeuCau($PN);
    }
    function ToArray()
    {
        $a["Id"] = $this->Id;
        $a["Code"] = $this->Code;
        $a["Name"] = $this->Name;
        $a["TinhThanh"] = $this->TinhThanh;
        $a["QuanHuyen"] = $this->QuanHuyen;
        $a["KhachHangTieuDung"] = $this->KhachHangTieuDung;
        $a["SDT"] = $this->SDT;
        $a["Status"] = $this->Status;
        $a["IdTrungTamBaoHanh"] = $this->IdTrungTamBaoHanh;
        $a["MaTem"] = $this->MaTem;
        $a["DiaChi"] = $this->DiaChi;
        $a["idNhanVien"] = $this->idNhanVien;
        $a["NgayBaoHanh"] = $this->NgayBaoHanh;
        $a["NoiDung"] = $this->NoiDung;
        $a["NoiDungKhac"] = $this->NoiDungKhac;
        $a["HinhAnh"] = $this->HinhAnh;
        $a["CreateDate"] = $this->CreateDate;
        $a["UpdateDate"] = $this->UpdateDate;
        return $a;
    }

    function DanhSachHinh()
    {
        $yeuCauCode = $this->Code;
        $path = "public/baohanh/{$yeuCauCode}/";
        $a = [];
        (new redDirectory())->redDirectoryByFullPath($path, $a);
        return $a;
    }

    function Logs()
    {
        $log = new YeuCauBaoHanhLogData();
        return $log->GetAllByCode($this->Code);

    }

}