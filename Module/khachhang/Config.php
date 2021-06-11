<?php

namespace Module\khachhang;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "api" => ["TokenDeCode"],
            "index" => ["index",
                "add",
                "controller",
                "import",
                "create",
                "delete",
                "detail",
                "edit",
            ],
            "khachhangtieudung" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
            ],
        ];
    }

    public function Router() {

    }

}
