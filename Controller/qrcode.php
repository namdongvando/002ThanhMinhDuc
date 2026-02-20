<?php

class Controller_qrcode extends Application
{

    public $param;
    public $ViewTheme;
    public $Pages;
    public $News;

    function __construct()
    {
        Model_ViewTheme::set_viewthene("thanhminhduc");
    }

    function index()
    {
        return $this->AView([]);
    }

}
?>