<?php

namespace Module\dashboard\Controller;

define("AppDir", "Module/dashboard");
define("AppPath", "/Module/dashboard");

class workflow extends \ApplicationM {

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
    }

    function index() {
        return $this->AView();
    }

    function menu() {
        return $thsis->AView();
    }

    function yeucaudaxong() {
        return $this->AView();
    }

    function yeucaudangxuly() {
        return $this->AView();
    }

}
?>

