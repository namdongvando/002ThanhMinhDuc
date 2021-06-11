<?php

namespace Module\sanpham;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "index" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
                "form",
            ],
            "kho" => [
                "index",
                "resettem",
                "create",
                "delete",
                "detail",
                "edit",
            ],
            "taosanpham" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
                "edit",
                "nhansp",
            ], "temsanpham" => [
                "index",
                "create",
                "delete",
                "detailbysanpham",
                "detail",
                "export",
                "zipfile",
                "exporttoFire",
                "edit",
                "quanlytem",
                "TinhSoNgay",
            ]
        ];
    }

    public function Router() {

    }

}
