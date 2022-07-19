<?php

spl_autoload_register(function ($class) {
    $class = str_replace("\\", "_", $class);
    $class = str_replace("_", "/", $class) . ".php";
    $class = __DIR__ . "/" . $class;
    if (file_exists($class)) {
        include_once $class;
    }
});
define("DEFAULT_MODULE", "dashboard");
define("DEFAULT_CONTROLLER", "index");
define("DataBaseName", "thanh962_demo");
define("DEFAULT_ACTION", "index");
define("BASE_DIR", "/");
define("ROOT_DIR", __DIR__);
define("NgonNgu", "NgonNgu");
define("UserApp", "UserApp");
define("DateFomatDB", "Y-m-d H:i:s");
define("DateFomatVN", "d-m-Y H:i:s");
define("TinDaXem", "TinDaXem");
define("Password", "@NguyenVanDo1");
define("QuanTri", "QuanTri_PGV");
new \Module\mail\Model\PHPMailerService("ipsquantri@gmail.com", "@NguyenVanDo");

$_SESSION[UserApp] = isset($_SESSION[UserApp]) ? $_SESSION[UserApp] : null;

$_SESSION['TenHienThi'] = 0;
global $INI;

$online =  false;
// echo $_SERVER["HTTP_HOST"];
// if (strpos($_SERVER["HTTP_HOST"], "dev1")) {
//     $online = false;
// }
// var_dump($online);
if ($online == false) {
    $INI['host'] = "localhost";
    $INI['username'] = "root";
    $INI['password'] = "";
    $INI['DBname'] = "thanh962_demo";
    define("BASE_URL", "http://002thanhminhduc.dev1:8080/");
    define("Root_URL", "http://002thanhminhduc.dev1:8080/");
    define("DOMAIN", ".002thanhminhduc.dev1");
} else {
    $INI['host'] = "localhost";
    $INI['username'] = "thanh962_demo";
    $INI['password'] = "zaq@123Abc456";
    $INI['DBname'] = "thanh962_demo";
    define("BASE_URL", "https://cskh.thanhminhduc.com/");
    define("Root_URL", "https://cskh.thanhminhduc.com/");
    define("DOMAIN", ".thanhminhduc.com");
}
define("table_prefix", "thanhminhduc_");
