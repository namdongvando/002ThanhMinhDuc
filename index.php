<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

define("debug", true);
if (true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

function minify_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s'
    );
    $replace = array(
        '>',
        '<',
        '\\1'
    );

    if (preg_match("/\<html/i", $buffer) == 1 && preg_match("/\<\/html\>/i", $buffer) == 1) {
        $buffer = preg_replace($search, $replace, $buffer);
    }
    return $buffer;
}

//$stime = time() + microtime();
$url = $_SERVER['REQUEST_URI'];


//$url = $_GET["path"];

session_start();
//ob_start('minify_output');
ob_start();

include 'config.php';

$pathAutoload = "vendor/autoload.php";
if (file_exists($pathAutoload)) {
    include_once $pathAutoload;
}

//var_dump($_GET["path"]);
$host = $_SERVER["HTTP_HOST"];
$user = explode(DOMAIN, $host);
define("EVN", "dev");

//mcategory

$Application = new Application($url);
if (empty($_GET["ctr"])) {
    $cnameV = $Application->getController();
    $cname = "Controller_" . $cnameV;
    $action = $Application->getAction();
} else {
    $cnameV = $_GET["ctr"];
    $action = $_GET["action"];
    $params = $_GET["param"];
    $cname = "Controller_" . $cnameV;
    $Application->setController($cnameV);
    $Application->setAction($action);
    $Application->setParam($params);
}

// echo $cnameV;
// echo $action;
// var_dump($params);
// echo $cname;
if (class_exists($cname, TRUE)) {

    if (method_exists($cname, $action)) {
        $c = new $cname();
        $c->$action();
    } else {
        $Application->setParam($action);
        $Application->getParam();
        $Application->setAction("index");
        $Application->getAction();
        $c = new $cname();
        $c->index();
    }
} else {
    $_Action = $Application->PTURL($TieuDeKD);
    $Application->setController("index");
    $Application->setAction($_Action);
    $action = $_Action;
    $c = new Controller_index();
    $c->$action($TieuDeKD);
    //    controler mặc định lấy
}

// echo $Application->getController();
// echo $Application->getAction();
if (true) {
      $Application->getController();
      $Application->getAction();
}
// $etime = time() + microtime();
// echo $etime - $stime;
