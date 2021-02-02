<?php

namespace Module\user\Controller;

define("AppDir", "Module/user");
define("Token", "Token");
define("AppPath", "/Module/user");

class login extends \ApplicationM {

    static public $UserLayout = "user";

    function __construct() {
        \Core\ViewTheme::set_viewthene("backend");
    }

    function logout() {
        \Module\user\Model\user::logout();
        \Common\Common::toUrl("/app/index/login/clear/");
    }

    function index() {
        if (isset($_POST["dangnhap"])) {
            $Admin = new \Module\user\Model\Admin();
            $_SESSION[QuanTri] = $Admin->CheckLogin($_POST["Username"], $_POST["Password"]);
            if ($_SESSION[QuanTri] != null) {
                \Application\redirectTo::Url("/dashboard/");
                exit();
            }
            \Common\Alert::setAlert("danger", "Tài khoản hoặc mật khẩu không đúng.");
        }
        return $this->ViewThemeModlue([], \Core\ViewTheme::get_viewthene(), "login");
    }

    function login() {

        return $this->ViewThemeModlue([], \Core\ViewTheme::get_viewthene(), "login");
    }

    private function checkregister() {
        if (isset($_POST["Account"])) {
            $user = new \Module\user\Model\user();
            $Account = $_POST["Account"];
            // kiểm tra tài khoản đã có chưa
            if ($user->getUserByUsername($user->decodeUsername($Account["Username"]))) {
                \Common\Alert::setAlert("danger", "Tài khoản đã được sử dụng");
                return FALSE;
            }
            if ($Account["Password"] != $Account["RePassword"]) {
                \Common\Alert::setAlert("danger", "Mật khẩu không khớp");
                return FALSE;
            }
            if (!filter_var($Account["Email"], FILTER_VALIDATE_EMAIL)) {
                \Common\Alert::setAlert("danger", "Email không đúng định dạng");
                return FALSE;
            }
            if ($user->getUserByEmail($Account["Email"])) {
                \Common\Alert::setAlert("danger", "Email đã được sử dụng");
                return FALSE;
            }
            $GoogleAuthenticator = new \lib\GoogleAuthenticator\GoogleAuthenticator();
//            echo $GoogleAuthenticator->createSecret();
            $_user = $_POST["Account"];
            $_user["Code"] = \Common\Common::RandomString(30);
            $_user["Google2Fa"] = $GoogleAuthenticator->createSecret();
            $_user["Password"] = $user->setPassword($_user["Code"], $_user["Password"]);
            $_user["Username"] = $user->decodeUsername($_user["Username"]);
            unset($_user["RePassword"]);
            try {
                $user->CreateUser($_user);
            } catch (Exception $ex) {
                \Common\Alert::setAlert("danger", "Email đã sử dụng");
                return FALSE;
            }
            return true;
        }
    }

}
?>

