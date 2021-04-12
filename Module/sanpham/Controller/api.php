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

    function DanhSachTemSanPham() {
        $pagesIndex = isset($this->getParam()[0]) ? $this->getParam()[0] : 1;
        $pageNumber = isset($this->getParam()[1]) ? $this->getParam()[1] : 20;
        $tong = 0;
        $name = "";
        $TemSanPhams = \Module\sanpham\Model\TemSanPham::GetRowsPT($name, $pagesIndex, $pageNumber, $tong);
        echo \lib\APIs::ResApi($TemSanPhams, $pagesIndex, $pageNumber, $tong);
    }

}
?>

