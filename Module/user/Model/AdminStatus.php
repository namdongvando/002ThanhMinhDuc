<?php

namespace Module\user\Model;

class AdminStatus {

    const sXoa = -1;
    const sMoiTao = 0;
    const sActive = 1;

    public $Id, $Name;

    public function __construct($s = null) {
        if ($s) {
            $this->Id = $s["Id"];
            $this->Name = $s["Name"];
        }
    }

    function GetById($Id, $obj = false) {
        $st = $this->GetAdminStatuss();
        if ($obj)
            return new AdminStatus($st[$Id]);
        return $st[$Id];
    }

    function Get2Option() {
        $st = $this->GetAdminStatuss();
        $d = [];
        foreach ($st as $value) {
            $d[$value["Id"]] = $value["Name"];
        }
        return $d;
    }

    function GetAdminStatuss() {
        return [
            self::sXoa => [
                "Id" => self::sXoa
                , "Name" => "Xóa"
            ]
            , self::sMoiTao => [
                "Id" => self::sMoiTao
                , "Name" => "Khóa"
            ]
            , self::sActive => [
                "Id" => self::sActive
                , "Name" => "Kích Hoạt"
            ]
        ];
    }

}
