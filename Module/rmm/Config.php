<?php

namespace Module\rmm;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "index" => [
                "index",
                "edit",
                "add",
                "delete",
            ]
        ];
    }

    public function Router() {

    }

}
