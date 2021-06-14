<?php

namespace Module\dashboard\Controller;

class index extends \ApplicationM {

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
    }

    function index() {
        return $this->ViewThemeModlue();
    }

    function listdata() {
        $time = filemtime("Module/dashboard/public/js/dashboardWorkflows.js");
        $Js = <<<JS
<script src="/Module/dashboard/public/js/dashboardWorkflows.js?v={$time}" type="text/javascript"></script>
JS;
        \Application\Html\Js::AddJS($Js);
        return $this->ViewThemeModlue();
    }

    function scan() {
        return $this->ViewThemeModlue([], null, "qr");
    }

    function savecode1() {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $codeTem = $this->getParam()[0];
        $temModel = new \Module\sanpham\Model\TemSanPham();
        $codeDetail = $temModel->GetByCode($codeTem);
        if ($codeDetail) {
            $code->SaveCode($codeTem);
            $a = $code->GetCodes();
        }
        var_dump($a);
    }

    function savecode() {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $codeTem = $this->getParam()[0];
        $temModel = new \Module\sanpham\Model\TemSanPham();
        $codeDetail = $temModel->GetByCode($codeTem);
        if ($codeDetail) {
            $code->SaveCode($codeTem);
            $a = $code->GetCodes();
        }
        var_dump($a);
    }

}

?>
