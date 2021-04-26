<?php

namespace Module\sanpham\Model;

use \Module\option\Model\Option;

class DanhMucSanPham extends Option {

    public function __construct() {
        parent::__construct();
    }

    function Post($param) {
        return $this->InsertSubmit($param);
    }

}
