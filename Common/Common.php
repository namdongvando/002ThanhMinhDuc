<?php

namespace Common;

class Common {

    function __construct() {

    }

    static function toUrl($url = null) {
        if ($url == null) {
            $url = $_SERVER["HTTP_REFERER"];
        }
        header("Location: " . $url);
        exit();
    }

    static function Actual_link() {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

    static function LinkQrcode($data) {
        return "/public/phpqrcode/index.php?data=" . $data;
    }

    static function RandomString($a) {
        $characters = "0123456789abcdefghjklzxcvbnmqwertyuiopasdfgh{}[]()!@#$%^&*";
        $randstring = "";
        for ($i = 0; $i < $a; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    static function bodautv($str) {
        if (!$str)
            return false;

        $str = str_replace(array(',', '<', '>', '&', '{', '}', "[", "]", '*', '?', '/', '+', '@', '%', '"'), array(' '), $str);
        $str = str_replace(array("'"), array(' '), $str);
        while (strpos($str, "  ") > 0) {
            $str = str_replace("  ", " ", $str);
        }
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $khongdau => $codau) {
            $str = preg_replace("/($codau)/i", $khongdau, $str);
        }
        $str = strtolower($str);
        $str = trim($str);
        $str = preg_replace('/[^a-zA-Z0-9\ ]/', '', $str);
        $str = str_replace(" ", "-", $str);
        return $str;
    }

    static function DeCodeHTML() {

        $str = ob_get_clean();
        $Model_Infor = new \Model\infor();
        $DSOption = $Model_Infor->infors();
        $str = str_replace("{Title}", \Model_Seo::$Title, $str);
        $str = str_replace("{Des}", \Model_Seo::$des, $str);
        $str = str_replace("{Keyword}", \Model_Seo::$key, $str);
        if ($DSOption)
            foreach ($DSOption as $k => $value) {
                $str = str_replace("{" . $value["Name"] . "}", $value["Content"], $str);
                $str = str_replace("[" . $value["Name"] . "]", $value["Content"], $str);
            }
        echo $str;
    }

    public static function DateTimeFormat() {
        return "d-m-Y H:i";
    }

    public static function DateFormat() {
        return "H:i d-m-Y";
    }

    public static function ToDate($date) {
        return date(self::DateFormat(), strtotime($date));
    }

    static function minimizeCSSsimple($css) {
        $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
        $css = preg_replace('/\s{2,}/', ' ', $css);
        $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
        $css = preg_replace('/;}/', '}', $css);
        return $css;
    }

    public static function compress_htmlcode($codedata) {
        $searchdata = array(
            '/\>[^\S ]+/s', // remove whitespaces after tags
            '/[^\S ]+\</s', // remove whitespaces before tags
            '/(\s)+/s' // remove multiple whitespace sequences
        );
        $replacedata = array('>', '<', '\\1');
        $codedata = preg_replace($searchdata, $replacedata, $codedata);
        return $codedata;
    }

    public static function CheckName($param0) {
        return strip_tags($param0);
    }

    public static function CheckPhone($param0) {
        return strip_tags($param0);
    }

    public static function CheckEmail($param0) {
        return strip_tags($param0);
    }

    public static function CheckDiaChi($formUser) {
        return strip_tags($formUser);
    }

    public static function ChekId($userPost) {
        $userPost = intval($userPost);
        $userPost = max($userPost, 0);
        return intval($userPost);
    }

    public static function CheckId($formUser) {
        return self::ChekId($formUser);
    }

    public static function PhoneFomat($number) {
        $number = preg_replace("/[^\d]/", "", $number);
        // get number length.
        $length = strlen($number);
        // if number = 10
        if ($length == 10) {
            $number = preg_replace("/^1?(\d{4})(\d{3})(\d{3})$/", "$1 $2 $3", $number);
        }
        return $number;
    }

    public static function NameFileCache($url) {
        return "cache/" . sha1($url) . ".html";
        ;
    }

    public static function PhanTrang($TongTrang, $TrangHienTai, $DuongDan) {
        $PhanTrang = ' <ul class="pagination mt-10 mb-0">';
        $PhanTrang .= "<li><a>{$TrangHienTai}/{$TongTrang}</a></li>";
        $tu = $TrangHienTai - 4;
        $den = $TrangHienTai + 4;
        $tu = $tu <= 0 ? 1 : $tu;
        if ($tu > 1) {
            $DuongDan1 = str_replace("[i]", 1, $DuongDan);
            $PhanTrang .= '<li><a href="' . $DuongDan1 . '"><<</a></li>';
        }
        if ($tu > 1) {
            $DuongDan1 = str_replace("[i]", $TrangHienTai - 1, $DuongDan);
            $PhanTrang .= '<li><a href="' . $DuongDan1 . '"><</a></li>';
        }

        $den = $den >= $TongTrang ? $TongTrang : $den;
        for ($i = $tu; $i <= $den; $i++) {
            $DuongDan1 = str_replace("[i]", $i, $DuongDan);
            if ($i == $TrangHienTai)
                $PhanTrang .= '<li class="active" ><a href="' . $DuongDan1 . '">' . $i . '</a></li>';
            else
                $PhanTrang .= '<li><a href="' . $DuongDan1 . '">' . $i . '</a></li>';
        }

        if ($den < $TongTrang) {
            $DuongDan1 = str_replace("[i]", $TrangHienTai + 1, $DuongDan);
            $PhanTrang .= '<li><a href="' . $DuongDan1 . '">></a></li>';
        }
        if ($den < $TongTrang) {
            $DuongDan1 = str_replace("[i]", $TongTrang, $DuongDan);
            $PhanTrang .= '<li><a href="' . $DuongDan1 . '">>></a></li>';
        }

        $PhanTrang .= '</ul>';
        return $PhanTrang;
    }

    public static function GetIndex($k, $pagesIndex, $pageNumber) {
        return ($pageNumber * ($pagesIndex - 1)) + $k + 1;
    }

//    function bodautv($str) {
//        if (!$str)
//            return false;
//
//        $str = str_replace(array(',', '<', '>', '&', '{', '}', "[", "]", '*', '?', '/', '+', '@', '%', '"'), array(' '), $str);
//        $str = str_replace(array("'"), array(' '), $str);
//        while (strpos($str, "  ") > 0) {
//            $str = str_replace("  ", " ", $str);
//        }
//        $unicode = array(
//            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
//            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
//            'd' => 'đ',
//            'D' => 'Đ',
//            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
//            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
//            'i' => 'í|ì|ỉ|ĩ|ị',
//            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
//            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
//            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
//            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
//            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
//            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
//            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
//        );
//        foreach ($unicode as $khongdau => $codau) {
//            $str = preg_replace("/($codau)/i", $khongdau, $str);
//        }
//        $str = strtolower($str);
//        $str = trim($str);
//        $str = preg_replace('/[^a-zA-Z0-9\ ]/', '', $str);
//        $str = str_replace(" ", "-", $str);
//        return $str;
//    }
//
}

?>