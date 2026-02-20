<?php

namespace Module\dashboard\Model;

use datatable\ZendData;

class ModelBaoCao extends ZendData
{
    function TemBaoHangBaoCao1($tuNgay, $denNgay)
    {
        echo $temSanPham = "SELECT * FROM `thanhminhduc_tembaohanh` WHERE `MaSanPham` in (SELECT `Id` FROM `thanhminhduc_sanpham` WHERE `Id` in (SELECT `Id` FROM `thanhminhduc_sanpham_log` WHERE NgayTao > '{$tuNgay}' and NgayTao < '{$denNgay}' GROUP BY `Id`))";
        return $this->runsqlToArray($temSanPham);
    }

}

?>