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

}
?>

