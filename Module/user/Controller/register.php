<?php

namespace Module\user\Controller;

class register extends \ApplicationM {

    function __construct() {
        \Module\user\Model\user::CheckLogin("/user/index/login");
    }

    function index() {


        return $this->ModelView([], "");
    }

}
?>

