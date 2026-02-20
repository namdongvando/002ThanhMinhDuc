<?php

namespace Module\dashboard\Controller;

class workflow extends \ApplicationM
{

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    function __construct()
    {
        new \Controller\backend();
    }



    function temsanpham()
    {
        
        return $this->ViewThemeModlue([], null);
    }
    function index()
    {
        return $this->AView();
    }

    function menu()
    {
        return $this->AView();
    }

    function yeucaudaxong()
    {
        return $this->AView();
    }

    function yeucaudangxuly()
    {
        return $this->AView();
    }

}
?>