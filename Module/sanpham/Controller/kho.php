<?php

namespace Module\sanpham\Controller;

class kho extends index {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        return $this->ViewThemeModlue();
    }

    public function resettem() {
        $sanPham = new \Module\sanpham\Model\SanPham();
        $sanPham->resettem();
    }

    public function create() {

    }

    public function delete() {

    }

    public function detail() {

    }

    public function edit() {

    }

}
