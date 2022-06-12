<?php

namespace Module\user\Controller;

class login extends \ApplicationM {

    static public $UserLayout = "user";

    const Token = 'Token';
    const AppDir = "Module/user";
    const AppPath = "/Module/user";

    function __construct() {


        \Core\ViewTheme::set_viewthene("backend");
    }

    function logout() {
        \Module\user\Model\user::logout();
        \Common\Common::toUrl("/app/index/login/clear/");
    }

    function index() {

        if (isset($_COOKIE["token"])) {
            $token = $_COOKIE["token"];
            $user = json_decode(base64_decode($token), JSON_OBJECT_AS_ARRAY);
            if ($user) {
                $_SESSION[QuanTri] = $user;
            }
            if ($_SESSION[QuanTri]) {
                \Application\redirectTo::Url("/dashboard/");
            }
        }
        if (isset($_POST["dangnhap"])) {
            $Admin = new \Module\user\Model\Admin();
            $_POST["Username"] = \Common\Common::CheckInput($_POST["Username"]);
            $_SESSION[QuanTri] = $Admin->CheckLogin($_POST["Username"], $_POST["Password"]);
//            var_dump($_SESSION[QuanTri]);
//            die();
            if ($_SESSION[QuanTri] != null) {
                // luu 1 tháng
                $QuanTri = $_SESSION[QuanTri];
                unset($QuanTri["Password"]);
                $QuanTri["Time"] = time();
                setcookie("token", base64_encode(json_encode($QuanTri, JSON_UNESCAPED_UNICODE)), time() + (86400 * 30), "/");
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

    function google() {
        $id_token = $_POST["idtoken"];
        $CLIENT_ID = \Module\user\Model\GoogleConfig::GetGoogleClient_id();
        $client = new \Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
            \Module\user\Model\GoogleConfig::SaveUserInfor($payload);
            $Admin = new \Module\user\Model\Admin();
            $user = $Admin->GetUserByEmail($payload['email']);
//            login
            if ($user) {
                $_SESSION[QuanTri] = $user;
                $QuanTri = $_SESSION[QuanTri];
                unset($QuanTri["Password"]);
                $QuanTri["Time"] = time();
                setcookie("token", base64_encode(json_encode($QuanTri, JSON_UNESCAPED_UNICODE)), time() + (86400 * 30), "/");
            }
        } else {
            echo "Invalid ID token";
        }
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

