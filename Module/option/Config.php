<?php

namespace Module\option;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "index" => [
                "index",
                "import",
                "create",
                "delete",
                "detail",
                "edit",
                "groups",
            ], "permistion" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
            ]
        ];
    }

    public function Router() {

    }

}
