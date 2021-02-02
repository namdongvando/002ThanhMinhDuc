<?php

namespace Module\sanpham\Controller;

ob_start();

class api extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
        header('Content-Type: application/json');
    }

    public function TokenDeCode($param0) {

    }

}
?>

