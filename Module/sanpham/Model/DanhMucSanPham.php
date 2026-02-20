<?php

namespace Module\sanpham\Model;

use \Module\option\Model\Option;

class DanhMucSanPham extends Option
{

    public function __construct($item = null)
    {
        parent::__construct($item);
    }

    function Post($param)
    {
        return $this->InsertSubmit($param);
    }

    function DMByGroupsCode($code)
    {
        return $this->GetOptionByGroupsCode("DanhMucVatTu", $code);

    }

}