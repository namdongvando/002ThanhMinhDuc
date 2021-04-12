<?php

class ApplicationM {

    static public $iurl;
    static public $Module;
    static public $controller;
    static public $action;
    static public $params;

    function __construct($url = "") {
        self::$iurl = $url;
        $this->tach_url($url, self::$Module, self::$controller, self::$action, self::$params);
    }

    static function getModule() {
        return self::$Module;
    }

    static function getController() {
        return self::$controller;
    }

    static function setModule($nameModule) {
        return self::$Module = $nameModule;
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

    static function getParam($index = null) {
        if (self::$params) {
            foreach (self::$params as $v => $param) {
                self::$params[$v] = self::BokyTuDacBietPaRam(self::$params[$v]);
            }
            if ($index !== null) {
                return self::$params[$index];
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
        $Conten = __DIR__ . "/View/{$_Controller}/{$_Action}.phtml";
        $layout = "View/{$CName}/layout/{$CName}_layout.phtml";
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
            $_NoiDungChinh = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_NoiDungChinh = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
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
            $_NoiDungChinh = __DIR__ . "/View/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        } else {
            $_NoiDungChinh = __DIR__ . "/View/" . $this->getController() . "/index.phtml";
        }
        $layout = "View/layout/" . $this->getController() . "/layout.phtml";
        include_once $layout;
    }

    function AView($data = null) {

        if ($this->getController() == "") {
            $this->controller = "index";
        }
        if ($this->getAction() == "") {
            $this->action = "index";
        }
        $_Module = $this->getModule();
        $_Param = $this->getParam();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $view = "Module/{$_Module}/Views/" . $this->getController() . "/" . $this->getAction() . ".phtml";
        include_once $view;
    }

    function PTURL(&$TieuDeKD) {
        $Model_Pages = new Model_Pages();
        $url = self::$iurl;
        $Tree = [
            "thanhtoan" => array(
                "/thanh-toan.html$/i",
                "/thanh-toan.html(.*)$/i",
            )
//            chi tiết bài viết
            , "sysbaivietdetail" => array(
                "/\/(.*)\/(.*)(\.html)(.*)$/i",
                "/\/(.*)\/(.*)(\.html)$/i",
            )
//            chi tiết Pages
            , "syspagedetail" => array(
                "/\/(.*).html$/i",
            )
//            pages
            , "syspage" => array(
                "/\/(.*)\/?pages-(.*)/i",
                "/\/(.*)\/?pages-(.*)\//i",
                "/\/(.*)/i",
                "/\/(.*)\//i",
            )
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

//        return "index";
//        //        chi tiết bài viết / sản phẩm
//        preg_match_all("/\/(.*)\/(.*)(\.html)(.*)$/i", $url, $pat_array);
//        if (isset($pat_array[1][0])) {
//            $TieuDeKD = array();
//            $TieuDeKD[] = $pat_array[1][0];
//            $TieuDeKD[] = $pat_array[2][0];
//            return 3;
//        }
////       chi tiết Pages
//        preg_match_all("/\/(.*)(\.html)$/i", $url, $pat_array);
//        if (isset($pat_array[1][0])) {
//            $TieuDeKD = $pat_array[1][0];
//            return 1;
//        }
////        danh muc danh sách bài viết / sản pham
//        preg_match_all("/\/(.*)\//i", $url, $pat_array);
//        if (isset($pat_array[1][0])) {
//            $TieuDeKD = $pat_array[1][0];
//            $url = explode("/", $url);
//            $KQ = $Model_DanhMuc->TimDanhMucTieuDe($TieuDeKD);
//            if ($KQ) {
//                return 2;
//            }
//            $KQ = $Model_Pages->TimPages4TieuDeKD($TieuDeKD);
//            if ($KQ) {
//                return 4;
//            }
//            return FALSE;
//        }
////        danh muc danh sách bài viết/ sản phẩm
//        preg_match_all("/\/(.*)/i", $url, $pat_array);
//        if (isset($pat_array[1][0])) {
//            $TieuDeKD = $pat_array[1][0];
//            if (isset($url[2])) {
//                if ($url[2]) {
//                    return FALSE;
//                }
//            }
//            $KQ = $Model_DanhMuc->TimDanhMucTieuDe($TieuDeKD);
//            if ($KQ) {
//                return 2;
//            }
//            $KQ = $Model_Pages->TimPages($TieuDeKD);
//            if ($KQ) {
//                return 4;
//            }
//            return FALSE;
//        }
//        return FALSE;
    }

    function Modules() {
        return ["app"];
    }

    function CheckModules($mn) {
        return in_array($mn, $this->Modules());
    }

    function tach_url($url, &$Module, &$cname, &$action, &$params) {
        $arr = explode("/", $url);
//        print_r($arr);
//        echo "---;";
//        var_dump($arr);
//        echo $arr[1];
        $Module = $arr[1];

        if ($Module == "") {
            $Module = DEFAULT_MODULE;
        }

        $cname = isset($arr[2]) ? $arr[2] : "";
        if ($cname == "") {
            $cname = DEFAULT_CONTROLLER;
            $action = DEFAULT_ACTION;
            $params = NULL;
            return TRUE;
        }
        if (isset($arr[3])) {
            $action = $arr[3];
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

    function ModelView($data = null, $layout = "") {
        $_Module = $this->getModule();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        if ($data)
            extract($data);
        $layout = $layout == "" ? "layout.phtml" : "layout_{$layout}.phtml";
        $_Content = sprintf("Module/%s/Views/%s/%s.phtml", $this->getModule(), $this->getController(), $this->getAction());
        $layout = sprintf("Module/%s/Views/Layout/%s", $this->getModule(), $layout);

        if (!file_exists($layout))
            throw new Exception("Không có file");
        include_once $layout;
    }

    function ModelViewModule($data = null, $Module = null, $layout = "") {

        $_Module = $this->getModule();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        if ($data)
            extract($data);

        if ($Module) {
            $Module = $this->getModule();
        }

        $layout = $layout == "" ? "layout.phtml" : "layout_{$layout}.phtml";
        $_Content = sprintf("Module/%s/Views/%s/%s.phtml", $this->getModule(), $this->getController(), $this->getAction());
        $layout = sprintf("Module/%s/Views/Layout/%s", $Module, $layout);
        if (file_exists($layout))
            include_once $layout;
    }

    function ViewTheme($data = NULL, $theme = null, $themelayout = "") {
        $_Module = $this->getModule();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        if ($data)
            extract($data);
        if (!$theme) {
            $theme = Model_ViewTheme::get_viewthene();
        }
        $_Content = sprintf("theme/%s/Module/%s/%s/%s.phtml", $theme, $this->getModule(), $this->getController(), $this->getAction());
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

    function ViewThemeModlue($data = NULL, $theme = null, $themelayout = "") {
        $_Module = $this->getModule();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        if ($data)
            extract($data);
        if (!$theme) {
            $theme = \Core\ViewTheme::get_viewthene();
        }
        $_Content = sprintf("Module/%s/Views/%s/%s.phtml", $this->getModule(), $this->getController(), $this->getAction());
        if ($themelayout == "") {
            $layout = "theme/" . $theme . "/" . "layout.phtml";
        } else {
            $themelayout = "_" . $themelayout;
            $layout = "theme/" . $theme . "/" . "layout{$themelayout}.phtml";
        }
        if (!is_file($layout)) {
            throw new Exception("Không Có Theme");
        }
        include_once $layout;
    }

    function ViewThemeModule($data = NULL, $theme = null, $themelayout = "") {
        $_Module = $this->getModule();
        $_Controller = $this->getController();
        $_Action = $this->getAction();
        $_Param = $this->getParam();
        if ($data)
            extract($data);
        if (!$theme) {
            $theme = \Core\ViewTheme::get_viewthene();
        }
        $_Content = sprintf("Module/%s/Views/%s/%s.phtml", $this->getModule(), $this->getController(), $this->getAction());
        if ($themelayout == "") {
            $layout = "theme/" . $theme . "/" . "layout.phtml";
        } else {
            $themelayout = "_" . $themelayout;
            $layout = "theme/" . $theme . "/" . "layout{$themelayout}.phtml";
        }
        if (!is_file($layout)) {
            throw new Exception("Không Có Theme");
        }
        include_once $layout;
    }

}

?>