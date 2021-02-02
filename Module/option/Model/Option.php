<?php

namespace Module\option\Model;

class Option extends OptionData {

    const MaDoiTuongKhachHang = "MaPhanLoai";
    const MaNhomKinhDoanh = "MaNhomKinhDoanh";
    const KhuVuc = "KhuVuc";
    const NganHang = "NganHang";
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
                $dv = $this->GetById($dv);
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
            , self::PhuLucLoai => "Loại Phụ Lục Chi Phí Sửa Chữa"
        ];
    }

    public static function GetAll2Options() {
        $Option = new Option();
        return $Option->GetAll2Option();
    }

    public static function GetAll2OptionsByGroups($groups) {
        $Option = new Option();
        return $Option->GetAll2Option($groups);
    }

    public static function GetOptions() {
        $Option = new Option();
        return $Option->GetAll();
    }

}
?>

