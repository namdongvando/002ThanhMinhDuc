<?php

namespace Module\user\Model;

use PFBC\Element;

class AdminForm {

    public $Id;
    public $Username;
    public $Password;
    public $Random;
    public $Name;
    public $Email;
    public $Phone;
    public $Address;
    public $Note;
    public $Groups;
    public static $options = ["class" => "form-control"];

    function __construct($uf = null) {

    }

    public static function onSubmit() {
        return count($_POST) > 0;
    }

    public static function Id($value = "") {
        return new Element\Hidden("users[Id]", $value);
    }

    public static function Password($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["autocomplete"] = "off";
        $properties["type"] = "password";
        $properties["required"] = true;
        return new Element\Textbox("Mật Khẩu", "users[Password]", $properties);
    }

    public static function Username($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;
        $properties["autocomplete"] = "off";
        return new Element\Textbox("Tài Khoản", "users[Username]", $properties);
    }

    public static function Email(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["type"] = "email";
        $properties["required"] = true;
        $properties["autocomplete"] = "off";
        return new Element\Textbox("Email", "users[Email]", $properties);
    }

    public static function Phone(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["autocomplete"] = "off";
        return new Element\Textbox("SĐT", "users[Phone]", $properties);
    }

    public static function Address(
    $value = "", $custom = null) {
        $properties = self::$options;
        $properties[" value"] = $value;
        $properties["autocomplete"] = "off";
        return new Element\Textbox("Địa Chỉ", "users[Address]", $properties);
    }

    public static function Note(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        return new Element\Textbox("Ghi Chú", "users[Note]", $properties);
    }

    public static function Groups(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $properties["style"] = "width:100%;";
        $properties["id"] = "Nhom";
        $properties["required"] = true;
        $UserGroups = new userGroups();
        $options = $UserGroups->GetAll2Option();
//        $options = array_merge($all, $options);
        return new Element\Select("Nhóm", "users[Groups]", $options, $properties);
    }

    public static function TrungTamBaoHanh(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $properties["style"] = "width:100%;
                ";
        $properties["required"] = true;
        $TTBH = new \Module\trungtambaohanh\Model\TrungTamBaoHanh();
        $options = $TTBH->getColumnsOption(["Id", "Name"]);
        $options = array_merge(["Chọn Trung Tâm Bảo Hành"], $options);
        return new Element\Select("Trung Tâm Bảo Hành", "taikhoan[ TrungTamBaoHang]", $options, $properties);
    }

    public static function KhachHang($value = "") {
        $properties = self::$options;
        $properties["

        value"] = [$value];
        $properties["style"] = "width:100%;
                ";
        $properties["required"] = true;
        $KhachHang = new \Module\khachhang\Model\KhachHang();
        $options = $KhachHang->GetALL2Options();
        $options = ["Chọn Đại Lý/ Nhà Phân Phối"] + $options;
        return new Element\Select("Đại Lý/ Nhà Phân Phối", "taikhoan[KhachHang]", $options, $properties);
    }

    public static function Name(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $properties["required"] = true;
        return new Element\Textbox("Họ & Tên", "users[Name]", $properties);
    }

    public static function Active(
    $value = "") {
        $properties = self::$options;
        $properties["value"] = [$value];
        $properties["required"] = true;
        $properties["style"] = "width:100%;";
        $ModelAdmin = new AdminStatus();
        $options = $ModelAdmin->Get2Option();
        return new Element\Select("Tình Trạng", "users[Active]", $options, $properties);
    }

    public static function LinkSua($id) {
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin]) == false) {
            return;
        }
        return <<<LINKSUA
        <a href="/user/users/edit/{$id}" class="btn btn-xs btn-primary" >Sửa</a>

LINKSUA;
    }

    public static function LinkXoa($id) {
        if (Admin::CheckQuyen([Admin::Admin, Admin::SuperAdmin]) == false) {
            return;
        }
        return <<<LINKSUA
        <a href="/user/users/delete/{$id}" data-confirm="Bạn Muốn Xóa User Này" class="btn xoa btn-xs btn-danger" >Xóa</a>

LINKSUA;
    }

}
?>

