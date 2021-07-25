<?php

namespace Module\sanpham\Model;

class TemSanPham extends TemSanPhamData {

    const Active = 1;
    const DeActive = 0;
    const Huy = -1;

    public $Id, $Name, $Code, $MaSanPham, $KhachHangTieuDung, $NgayBatDau, $ThangKetThuc, $NgayKetThuc, $Status, $UserId, $CreateDate, $ModifyDate;

    public function __construct($dv = null) {
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
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->MaSanPham = !empty($dv["MaSanPham"]) ? $dv["MaSanPham"] : null;
            $this->KhachHangTieuDung = !empty($dv["KhachHangTieuDung"]) ? $dv["KhachHangTieuDung"] : null;
            $this->NgayBatDau = !empty($dv["NgayBatDau"]) ? $dv["NgayBatDau"] : date("Y-m-d H:i:s", time());
            $this->NgayKetThuc = !empty($dv["NgayKetThuc"]) ? $dv["NgayKetThuc"] : null;
            $this->ThangKetThuc = !empty($dv["ThangKetThuc"]) ? $dv["ThangKetThuc"] : 24;
            $this->Status = !empty($dv["Status"]) ? $dv["Status"] : 0;
            $this->UserId = !empty($dv["UserId"]) ? $dv["UserId"] : 0;
            $this->CreateDate = !empty($dv["CreateDate"]) ? $dv["CreateDate"] : null;
            $this->ModifyDate = !empty($dv["ModifyDate"]) ? $dv["ModifyDate"] : null;
            $this->Parents = !empty($dv["Parents"]) ? $dv["Parents"] : null;
            $this->IsPrint = !empty($dv["IsPrint"]) ? $dv["IsPrint"] : null;
        }
    }

    public static function GetRowsPT($name, $pagesIndex, $pageNumber, &$tong) {
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $sanpham = new TemSanPham();
        $where = " `Name` like '%{$name}%' ";
        $tong = $sanpham->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";
        return $sanpham->GetRowsByWhere($where);
    }

    public function Code($code = null) {
        if ($code == null)
            return $this->Code;
        $this->Code = $code;
    }

    public static function GetStatus() {
        return [
            self::Active => "Kích Hoạt",
            self::DeActive => "Chưa Kích Hoạt",
        ];
    }

    public static function CreateCode() {
        return strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    }

    public function CountRows() {
        return $this->GetRowsNumber();
    }

    public static function GetBySanPham($idSP) {
        $temsp = new TemSanPham();
        $where = "`MaSanPham` = {$idSP}";
        return $temsp->GetRowByWhere($where);
    }

    public static function GetByCode($code) {
        $temsp = new TemSanPham();
        $where = "`Code` = '{$code}'";
        return $temsp->GetRowByWhere($where);
    }

    public static function TaoTemSanPham($idSanPham, $maKhachHangTieuDung = null) {
        $temsp = new TemSanPham();
        $MSanPham = new SanPham($idSanPham);
        $row["Name"] = $MSanPham->Name;
        $row["MaSanPham"] = $MSanPham->Id;
        $row["Status"] = TemSanPham::DeActive;
        $row["UserId"] = 0;
        $row["CreateDate"] = date("Y-m-d H:i:s");
        $row["ModifyDate"] = date("Y-m-d H:i:s");
        $temsp->InsertRowsTable($row);
        return $temsp->GetBySanPham($idSanPham);
    }

    function SanPham() {

//if ($temSanPham["MaSanPham"] == 0) {
//            $idSP = $sanPham->TaoSanPham($temSanPham["Code"]);
//            $temSanPham["MaSanPham"] = $idSP;
//            $ModelTemSanPham->UpdateSubmit($temSanPham);
//        }
        $sanPham = new SanPham();
        if ($this->MaSanPham == 0) {
            $ModelTemSanPham = new TemSanPham();
            $temSanPham = \Module\sanpham\Model\TemSanPham::GetByCode($this->Code);
            $idSP = $sanPham->TaoSanPham($temSanPham["Code"]);
            $temSanPham["MaSanPham"] = $idSP;
            $ModelTemSanPham->UpdateSubmit($temSanPham);
        }
        $sp = $sanPham->GetById($this->MaSanPham);
        return new SanPham($sp);
    }

    public function Status() {
        $st = json_decode(json_encode($this->GetStatusObj(), JSON_UNESCAPED_UNICODE));
        if ($this->Status == self::Active) {
            return $st->Active;
        } else {
            return $st->DeActive;
        }
    }

    public function GetStatusObj() {
        return [
            "Active" =>
            ["Id" => self::Active,
                "Name" => "Kích Hoạt",
            ]
            , "DeActive" =>
            ["Id" => self::DeActive,
                "Name" => "Chưa Kích Hoạt",
            ]
        ];
    }

    public static function GetByCodeSanPham($idSanPham) {
        $sanpham = new SanPham();
        $where = " `Code` = '{$idSanPham}'";
        $_sanpham = $sanpham->GetRowByWhere($where);
        if ($_sanpham) {
            $idSP = $_sanpham["Id"];
            return TemSanPham::GetBySanPham($idSP);
        }
        return [];
    }

    public function UserId() {
        if ($this->UserId > 0)
            return new \Module\user\Model\Admin($this->UserId);
        return new \Module\user\Model\Admin(null);
    }

    public function ModifyDate() {
        return date("d-m-Y", strtotime($this->ModifyDate));
    }

    public function NgayKetThuc() {
        if ($this->NgayKetThuc)
            return date("d-m-Y", strtotime($this->NgayKetThuc));
        return "Chưa cấu hình";
    }

    public function NgayBatDau() {
        return date("d-m-Y", strtotime($this->NgayBatDau));
    }

    public function CreateDate() {
        return date("d-m-Y", strtotime($this->CreateDate));
    }

    public function ThangKetThuc() {
        if ($this->ThangKetThuc)
            return $this->ThangKetThuc . ' Tháng';
        return "Chưa cấu hình";
    }

}
?>

