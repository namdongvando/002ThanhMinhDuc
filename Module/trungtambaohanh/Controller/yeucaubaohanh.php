<?php

namespace Module\trungtambaohanh\Controller;

class yeucaubaohanh extends \ApplicationM {

    static public $UserLayout = "backend";

    function __construct() {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    function index() {
        return $this->ViewThemeModlue();
    }

    function detail() {
        return $this->AView();
    }

    function form() {
        return $this->AView();
    }

    function formcomposers() {
        return $this->AView();
    }

}
