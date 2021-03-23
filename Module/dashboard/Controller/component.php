<?php

namespace Module\dashboard\Controller;

define("AppDir", "Module/dashboard");
define("AppPath", "/Module/dashboard");

class component extends \ApplicationM {

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
    }

    function index() {
        $time = time();
        $Js = <<<JS
<script src="/Module/dashboard/public/ipnet.js?v={$time}" type="text/javascript"></script>
JS;
        \Application\Html\Js::AddJS($Js);
        return $this->ViewThemeModlue();
    }

    function liastdata() {

        return $this->ViewThemeModlue();
    }

}
?>

