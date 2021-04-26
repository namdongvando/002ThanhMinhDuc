<?php

namespace Module\option\Model;

class Option extends OptionData {

    const MaDoiTuongKhachHang = "MaPhanLoai";
    const MaNhomKinhDoanh = "MaNhomKinhDoanh";
    const KhuVuc = "KhuVuc";
    const NganHang = "NganHang";
    const SuCoMacPhai = "SuCoMacPhai";
    const ChungLoaiSP = "ChungLoaiSP";
    const DanhMucVatTu = "DanhMucVatTu";
    const PhuLucLoai = "PhuLucLoai";

    public
            $Id,
            $Name,
            $Code,
            $Groups,
            $Note,
            $Parents,
            $OrderBy;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $code = $dv;
                $dv = $this->GetById($dv);
                if (!$dv) {
                    $dv = $this->GetByCode($code);
                }
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Code = $dv["Code"];
            $this->Groups = $dv["Groups"];
            $this->Note = $dv["Note"];
            $this->Parents = $dv["Parents"];
            $this->OrderBy = $dv["OrderBy"];
        }
    }

    public static function GetTinhThanh($parents) {
        $TinhThanh = new TinhThanh();
        return $TinhThanh->GetByIdP($parents);
    }

    public static function GetTinhThanh2Option($parents) {
        $TinhThanh = new TinhThanh();
        return $TinhThanh->GetAll2Option($parents);
    }

    public static function OptionByGroups($groups) {
        $Option = new Option();
        return $Option->GetRowsByWhere("`Groups` = '{$groups}'");
    }

    public static function GetGroupsOption() {
        return [
            self::DanhMucVatTu => "Danh Mục Vật Tư",
            self::KhuVuc => "Khu Vực"
            , self::MaDoiTuongKhachHang => "Đối Tượng Khách Hàng"
            , self::MaNhomKinhDoanh => "Nhóm Kinh Doanh"
            , self::NganHang => "Ngân Hàng"
            , self::SuCoMacPhai => "Sự Cố Mắc Phải"
            , self::ChungLoaiSP => "Chung Loại Sản Phẩm"
            , self::PhuLucLoai => "Loại Phụ Lục Chi Phí Sửa Chữa"
        ];
    }

    public static function GetAll2Options($array = null) {

        $Option = new Option();
        return $Option->GetAll2Option(null, $array);
    }

    public static function GetAll2OptionsByGroups($groups) {
        $Option = new Option();
        return $Option->GetAll2Option($groups);
    }

    public static function GetAll2OptionsByGroupsID($groups) {
        $Option = new Option();
        return $Option->GetAll2OptionId($groups);
    }

    public static function GetOptions() {
        $Option = new Option();
        return $Option->GetAll();
    }

    public function GetByCode($dv) {
        return $this->GetRowByWhere(" `Code` = '{$dv}'");
    }

    public static function GetOptionsByGroups($groups) {
        $option = new Option();
        return $option->GetRowsByWhere("`Groups` = '{$groups}'");
    }

    public function Parents() {
        return new Option($this->GetById($this->Parents));
    }

}
?>

