<?php

namespace Module\sanpham\Model;

class SanPham extends SanPhamData {

    public $Id, $Name, $Code, $Mota, $Gia, $HinhAnh, $DanhMuc;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->Mota = !empty($dv["Mota"]) ? $dv["Mota"] : null;
            $this->Gia = !empty($dv["Gia"]) ? $dv["Gia"] : 0;
            $this->HinhAnh = !empty($dv["HinhAnh"]) ? $dv["HinhAnh"] : null;
            $this->DanhMuc = !empty($dv["DanhMuc"]) ? $dv["DanhMuc"] : null;
        }
    }

    function DanhMuc() {
        return new \Module\option\Model\Option($this->DanhMuc);
    }

    public static function SanPhams() {
        $sanpham = new SanPham();
        $sanpham->GetRows();
    }

    public static function SanPhamsPT($name, $pagesIndex, $pageNumber, &$tong) {
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $sanpham = new SanPham();
        $where = "`Name` like '%{$name}%'";
        $tong = $sanpham->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";
        return $sanpham->GetRowsByWhere($where);
    }

    public function Code($code = null) {
        if ($code == null)
            return $this->Code;
        $this->Code = $code;
    }

    public static function CreateCode() {
        return strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    }

    public function CountRows() {
        return $this->GetRowsNumber();
    }

    public function TemBaoHang() {
        $tem = new TemSanPham();
        $a = $tem->GetById($this->Id);
        if ($a)
            return new TemSanPham($a);
        return null;
    }

    public static function GetItemById($idSanPham) {
        $tem = new SanPham();
        $a = $tem->GetById($idSanPham);
        if ($a)
            return new SanPham($a);
        return null;
    }

    public static function GetItemByCode($idSanPham) {
        $tem = new SanPham();
        $where = "`Code` like '%$idSanPham%'";
        $a = $tem->GetRowByWhere($where);
        return $a;
    }

}
?>

