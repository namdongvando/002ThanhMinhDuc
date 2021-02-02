<?php

namespace Application\Model;

class Groups extends \datatable\Admin {

    static $per = null;
    static $RoleDefaul = "Admin";

    function __construct() {
        
    }

    /**
     * kiểm tra quền trong 
     * @param {type} parameter
     */
    static function checkPermission($action) {
// lấy danh sách quyền
        $action = str_replace("\\", "/", $action);
        $action = explode("/", $action);
        $action = end($action);
//        echo $action;
        self::loadPermisstion();
//        echo $action;
//        die();
// check theo role
//        var_dump($_SESSION[SESSION_LOGIN]);
        $user = new \datatable\Admin($_SESSION[QuanTri]);

//        var_dump(self::$per[$user->Role]);
        if (isset(self::$per[$user->Groups][$action])) {
            return self::$per[$user->Groups][$action];
        }
        return FALSE;
    }

    /**
     * kiểm tra quền trong hệ thống
     * @param0 {type} parameter
     */
    public static function checkPermissionControlle($param0, $url = "/") {
        if (!self::checkPermission($param0)) {
            Common::_ToUrl($url);
            exit();
        }
    }

    /**
     * Load quền tài khoản
     * @param {type} parameter
     */
    static private function loadPermisstion() {
        // cấu hình trong code
        if (self::$per == null)
            self::$per = self::setPermission();
    }

    /**
     * Danh sách role trong hệ thống
     * @param {type} parameter
     */
    public static function getRole() {
        return ["Admin", "Biên tập viên", "modification"];
    }

    /**
     * Nấy tên role
     * @param {type} parameter
     */
    public static function getRoleName($roleid) {
        $role = self::getRole();
        return $role[$roleid];
    }

    static function getPermissionByUser($User) {
        $u = new \datatable\Admin($User);
        $q = self::setPermission();
        return array_keys($q[$u->Groups], TRUE);
    }

    static function getAction() {
        return [
            "Controller_backend" => "Quản Lý Chung",
            "Controller_duyettin" => "Duyệt Tin",
            "Controller_editnews" => "Sửa bài viết",
            "Controller_madv" => "Quản Lý Quảng Cáo",
            "Controller_mcategory" => "Quản Lý Danh Mục",
            "Controller_minfor" => "Quản Lý Thông Tin Chung",
            "Controller_mmenu" => "Quản Lý Menu",
            "Controller_mnews" => "Quản Lý Tin",
            "Controller_mpage" => "Quản Lý Trang",
            "Controller_mtheme" => "Quản Lý Giao Diện",
            "Controller_muser" => "Quản Lý Tài Khoản",
        ];
    }

    /**
     * Cấu hình quền trong hệ thống
     * 
     */
    static private function setPermission() {
        $per = [
            [
                "Controller_backend" => TRUE,
                "Controller_editnews" => TRUE,
                "Controller_madv" => TRUE,
                "Controller_duyettin" => TRUE,
                "Controller_mcategory" => TRUE,
                "Controller_minfor" => TRUE,
                "Controller_mmenu" => TRUE,
                "Controller_mnews" => TRUE,
                "Controller_mobie" => TRUE,
                "Controller_mpage" => TRUE,
                "Controller_mproduct" => TRUE,
                "Controller_mprofile" => TRUE,
                "Controller_msite" => TRUE,
                "Controller_mtheme" => TRUE,
                "Controller_muser" => TRUE,
            ],
            [
                "Controller_backend" => TRUE,
                "Controller_editnews" => TRUE,
                "Controller_madv" => FALSE,
                "Controller_duyettin" => FALSE,
                "Controller_mcategory" => FALSE,
                "Controller_minfor" => FALSE,
                "Controller_mmenu" => FALSE,
                "Controller_mnews" => TRUE,
                "Controller_mobie" => FALSE,
                "Controller_mpage" => FALSE,
                "Controller_mproduct" => FALSE,
                "Controller_mprofile" => FALSE,
                "Controller_msite" => FALSE,
                "Controller_mtheme" => FALSE,
                "Controller_muser" => FALSE,
            ]
            , [
                "Controller_backend" => TRUE,
                "Controller_editnews" => FALSE,
                "Controller_madv" => FALSE,
                "Controller_duyettin" => FALSE,
                "Controller_mcategory" => FALSE,
                "Controller_minfor" => FALSE,
                "Controller_mmenu" => FALSE,
                "Controller_mnews" => FALSE,
                "Controller_mobie" => FALSE,
                "Controller_mpage" => FALSE,
                "Controller_mproduct" => FALSE,
                "Controller_mprofile" => FALSE,
                "Controller_msite" => FALSE,
                "Controller_mtheme" => FALSE,
                "Controller_muser" => FALSE,
            ]
        ];
        return $per;
    }

    /**
     * Comment
     * @param {type} parameter
     */
    static function getMenuByUser($groups) {
        return self::getMenu()[$groups];
    }

    /**
     * menu by groups
     * @param {type} parameter
     */
    static function getMenu() {
        return [
            [
                [
                    "link" => "", "title" => "Bài Viết", "icon" => "fa fa-list"
                    , "sublink" => [
                        ["link" => "/mpage/index/", "title" => "Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mpage/addpage/", "title" => "Thêm Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mnews/addnews/", "title" => "Đăng Tin", "icon" => "fa fa-list"]
                        , ["link" => "/duyettin/index/", "title" => "Duyệt Tin", "icon" => "fa fa-list"]
                    ]
                ]
                , [
                    "link" => "/madv/index/", "title" => "Quảng Cáo", "icon" => "fa fa-list"
                    , "sublink" => []
                ]
                , [
                    "link" => "/mtheme/", "title" => "Giao Diện", "icon" => "fa fa-list"
                    , "sublink" => []
                ]
                , [
                    "link" => "/minfor/thongtincongty/", "title" => "Thông Tin Chung", "icon" => "fa fa-list"
                    , "sublink" => []
                ]
                , [
                    "link" => "/muser/index/", "title" => "Tài Khoản", "icon" => "fa fa-list"
                    , "sublink" => []
                ]
                , [
                    "link" => "/muser/groups/", "title" => "Nhóm Quyền", "icon" => "fa fa-list"
                    , "sublink" => []
                ]
            ]
            , [
                [
                    "link" => "", "title" => "Bài Viết", "icon" => "fa fa-list"
                    , "sublink" => [
                        ["link" => "/mpage/index/", "title" => "Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mpage/addpage/", "title" => "Thêm Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mnews/addnews/", "title" => "Thêm Bài Viết", "icon" => "fa fa-list"]
                    ]
                ]
            ]
            , [
                [
                    "link" => "", "title" => " Bài Viết", "icon" => "fa fa-list"
                    , "sublink" => [
                        ["link" => "/mpage/index/", "title" => "Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mpage/addpage/", "title" => "Thêm Danh Mục", "icon" => "fa fa-list"]
                        , ["link" => "/mnews/addnews/", "title" => "Thêm Bài Viết", "icon" => "fa fa-list"]
                    ]
                ]
            ]
        ];
    }

    public static function getPermissionByRole($Groups) {
        $q = self::setPermission();
        return array_keys($q[$Groups], TRUE);
    }

}
