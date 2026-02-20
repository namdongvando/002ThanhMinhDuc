<?php

namespace Module\sanpham\Model;

use Module\option\Model\TinhThanh;

class YeuCauKichHoat extends YeuCauKichHoatData
{
    const MoiTao = "MoiTao";
    const KichHoat = "KichHoat";
    const HuyKichHoat = "HuyKichHoat";
    public $Id, $Code, $HoTen, $SDT, $IsDelete, $MaTem, $TinhThanh, $QuanHuyen, $DiaChi, $TinhTrang, $RecCreateDate, $RecUpdateDate;

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
            $this->HoTen = $dv["HoTen"] ?? null;
            $this->SDT = $dv["SDT"] ?? null;
            $this->MaTem = $dv["MaTem"] ?? null;
            $this->TinhThanh = $dv["TinhThanh"] ?? null;
            $this->QuanHuyen = $dv["QuanHuyen"] ?? null;
            $this->DiaChi = $dv["DiaChi"] ?? null;
            $this->TinhTrang = $dv["TinhTrang"] ?? null;
            $this->RecCreateDate = $dv["RecCreateDate"] ?? null;
            $this->RecUpdateDate = $dv["RecUpdateDate"] ?? null;
            $this->IsDelete = $dv["IsDelete"] ?? null;
        }
    }
    public function RecCreateDate()
    {
        return date("H:i d-m-Y", strtotime($this->RecCreateDate));
    }
    public function TinhTrang()
    {
        return $this->GetStatusName($this->TinhTrang)["Name"];
    }

    public function TemSanPham()
    {
        return new TemSanPham($this->MaTem);
    }

    public function GetStatusName($id = null)
    {
        $a = [
            self::MoiTao => [
                "Id" => self::MoiTao,
                "Name" => "Yêu cầu",
                "Des" => "Yêu cầu kích hoạt"
            ],
            self::KichHoat => [
                "Id" => self::KichHoat,
                "Name" => "Đồng Ý ",
                "Des" => "Đồng Ý kích hoạt"
            ],
            self::HuyKichHoat => [
                "Id" => self::HuyKichHoat,
                "Name" => "Không Đồng Ý",
                "Des" => "Không Đồng Ý kích hoạt"
            ]
        ];
        if ($id == null) {
            return $a;
        }
        return $a[$id];
    }
    public function TinhThanh()
    {
        return new TinhThanh($this->TinhThanh);
    }
    public function QuanHuyen()
    {
        return new TinhThanh($this->QuanHuyen);
    }
    public static function GetRowsPT($name, $pagesIndex, $pageNumber, &$tong)
    {
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $sanpham = new TemSanPham();
        $where = " `Name` like '%{$name}%' ";
        $tong = $sanpham->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";
        return $sanpham->GetRowsByWhere($where);
    }

    public function Code($code = null)
    {
        if ($code == null)
            return $this->Code;
        $this->Code = $code;
    }

    public static function GetStatus()
    {
        return [
            self::MoiTao => "MoiTao",
            self::KichHoat => "KichHoat",
            self::HuyKichHoat => "HuyKichHoat",
        ];
    }

    public static function CreateCode()
    {
        return strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    }

    public function CountRows()
    {
        return $this->GetRowsNumber();
    }
    public function GetByCode($code)
    {
        $where = "`Code` = '{$code}'";
        return $this->GetRowByWhere($where);
    }
}
