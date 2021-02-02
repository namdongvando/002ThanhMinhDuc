<?php

namespace Module\trungtambaohanh\Model;

interface IPhuLucSuaChua {

    static public function Id($value = null);

    static public function Code($value = null, $title = "");

    static public function Name($value = null, $title = "");

    static public function DonGia($value = null, $title = "");

    static public function LinhKien($value = null, $title = "");

    static public function YeuCau($value = null, $title = "");

    static public function GiaLinhKien($value = null, $title = "");

    static public function LoaiPhuLuc($value = null, $title = "");
}
?>


