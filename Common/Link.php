<?php

namespace Common;

use Module\user\Model\Admin;

class Link
{

    function __construct()
    {
    }

    static function logout()
    {
        return "/user/index/logout/";
    }

    public static function profile()
    {
        return "/user/profile/";
    }

    public static function linkHome()
    {
        return "/";
    }

    public static function linkUser()
    {
        return "/dashboard/";
    }

    public static function linkDichVu()
    {
        return "/user/profile/history/";
    }

    public static function linkTinNoiBo()
    {
        return "http://cdcwebw.vkhs.vn/";
    }

    public static function linkWebsite()
    {
        return "[linkWebsite]";
    }

    public static function linkFacebook()
    {
        return "[linkFacebook]";
    }

    public static function linkTwitter()
    {

        return "[linkTwitter]";
    }

    public static function linkGoogle()
    {

        return "[linkGoogle]";
    }

    public static function linkYoutube()
    {
        return "[linkYoutube]";
    }

    public static function linkInstagram()
    {
        return "[linkInstagram]";
    }

    public static function linkProfile()
    {
        return "/user/profile/";
    }

    public static function linkSanPham()
    {
        return "/danh-muc/";
    }

    public static function LeftMenu()
    {
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

    public static function MenuQuanLy()
    {
        \Module\trungtambaohanh\Model\Menu::linkTrungTamBaoHanh();
        \Module\dashboard\Model\Menu::LinkNhapTem();
        \Module\dashboard\Model\Menu::YeuCauKichHoatTem();
        \Module\dashboard\Model\Menu::DanhGia();
        \Module\dashboard\Model\Menu::ThongKeBaoCao();
        \Module\khachhang\Model\Menu::LinkDaiLyKhachHang();
        \Module\khachhang\Model\Menu::LinkKhachHangTieuDung();
        \Module\user\Model\Menu::LinkQuanLyKhachHang();
    }

    public static function MenuDoiTac()
    {
        ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Quản Lý Sản Phẩm <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <?php
                //                \Module\sanpham\Model\Menu::LinkKhoSanPham();
                \Module\sanpham\Model\Menu::LinkSanPham();
                \Module\sanpham\Model\Menu::LinkDanhMucSanPham();
                \Module\sanpham\Model\Menu::LinkTemSanPham();
                ?>
            </ul>
        </li>
        <?php
    }
    public static function KiemHang()
    {
         
        if (Admin::CheckQuyen(["KiemHang",Admin::NVKT,Admin::Admin, Admin::SuperAdmin]) == true) {
            ?>
        <li>
            <a href="/dashboard/kiemhang/">Kiểm Hàng </a>
        </li>
        <?php
        } 
        if (Admin::CheckQuyen(["QuetTem",Admin::Admin, Admin::SuperAdmin]) == true) {
            ?>
            <li>
                <a href="/dashboard/nhaptem/index">Quét Tem </a>
            </li>
            <?php

        }
        ?>
        <li>
            <a href="/trungtambaohanh/yeucaubaohanh/scan/">Bảo Hành </a>
        </li>
    <?php

    }
}
?>