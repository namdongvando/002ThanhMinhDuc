<?php

namespace Module\trungtambaohanh\Model;

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
        $NgayBaoHanh,
        $NoiDung,
        $CreateDate,
        $UpdateDate;

    const MoiTao = "MoiTao";
    const DangXuLy = "DangXuLy";
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
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->TinhThanh = !empty($dv["TinhThanh"]) ? $dv["TinhThanh"] : null;
            $this->QuanHuyen = !empty($dv["QuanHuyen"]) ? $dv["QuanHuyen"] : null;
            $this->KhachHangTieuDung = !empty($dv["KhachHangTieuDung"]) ? $dv["KhachHangTieuDung"] : null;
            $this->SDT = !empty($dv["SDT"]) ? $dv["SDT"] : null;
            $this->Status = !empty($dv["Status"]) ? $dv["Status"] : null;
            $this->IdTrungTamBaoHanh = !empty($dv["IdTrungTamBaoHanh"]) ? $dv["IdTrungTamBaoHanh"] : null;
            $this->MaTem = !empty($dv["MaTem"]) ? $dv["MaTem"] : null;
            $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
            $this->NgayBaoHanh = !empty($dv["NgayBaoHanh"]) ? $dv["NgayBaoHanh"] : null;
            $this->NoiDung = !empty($dv["NoiDung"]) ? $dv["NoiDung"] : null;
            $this->CreateDate = !empty($dv["CreateDate"]) ? $dv["CreateDate"] : null;
            $this->UpdateDate = !empty($dv["UpdateDate"]) ? $dv["UpdateDate"] : null;
        }
    }

    function KhachHangTieuDung()
    {
        return new \Module\khachhang\Model\KhachHangTieuDung($this->KhachHangTieuDung);
    }

    function NoiDungBaoHanh()
    {
        return new \Module\option\Model\Option(\Module\option\Model\Option::GetOptionByGroupsCode(\Module\option\Model\Option::SuCoMacPhai, $this->NoiDung));
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

    function ToArray()
    {
        return (array) $this;
    }
}
