<?php

namespace Module\user;

class Config implements \Model\IConfigModule {

    public function __construct() {

    }

    function Controller() {
        return [
            "index" => [
                "logout",
                "index",
                "login",
                "checkregister",
                "register",
                "profile",
                "resetpassword",
                "savetoken",
                "getToken",
                "saveuserinfor",
                "getUserInfor",
            ], "login" => [
                "logout",
                "index",
                "login",
                "checkregister",
            ], "profile" => [
                "index",
                "logout",
                "saveprofile",
            ], "register" => [
                "index"
            ]
            , "users" => [
                "index",
                "create",
                "delete",
                "detail",
                "edit",
                "import",
                "resetpassword",
            ]
        ];
    }

    public function Router() {

    }

}
