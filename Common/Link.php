<?php

namespace Common;

class Link {

    function __construct() {

    }

    static function logout() {
        return "/user/index/logout/";
    }

    public static function profile() {
        return "/user/profile/";
    }

    public static function linkHome() {
        return "/";
    }

    public static function linkUser() {
        return "/dashboard/";
    }

    public static function linkDichVu() {
        return "/user/profile/history/";
    }

    public static function linkTinNoiBo() {
        return "http://cdcwebw.vkhs.vn/";
    }

    public static function linkWebsite() {
        return "[linkWebsite]";
    }

    public static function linkFacebook() {
        return "[linkFacebook]";
    }

    public static function linkTwitter() {

        return "[linkTwitter]";
    }

    public static function linkGoogle() {

        return "[linkGoogle]";
    }

    public static function linkYoutube() {
        return "[linkYoutube]";
    }

    public static function linkInstagram() {
        return "[linkInstagram]";
    }

    public static function linkProfile() {
        return "/user/profile/";
    }

    public static function linkSanPham() {
        return "/danh-muc/";
    }

    public static function LeftMenu() {
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        self::MenuQuanLy();
        self::MenuDoiTac();
        if ($admin->Groups()->GroupsId == \Module\user\Model\Admin::Admin || $admin->Groups()->GroupsId == \Module\user\Model\Admin::SuperAdmin) {

        }
        if ($admin->Groups()->GroupsId == \Module\user\Model\Admin::Customer || \Module\project\Model\Project::GetCurentProject()) {

        }
        ?>
        <?php
    }

    public static function MenuQuanLy() {
        ?>
        <li class="">
            <a href="/trungtambaohanh/index">
                <span>Trung Tâm Bảo Hành</span>
            </a>
        </li>
        <li class="">
            <a href="/dashboard/nhaptem/index">
                <span>Nhập Tem</span>
            </a>
        </li>
        <li class="">
            <a href="/khachhang/index">
                <span>Đại Lý Bán Hàng</span>

            </a>
        </li>
        <li class="">
            <a href="/khachhang/khachhangtieudung/">
                <span>Khách Hàng Tiêu Dùng</span>
            </a>
        </li>

        <li class="">
            <a href="/user/users/">
                <span>Quản Lý Tài Khoản</span>
            </a>
        </li>
        <?php
    }

    public static function MenuDoiTac() {
        ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quản Lý Sản Phẩm <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="">
                    <a href="/sanpham/kho/">
                        <span>Sản Phẩm</span>
                    </a>
                </li>
                <li class="">
                    <a href="/sanpham/index/">
                        <span>Danh Mục Sản Phẩm</span>
                    </a>
                </li>
                <li class="">
                    <a href="/sanpham/taosanpham/">
                        <span>Quản Lý Sản Phẩm</span>
                    </a>
                </li>
                <li class="">
                    <a href="/sanpham/temsanpham/">
                        <span>Tem Sản Phẩm</span>
                    </a>
                </li>
            </ul>
        </li>


        <?php
    }

}
?>