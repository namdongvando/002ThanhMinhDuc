<?php

class Controller_scanqrcode extends Application {

    public $param;
    public $ViewTheme;
    public $Pages;
    public $News;

    function __construct() {
        Model_ViewTheme::set_viewthene("thanhminhduc");
    }

    function index() {
        return $this->ViewTheme([], null, "qr");
    }

    function scan() {
        return $this->ViewTheme([], null, "qr");
    }

    function savecode() {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $code->SaveCode($this->getParam()[0]);
        $a = $code->GetCodes();
        var_dump($a);
    }

}
?>

