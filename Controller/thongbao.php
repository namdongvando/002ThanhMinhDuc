<?php

// api này không cần dang nhap

use Model\ThongBao;

class Controller_thongbao extends Application
{

    public $param;
    public $Api;

    function __construct()
    {
        $this->param = $this->getParam();
        $this->Api = new \lib\APIs();
    }

    function GetThongBao()
    {
        $thongBao = new ThongBao();
        $tb = $thongBao->GetByStatus(1);
        foreach ($tb as $key => $value) {
            $value["Status"] = 0;
            $thongBao->Put($value);
        }
        $this->Api->ArrayToApi($tb);
    }
}