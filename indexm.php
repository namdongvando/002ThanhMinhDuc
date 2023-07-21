<?php
if (!session_id()) {
    session_start();
    ob_start();
}

try {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    // define("debug", TRUE);

    if (true) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    // function minify_output($buffer) {
    //     $search = array(
    //         '/\>[^\S ]+/s',
    //         '/[^\S ]+\</s',
    //         '/(\s)+/s'
    //     );
    //     $replace = array(
    //         '>',
    //         '<',
    //         '\\1'
    //     );
    //     if (preg_match("/\<html/i", $buffer) == 1 && preg_match("/\<\/html\>/i", $buffer) == 1) {
    //         $buffer = preg_replace($search, $replace, $buffer);
    //     }
    //     return $buffer;
    // }

//    ob_start(minify_output);
    $url = $_SERVER['REQUEST_URI'];
    // include 'config.php';
// load composer
    if (file_exists("vendor/autoload.php"))
        require_once "vendor/autoload.php";
//    load menu
    if (empty($_GET["Module"])) {
//        Cac module tu do
        $Application = new ApplicationM($url);
        $Module = $Application->getModule();
        $cnameV = $Application->getController();
        $action = $Application->getAction();
    } else {
        // cac link duoc chi dinh
        $Module = $_GET["Module"];
        $cnameV = $_GET["ctrl"];
        $action = $_GET["action"];
        $params = $_GET["param"];
        $Application->setModule($Module);
        $Application->setController($cnameV);
        $Application->setAction($action);
        $Application->setParam($params);
    }
    $className = sprintf("Module\\%s\\Controller\\%s", $Module, $cnameV);
    if (class_exists($className, TRUE)) {
        $Ctrl = new $className();
        if (method_exists($Ctrl, $action)) {
            $Ctrl->$action();
        } else {
            $Ctrl->index();
        }
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}