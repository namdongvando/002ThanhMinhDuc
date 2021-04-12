<?php

namespace Module\sanpham\Model;

class SanPham extends SanPhamData {

    const DangOCty = 0;
    const DangODaiLy = 1;
    const DangOChiNhanh = 2;
    const DangSuDung = 3;

    public $Id, $Name, $Code, $ChungLoaiSP, $Mota, $Gia, $HinhAnh, $DanhMuc, $TinhTrang;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->ChungLoaiSP = !empty($dv["ChungLoaiSP"]) ? $dv["ChungLoaiSP"] : null;
            $this->Mota = !empty($dv["Mota"]) ? $dv["Mota"] : null;
            $this->Gia = !empty($dv["Gia"]) ? $dv["Gia"] : 0;
            $this->HinhAnh = !empty($dv["HinhAnh"]) ? $dv["HinhAnh"] : null;
            $this->DanhMuc = !empty($dv["DanhMuc"]) ? $dv["DanhMuc"] : null;
            $this->TinhTrang = !empty($dv["TinhTrang"]) ? $dv["TinhTrang"] : 0;
        }
    }

    function DanhMuc() {
        return new \Module\option\Model\Option($this->DanhMuc);
    }

    public static function ListTinhTrang() {
        return [
            self::DangOCty => "Đang Ở Công Ty",
            self::DangODaiLy => "Đang Ở Đại Lý",
            self::DangOChiNhanh => "Đang Chi Nhánh",
            self::DangSuDung => "Đang Sử Dụng",
        ];
    }

    public function TinhTrang() {
        return self::ListTinhTrang()[$this->TinhTrang];
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

    public function TemBaoHanh() {
        $tem = new TemSanPham();
        $a = $tem->GetBySanPham($this->Id);
        if ($a)
            return new TemSanPham($a);
        return null;
    }

    public function TemBaoHang() {
        $tem = new TemSanPham();
        $a = $tem->GetBySanPham($this->Id);
        if ($a)
            return new TemSanPham($a);
        return null;
    }

    public static function GetItemById($idSanPham) {
        $tem = new SanPham();
        $a = $tem->GetById($idSanPham);
        if ($a)
            return new SanPham($a);
        return new SanPham();
    }

    public static function GetItemByCode($idSanPham) {
        $tem = new SanPham();
        $where = "`Code` like '%$idSanPham%'";
        $a = $tem->GetRowByWhere($where);
        return $a;
    }

    public static function ListTinhTrangToOptions() {
        $lisTinhTrang = self::ListTinhTrang();
        $options = [];
        foreach ($lisTinhTrang as $key => $value) {
//            $option["Id"] = $key;
//            $option["Name"] = $value;
            $options[$key] = $value;
        }
        return $options;
    }

    public function TaoSanPham($code) {
        $a = self::GetByCode($code);
        if ($a)
            return;
        $sanPham["Code"] = $code;
        $sanPham["Name"] = "";
        $sanPham["MoTa"] = "";
        $sanPham["Gia"] = 0;
        $sanPham["ChungLoaiSP"] = "";
        $sanPham["HinhAnh"] = "";
        $sanPham["DanhMuc"] = "";
        $sanPham["idKhachHang"] = 0;
        $sanPham["TinhTrang"] = SanPham::DangOCty;
        return $this->InsertSubmit($sanPham);
    }

    public static function GetByCode($code) {
        $where = "`Code` like '{$code}'";
        $SanPham = new SanPham();
        $a = $SanPham->GetRowByWhere($where);
        return $a;
    }

}
?>

