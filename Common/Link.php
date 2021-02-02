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
        <li class="header text-center text-uppercase " style="color: #ddd;" ><b>Quản Lý Hệ Thống</b></li>
        <li class="treeview">
            <a href="/trungtambaohanh/index">
                <i class="fa fa-truck"></i> <span>Trung Tâm Bảo Hành</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="/khachhang/index">
                <i class="fa fa-amazon"></i> <span>Khách Hàng</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="/khachhang/khachhangtieudung/">
                <i class="fa fa-user-plus"></i> <span>Khách Hàng Tiêu Dùng</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>

        <li class="treeview">
            <a href="/user/users/">
                <i class="fa fa-user"></i> <span>Quản Lý Tài Khoản</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="/option/index">
                <i class="fa fa-gears"></i> <span>Cài Đăt Chung</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>

        <?php
    }

    public static function MenuDoiTac() {
        ?>
        <li class="header text-center text-uppercase " style="color: #ddd;" ><b>Quản Lý Sản Phẩm</b></li>
        <li class="treeview">
            <a href="/sanpham/index/">
                <i class="fa fa-list-ol"></i> <span>Danh Mục Sản Phẩm</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="/sanpham/taosanpham/">
                <i class="fa fa-list-ol"></i> <span>Tạo Sản Phẩm</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>
        <li class="treeview">
            <a href="/sanpham/temsanpham/">
                <i class="fa fa-list-ol"></i> <span>Tem Sản Phẩm</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
        </li>

        <!--        <li class="header text-center text-uppercase " style="color: #ddd;" ><b>Quản Lý Dự Án</b></li>
                <li class="treeview">
                    <a href="/project/dashboard/dashboard/">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/project/dashboard/index/">
                        <i class="fa fa-cubes"></i> <span>Dự Án</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/project/controller/">
                        <i class="fa fa-wifi"></i> <span>Thiết Bị</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/project/users/">
                        <i class="fa fa-users"></i> <span>Người Quản Trị</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/project/controller/datacontrollers/">
                        <i class="fa fa-info"></i> <span>Thông Tin Khách Hàng</span>
                        <i class="fa fa-angle-right pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="/project/connect/">
                        <i class="fa fa-globe"></i> <span>Liên Kết MXH</span>

                    </a>
                </li>-->
        <?php
    }

}
?>