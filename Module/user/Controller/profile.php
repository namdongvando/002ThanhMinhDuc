<?php

namespace Module\user\Controller;

use Module\user\Model\user;
use Module\user\Model\userinfor;

class profile extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
    }

    function index() {

        return $this->ViewThemeModlue();
    }

    function logout() {
        \Module\user\Model\Admin::Logout();
    }

    function saveprofile() {
        if (isset($_POST["SuaThongTinChung"])) {
            $admin = new \Module\user\Model\Admin();
            $formUser = $_POST["User"];
            $User = $admin->getUserByUsername(\Module\user\Model\Admin::getCurentUser()["Username"]);
            $User["Name"] = \Common\Common::CheckName($formUser["Name"]);
            $User["Phone"] = \Common\Common::CheckPhone($formUser["Phone"]);
            $User["Email"] = \Common\Common::CheckEmail($formUser["Email"]);
            $User["Address"] = \Common\Common::CheckDiaChi($formUser["Address"]);
            \Module\user\Model\Admin::setCurentUser($User);
            $admin->updateUserInfor($User);
        }

        if (isset($_POST["SuaPassword"])) {
            $admin = new \Module\user\Model\Admin();
            $UserPOST = $_POST["User"];
            $Password = $UserPOST["OdlPassword"];
            $a = $admin->CheckLogin(\Module\user\Model\Admin::getCurentUser()["Username"], $Password);
            if (!$a) {
                \Common\Alert::setAlert("danger", "Mật khẩu không đúng!");
                \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
                exit();
            }
            if ($UserPOST["NewPassword"] == "") {
                \Common\Alert::setAlert("danger", "bạn chưa nhập mật khẩu");
                \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
                exit();
            }
            if ($UserPOST["NewPassword"] != $UserPOST["RePassword"]) {
                \Common\Alert::setAlert("danger", "Mật khẩu Khớp");
                \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
                exit();
            }
            $Admin = new \Module\user\Model\Admin();
            $User = $Admin->getUserByUsername(\Module\user\Model\Admin::getCurentUser()["Username"]);
            $User["Password"] = $admin->createrPassword($UserPOST["NewPassword"], \Module\user\Model\Admin::getCurentUser()["Random"]);
            $Admin->updatePasswordUser($User);
            \Common\Alert::setAlert("success", "Đổi mật khẩu thành công");
        }
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
        exit();
    }

}
?>

