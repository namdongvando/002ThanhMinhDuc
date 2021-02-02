<?php

namespace Module\sanpham\Model;

interface ITemSanPhamForm {

    public static function Id($value = null);

    public static function Name($value = null);

    public static function MaSanPham($value = null);

    public static function KhachHangTieuDung($value = null);

    public static function NgayBatDau($value = null);

    public static function NgayKetThuc($value = null);

    public static function Status($value = null);

    public static function UserId($value = null);

    public static function CreateDate($value = null);

    public static function ModifyDate($value = null);

    public static function Parents($value = null, $title = "");
}
?>

