<?php

namespace data\tables\thanhminhductembaohanh;

interface ItembaohanhForm {
static public function Id($value = null, $title = ""); 
static public function Name($value = null, $title = ""); 
static public function MaSanPham($value = null, $title = ""); 
static public function KhachHangTieuDung($value = null, $title = ""); 
static public function NgayBatDau($value = null, $title = ""); 
static public function NgayKetThuc($value = null, $title = ""); 
static public function Status($value = null, $title = ""); 
static public function UserId($value = null, $title = ""); 
static public function CreateDate($value = null, $title = ""); 
static public function ModifyDate($value = null, $title = ""); 
static public function Parents($value = null, $title = ""); 

}
?>
