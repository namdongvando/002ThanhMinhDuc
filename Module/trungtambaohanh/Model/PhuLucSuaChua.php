<?php

namespace Module\trungtambaohanh\Model;

class PhuLucSuaChua extends PhuLucSuaChuaData {

    const BepDien = "BD";
    const BepGaAm = "BGA";
    const MayHutKhoi = "MHK";

    public $Id, $Code, $Name, $DonGia, $LinhKien, $YeuCau, $GiaLinhKien;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->DonGia = !empty($dv["DonGia"]) ? $dv["DonGia"] : null;
            $this->LinhKien = !empty($dv["LinhKien"]) ? $dv["LinhKien"] : null;
            $this->YeuCau = !empty($dv["YeuCau"]) ? $dv["YeuCau"] : null;
            $this->GiaLinhKien = !empty($dv["GiaLinhKien"]) ? $dv["GiaLinhKien"] : null;
        }
    }

    public static function PhuLucSuaChuas() {
        $TTKH = new PhuLucSuaChua();
        return $TTKH->GetAll();
    }

    public static function LoaiPhuLuc2Option() {
        return \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::PhuLucLoai);
    }

    public function DonGiaVND() {
        return number_format($this->DonGia, 0, ",", ".") . "<sup>đ</sup>";
    }

}
?>

