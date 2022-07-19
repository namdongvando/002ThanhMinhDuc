<?php

namespace Module\user\Controller;

class index extends \ApplicationM
{

    static public $UserLayout = "user";

    const Token = 'Token';
    const AppDir = "Module/user";
    const AppPath = "/Module/user";

    function __construct()
    {
    }

    function logout()
    {
        //        \Module\user\Model\user::logout();
        setcookie("token", "", time() - 3600, "/");
        \Module\user\Model\Admin::Logout();
        \Common\Common::toUrl("/user/index/login/");
    }

    function index()
    {

        return $this->ViewThemeModlue([], \Core\ViewTheme::get_viewthene(), "");
    }

    function login()
    {

        return $this->ViewThemeModlue([], \Core\ViewTheme::get_viewthene(), "login");
        //        return $this->ViewTheme([], NUll, "userlogin");
    }

    private function checkregister()
    {
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

    function register()
    {


        if ($this->checkregister()) {
            \Common\Alert::setAlert("success", "Đăng ký thành công");
            \Common\Common::toUrl("/category/dich-vu-san-pham/");
        }
        //        echo "aa";
        //        print_r($this->getParam());
        return $this->ViewThemeModlue([], \Model_ViewTheme::get_viewthene(), "full");
    }

    function profile()
    {
        return $this->ModelView([], "");
    }

    function resetpassword()
    {
        return $this->ModelView([], "login");
    }

    function savetoken()
    {
        $_SESSION[Token] = $_POST;
    }

    function getToken()
    {
        $api = new \lib\APIs();
        $_SESSION[Token]['expires_in'] = intval($_SESSION[Token]['expires_in']);
        $api->ArrayToApi($_SESSION[Token]);
    }

    function saveuserinfor()
    {
        $_SESSION[UserApp] = base64_encode(json_encode($_POST));
        print_r($_POST);
    }

    function getUserInfor()
    {

        $api = new \lib\APIs();
        \Module\user\Model\user::getCurentUserInfor(true);


        if (\Module\user\Model\user::getCurentUserInfor(FALSE)) {
            \Module\user\Model\user::getCurentUserInfor();
            $api->ArrayToApi(\Module\user\Model\user::getCurentUserInfor());
            return;
        }

        return null;
    }
}
