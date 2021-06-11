<?php

namespace Module\trungtambaohanh;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "index" => [
                "index",
                "controller",
                "create",
                "delete",
                "detail",
                "edit",
            ], "phulucsuachua" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
                "import",
            ], "yeucaubaohanh" => [
                "index",
                "detail",
                "form",
                "formcomposers",
                "SanPham",
            ]
        ];
    }

    public function Router() {

    }

}
