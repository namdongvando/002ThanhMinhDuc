<?php

namespace Module\khachhang\Model;

interface IKhachHangForm {

    public static function Id($value = null);

    public static function Code($value = null);

    public static function Name($value = null);

    public static function Parents($value = null);

    public static function KhuVuc($value = null);

    public static function ThongTinThanhToan($value = null);

    public static function LoaiHinhKinhDoanh($value = null);

    public static function DiaChi($value = null);

    public static function PhuongXa($value = null);

    public static function QuanHuyen($value = null);

    public static function TinhThanh($value = null);

    public static function LaChuKinhDoanh($value = null);

    public static function DienThoai($value = null);

    public static function DiDong($value = null);

    public static function Zalo($value = null);

    public static function MaSoThue($value = null);

    public static function DiaChiGiaoHang($value = null);

    public static function NhomHangKinhDoanh($value = null);
}
?>

