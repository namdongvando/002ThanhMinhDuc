<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Module\trungtambaohanh\Model;

/**
 * Description of IYeuCauBaoHanh
 *
 * @author MSI
 */
interface IYeuCauBaoHanh {

//put your code here

    public static function Id($value = null);

    public static function Code($value = null, $title = null);

    public static function Name($value = null, $title = null);

    public static function KhachHangTieuDung($value = null, $title = null);

    public static function SDT($value = null, $title = null);

    public static function DiaChi($value = null, $title = null);

    public static function NgayBaoHanh($value = null, $title = null);

    public static function NoiDung($value = null, $title = null);

    public static function CreateDate($value = null, $title = null);

    public static function UpdateDate($value = null, $title = null);
}
