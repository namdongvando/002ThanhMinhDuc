<?php

class Application {

    public $url;
    static public $iurl;
    static public $controller;
    static public $action;
    static public $params;
    static public $lang;

    function __construct($url) {
        $this->url = $url;
        self::$iurl = $url;

        $this->tach_url($url, self::$controller, self::$action, self::$params);
    }

    static function check_is_mobile() {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
                || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
            return true;
        }
        return false;
    }

    function is_mobile() {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
            return true;
        }
        return false;
    }

    static function getController() {
        return self::$controller;
    }

    static function setController($nameController) {
        return self::$controller = $nameController;
    }

    static function getAction() {
        return self::$action;
    }

    static function setAction($Action) {
        return self::$action = $Action;
    }

    static function getParam() {
        if (self::$params) {
            foreach (self::$params as $v => $param) {
                self::$params[$v] = self::BokyTuDacBietPaRam(self::$params[$v]);
            }
            return self::$params;
        } else {
            return FALSE;
        }
    }

    function setThongBao($ThongBao) {

        return $_SESSION["ThongBao"] = $ThongBao;
    }

    function setParam($params) {
        $Param = $this->getParam();
        if ($Param) {
            $a1[] = $params;
            $Param = array_merge($a1, $Param);
        } else {
            $Param[] = $params;
        }
        self::$params = $Param;
    }

    function unsetThongBao() {
        unset($_SESSION['ThongBao']);
    }

    function getThongBao() {
        $ThongBao = isset($_SESSION["ThongBao"]) ? $_SESSION["ThongBao"] : FALSE;
        $this->unsetThongBao();
        return $ThongBao;
    }

    static function getLang() {
        return self::$lang;
    }

    public function loi404() {
        header("Location: " . BASE_DIR . "index/loi404");
    }

// kiểm tra các thành phần
    function KiemTraText($text) {
        $text = strip_tags($text);
        return $text;
    }

    function KiemTraURL($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function upload_image($file, $extension, $folder, $newname = '') {
        if (isset($_FILES[$file]) && !$_FILES[$file]['error']) {

//         $ext = end(explode('.', $_FILES[$file]['name']));
            $ext = trim(substr($_FILES[$file]["type"], 6, strlen($_FILES[$file]["type"])));
//         $ext = $ext[1];
            $name = basename($_FILES[$file]['name'], '.' . $ext);

            if (strpos($extension, $ext) === false) {
                alert('Chỉ hỗ trợ upload file dạng ' . $extension);
                return false; // không hỗ trợ
            }
            if ($newname == '' && file_exists($folder . $_FILES[$file]['name']))
                for ($i = 0; $i < 100; $i++) {
                    if (!file_exists($folder . $name . $i . '.' . $ext)) {
                        $_FILES[$file]['name'] = $name . $i . '.' . $ext;
                        break;
                    }
                } else {
                $_FILES[$file]['name'] = $newname . '.' . $ext;
            }

            if (!copy($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                if (!move_uploaded_file($_FILES[$file]["tmp_name"], $folder . $_FILES[$file]['name'])) {
                    return false;
                }
            }
            return $_FILES[$file]['name'];
        }
        return false;
    }

    public function KiemTraFileHinh($Hinh, $size, $nameHinh, $path) {

        if (($Hinh["type"] == "image/gif") ||
                ($Hinh["type"] == "image/jpeg") ||
                ($Hinh["type"] == "image/jpg") ||
                ($Hinh["type"] == "image/png") &&
                $Hinh['size'] < $size
        ) {
            $typeHinh = explode('/', $Hinh['type']);
            $typeHinh = end($typeHinh);
            $pypath = $path . $nameHinh . "." . $typeHinh;
//            là hinh thì làm cái gì
            if (copy($Hinh["tmp_name"], $pypath)) {
                if (move_uploaded_file($Hinh["tmp_name"], $pypath)) {
                    return $nameHinh . "." . trim(substr($Hinh["type"], 6, strlen($Hinh["type"])));
                } else {
                    return FALSE;
                }
            }
//            return "." . trim(substr($Hinh["type"], 6, strlen($Hinh["type"])));
        } else {
            return FALSE;
        }
    }

    function getKhachHang() {
        return $_SESSION[KhachHang];
    }

    function KiemTraEmai($email) {
//      $regule = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/';
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function KiemTraPhone($Phone) {
        if (preg_match("/^[0-9]{10,11}$/", $Phone)) {
            return $Phone;
        }
        return FALSE;
    }

//   dành cho các chuan thuan

    function BokyTuDacBiet($str) {

        if (!empty($str)) {
            $kytu = array("select", "delete", "<script>", "</script>", "insert", "update");
            foreach ($kytu as $k => $v) {
                $str = str_replace($v, "/" . $v, $str);
            }
            return $str;
        } else {
            return FALSE;
        }
    }

    static function BokyTuDacBietPaRam($str) {

        if (!empty($str)) {
            $kytu = array(";", "select", "delete", "insert", "update");
            foreach ($kytu as $k => $v) {
                $str = str_replace($v, "", $str);
            }
            return $str;
        } else {
            return FALSE;
        }
    }

    function ViewC($data, $CName = "index") {
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        if (!method_exists("Controller_" . $_Controller, $_Action)) {
            $_Action = "index";
        }
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        $_Content = __DIR__ . "/View/{$_Controller}/{$_Action}.phtml";
        $layout = "View/{$CName}/layout/{$CName}_layout.phtml";
        include_once $layout;
    }

    function ViewData($data, $_Controller = "index", $_Action = "index") {
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        $_Content = __DIR__ . "/View/{$_Controller}/{$_Action}.phtml";
        $layout = "View/{$_Controller}/layout/{$_Action}_layout.phtml";
        include_once $layout;
    }

//   view trang we

    function View($data) {
        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        if (class_exists("Controller_" . $_Controller, TRUE)) {
            if (method_exists("Controller_" . $_Controller, $_Action)) {
                $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
            } else {
                $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
            }
        } else {
            $_Content = __DIR__ . "/View/index/index.phtml";
        }
        $layout = "View/layout/layout.phtml";
        include_once $layout;
    }

    function ViewTemplate($data) {
        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        if (method_exists("Controller_" . $_Controller, $_Action)) {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout/layout.phtml";
        include_once $layout;
    }

    function TemplateView($data) {
        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Conten = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        $layout = __DIR__ . "/public/" . $this->getController() . "/layout/layout_" . $this->getController() . ".phtml";
        include_once $layout;
    }

    function tintucView($data) {
        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Action = $this->getAction();
        $_Controller = $this->getController();
        $_Param = $this->getParam();
        $_Lang = $this->getLang();
        if (method_exists("Controller_" . $_Controller, $_Action)) {
//        echo "có action";
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout/" . $this->getController() . "/layout.phtml";
        include_once $layout;
    }

    function controllerView($data) {
        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Action = $this->getAction();
        $_Controller = $this->getController();
        $_Param = $this->getParam();
        $_Lang = $this->getLang();
        if (method_exists("Controller_" . $_Controller, $_Action)) {
//        echo "có action";
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout/" . $this->getController() . "/layout.phtml";
        include_once $layout;
    }

    function ViewKhuyet($data) {

        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        // tìm quản tri
        if (method_exists("Controller_" . $_Controller, $_Action)) {
//        echo "có action";
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout_cuahang/macdinh/layout_cuahang.phtml";
        include_once $layout;
    }

    function ViewTheme($data = NULL, $theme = null, $themelayout = "") {
        if (!$theme) {
            $theme = Model_ViewTheme::get_viewthene();
        }
        if (is_array($data)) {
            if ($data)
                extract($data);
        }

        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        $_Content = __DIR__ . "/theme/" . $theme . "/" . $_Controller . "/" . $_Action . ".phtml";
        if ($themelayout == "") {
            $layout = "theme/" . $theme . "/" . "layout.phtml";
        } else {
            $themelayout = "_" . $themelayout;
            $layout = "theme/" . $theme . "/" . "layout{$themelayout}.phtml";
        }
        if (!is_file($layout)) {
//            throw new Exception("Không Có Theme");
        }
        include_once $layout;
    }

    function ViewKhuyetIndex($data) {

        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        // tìm quản tri
        if (method_exists("Controller_" . $_Controller, $_Action)) {
//        echo "có action";
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout_cuahang/macdinh/layout_cuahang_index.phtml";
        include_once $layout;
    }

    function ViewMobie($data) {

        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        // tìm quản tri
        if (method_exists("Controller_" . $_Controller, $_Action)) {
//        echo "có action";
            $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_Content = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout_mobie/layout_mobie_index.phtml";
        include_once $layout;
    }

    function QView($data) {
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        $_Lang = $this->getLang();
        $_Content = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        $layout = "View/layout/layout_quantri/index.phtml";
        include_once $layout;
    }

    function AView($data) {

        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Lang = $this->getLang();
        $_Param = $this->getParam();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $view = "View/" . $this->getController() . "/" . $this->getAction() . ".phtml";

        include_once $view;
    }

    function PTURL(&$TieuDeKD) {
        $url = self::$iurl;
        $Tree = [
//            "test"=>[
//                "/\/gioi-thieu.html/i",
//            ],
            "news" => [
                "/\/page-(.*)\/(.*)(\.html)(.*)$/i",
                "/\/page-(.*)\/(.*)(\.html)$/i",
            ]
            ,
            "pagesdetail" => [
                "/\/page-(.*)(.html)(.*)/i",
                "/\/page-(.*)(.html)/i"
            ]
            ,
            "pages" => [
                "/\/page-(.*)\/(.*)/i",
                "/\/page-(.*)\/(.*)\//i",
                "/\/page-(.*)/i",
            ]
            ,
            "product" => [
                "/\/(.*)\/(.*)(\.html)(.*)$/i",
                "/\/(.*)\/(.*)(\.html)$/i",
            ]
            ,
            "category" => array(
                "/\/(.*)\/(.*)/i",
                "/\/(.*)\/(.*)\//i",
                "/\/(.*)/i",
            ),
        ];

        foreach ($Tree as $k => $v) {
            foreach ($v as $v1) {
                if (preg_match_all($v1, $url, $pat_array)) {
                    $TieuDeKD = $pat_array;
                    $TieuDeKD["url"] = $url;
                    return $k;
                }
            }
        }
    }

    function tach_url($url, &$cname, &$action, &$params) {
        $arr = explode("/", $url);
        $cname = $arr[1];
        if ($cname == "") {
            $cname = DEFAULT_CONTROLLER;
            $action = DEFAULT_ACTION;
            $params = NULL;
            return TRUE;
        }
        if (isset($arr[2])) {
            $action = $arr[2];
        }
        if (!$action) {
            $action = DEFAULT_ACTION;
            $params = NULL;
            return TRUE;
        } else {
            // có actiom Kiểm tra action tòn tai hay khong
//         echo $action;
        }
        array_shift($arr);
        array_shift($arr);
        array_shift($arr);
        $params = $arr;
        return TRUE;
    }

    function RandomNumber($a) {
        $characters = "0123456789abcd";
        $randstring = "";
        for ($i = 0; $i < $a; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    function RandomString($a = 10) {
        $md5_hash = md5(rand(0, 9999) . time());
        $security_code = substr($md5_hash, 2, $a);
        return $security_code;
    }

    function ViewCustom($data, $themeContent, $themeLayout, $_layout = "") {
        if (!$themeContent) {
            $theme = Model_ViewTheme::get_viewthene();
        }
        if (is_array($data)) {
            if ($data)
                extract($data);
        }
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        $_Content = __DIR__ . "/theme/" . $themeContent . "/" . $_Controller . "/" . $_Action . ".phtml";
        $tl = "";
        if ($_layout) {
            $tl = "_" . $_layout;
        }
        $layout = "theme/" . $themeLayout . "/" . "layout{$tl}.phtml";
        include_once $layout;
    }

}

?>