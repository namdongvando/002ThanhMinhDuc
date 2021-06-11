<?php

namespace Module\dashboard;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "component" => [
                "index",
                "liastdata"
            ],
            "facebookpixel" => [
                "index"
            ],
            "index" => [
                "index",
                "listdata",
                "scan",
                "savecode1",
                "savecode",
            ],
            "nhaptem" => [
                "index",
                "scan",
                "savecode",
                "clear",
                "coderefesh",
                "danhsachtem",
            ],
            "workflow" => [
                "index",
                "menu",
                "yeucaudaxong",
                "yeucaudangxuly",
            ],
        ];
    }

    public function Router() {

    }

}
