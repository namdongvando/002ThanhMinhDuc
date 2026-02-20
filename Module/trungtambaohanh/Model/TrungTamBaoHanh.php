<?php

namespace Module\trungtambaohanh\Model;

class TrungTamBaoHanh extends TrungTamBaoHanhData
{

    public $Id, $Name, $Address, $Hotline, $TenNhanVien, $KhuVuc, $UserId;

    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Address = !empty($dv["Address"]) ? $dv["Address"] : null;
            $this->Hotline = !empty($dv["Hotline"]) ? $dv["Hotline"] : null;
            $this->TenNhanVien = !empty($dv["TenNhanVien"]) ? $dv["TenNhanVien"] : null;
            $this->KhuVuc = !empty($dv["KhuVuc"]) ? $dv["KhuVuc"] : null;
            $this->UserId = !empty($dv["UserId"]) ? $dv["UserId"] : null;
        }
    }

    public static function TrungTamBaoHanhs()
    {
        $TTKH = new TrungTamBaoHanh();
        return $TTKH->GetAll();
    }

    public function KhuVuc()
    {
        return new \Module\option\Model\Option($this->KhuVuc);
    }
    public function GetToOption()
    {
        return $this->getColumnsOption(["Id", "Name"], "1=1");
    }

}
?>