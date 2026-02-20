<?php

namespace Model;

use Application;
use Datatable\Response;
use Datatable\Table;
use Module\quanlysanpham\Model\PhieuNhapKho;
use Module\quanlysanpham\Model\PhieuXuatNhap\PhieuXuatNhap;
use PSpell\Config;

class Common
{

    const SuaLenhThuMua = "SuaLenhThuMua";
    const Date_TIME_FOMAT_DATABASE = "Y-m-d H:i:s";
    const Date_FOMAT_VIEW = "d-m-Y";
    const DateTime_FOMAT_VIEW = "H:i d-m-Y";
    public function __construct()
    {
    }
    static function json_encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    static function json_decode($data)
    {
        return json_decode($data, JSON_OBJECT_AS_ARRAY);
    }



    static function SetCol($className, $dataPost)
    {
        $fileName = "database/" . md5($className) . ".json";
        file_put_contents($fileName, Common::json_encode($dataPost));
    }
    static function GetTableStyle($className)
    {
        $fileName = "database/" . md5($className) . ".json";
        $cols = Common::json_decode(file_get_contents($fileName)) ?? [];
        $col_Name = [];
        self::usortbyindex($cols);
        foreach ($cols as $key => $value) {
            // var_dump($value);
            if ($value["isshow"] == 1) {
                $col_Name[] = $value['width'];
            }
        }

        return $col_Name ?? [];
    }
    static function GetCol($className)
    {
        $fileName = "database/" . md5($className) . ".json";
        $cols = Common::json_decode(file_get_contents($fileName)) ?? [];
        $col_Name = [];
        self::usortbyindex($cols);
        foreach ($cols as $key => $value) {
            if ($value["isshow"] == 1) {
                $col_Name[$value['id']] = ElementHTML::tag("span", $value['ctitle'], []);
            }
        }
        return $col_Name ?? [];
    }



    public static function ViewGoiThau($str)
    {
        return "<div class='line-text' >{$str}</div>";
    }
    public static function ViewTongTienDK($str)
    {
        return "<div class='text-right line-text text-italic' >{$str}</div>";
    }
    public static function ViewTongTien($str)
    {
        return "<div class='text-right line-text' >{$str}</div>";
    }
    public static function ViewMaPhieu($str)
    {
        return "<div class='text-center line-text' >{$str}</div>";
    }

    static function CheckedToArrayTable($ar)
    {
        $a = [];
        foreach ($ar as $v) {
            $a[] = $v;
        }
        return $a;
    }
    public static function ViewHTTT($str)
    {
        return self::TextCenter($str);
    }

    static function StrToSqlIn($list)
    {
        $DSMaSanPham = implode("','", $list);
        return "`Id` in ('{$DSMaSanPham}') ";
    }
    static function StrToSqlInCol($colName, $list)
    {
        $DSMaSanPham = implode("','", $list);
        return " and `{$colName}` in ('{$DSMaSanPham}') ";
    }

    static function var_dump($content)
    {
        echo "<pre>";
        var_dump($content);
        echo "</pre>";
    }

    static function JsonToArrayColumn($ColumnsPhieuNhapHang)
    {
        if (file_exists("Module/quanlysanpham/public/{$ColumnsPhieuNhapHang}.json")) {
            $content = file_get_contents("Module/quanlysanpham/public/{$ColumnsPhieuNhapHang}.json");
            $ac = json_decode($content, JSON_OBJECT_AS_ARRAY);
            foreach ($ac as $k => $v) {
                $ac[$k] = Lang($v);
            }
            return $ac;
        }
        return null;
    }
    static function TextCenter($str)
    {
        return "<div class='text-center' >{$str}</div>";
    }
    static function TextRight($str)
    {
        return "<div class='text-right' >{$str}</div>";
    }

    public static function HeaderJSON()
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    static function IntInput($str)
    {
        return intval($str);
    }
    static function ViewDateInputOrNull($str)
    {
        if ($str === null) {
            return "";
        }
        return date("Y-m-d", strtotime($str));
    }
    static function ViewDateInput($str)
    {
        if ($str == null) {
            return date("Y-m-d", time());
        }
        return date("Y-m-d", strtotime($str));
    }
    static function ViewDateTimeInput($str)
    {
        if ($str == null) {
            return "";
        }
        return date("Y-m-d\TH:i:s", strtotime($str));
    }
    static function DateInput($str = null)
    {
        if ($str == null) {
            return date(self::Date_TIME_FOMAT_DATABASE, time());
        }
        return date(self::Date_TIME_FOMAT_DATABASE, strtotime($str));
    }

    static function ContentToHTMLFile($str)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
        }

        body {
            margin: 0;
            width: 100%;
        }
        @page { margin: 0px; }

        .bg-primary {
            color: #F24822;
            background-color: #A9D08F;
        }

        .table-infor table,
        .table-infor th,
        .table-infor td {
            border: 1px solid #eee;
        }

        table,
        th,
        td {
            border: 0px solid #aaa;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        td {
            padding: 5px;
        } 

        .table-infor {
            margin: auto;
            margin-bottom: 25px;
        }
    </style>

</head>
<body  > {$str}</body> 
</html> 
HTML;
    }
    static function DBNow()
    {
        return date("Y-m-d H:i:s", time());
    }

    static function RenderToString($ob, $funcname)
    {
        ob_start();
        $ob->$funcname();
        $str = ob_get_clean();
        return $str;
    }

    static function GetTemplate($temptale)
    {
        $fileName = "public/Formtemplate/{$temptale}.html";
        if (file_exists($fileName)) {
            return file_get_contents($fileName);
        }
        return "";
    }
    static function SetTemplate($temptale, $content)
    {
        return file_put_contents("public/Formtemplate/{$temptale}.html", $content);
    }

    static function getslug($string)
    {

        $search = array(
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        );
        $replace = array(
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        );
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }

    public static function ToUrl($url = null)
    {
        if ($url === null) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        header("Location: " . $url);
        exit();
    }

    public static function StrListId($text)
    {
        $text = trim($text);
        $text = str_replace(" ", "", $text);
        $text = str_replace("   ", "", $text);
        return $text;
    }

    static function Floatval($str)
    {

        if ($str) {
            $str = str_replace(",", "", $str);
            $str = floatval($str);
            return $str;
        }
        return 0;

    }
    static function Intval($str)
    {
        if ($str == "") {
            return 0;
        }
        $str = str_replace(",", "", $str);
        $str = intval($str);
        return $str;
    }

    public static function TextInput($text)
    {
        if (is_string($text)) {
            $text = trim($text);
            $text = htmlspecialchars($text);
            $text = addslashes($text);
            return $text;
        }
        return "";
    }
    public static function NumberToStringFomatZero($value, $numString = 6)
    {
        return str_pad($value, $numString, '0', STR_PAD_LEFT);
    }
    public static function uuid()
    {
        $namespace = rand(1000000, time());
        $guid = hash("sha256", time() . $namespace);
        $uid = uniqid(time(), true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash, 0, 8) . '-' .
            substr($hash, 8, 4) . '-' .
            substr($hash, 12, 4) . '-' .
            substr($hash, 16, 4) . '-' .
            substr($hash, 20, 12);
        return $guid;
    }

    public static function IsEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function DateTimeFomatDatabase()
    {
        return "Y-m-d H:i:s";
    }
    public static function DateTimeFomat()
    {
        return "d-m-Y H:i:s";
    }

    public static function DateTimeFomatView()
    {
        return "d-m-Y";
    }

    public static function DateFomatDatabase()
    {
        return "Y-m-d";
    }


    static function ViewQCHH($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "text-center line-text"
        ]);
    }
    static function ViewDVT($giaBan, $prop = [])
    {
        if ($prop == false) {
            $prop = [
                "class" => "text-center line-text"
            ];
        }
        return ElementHTML::tag("div", $giaBan, $prop);
    }
    static function ViewGiaBan($giaBan, $prop = [])
    {
        if ($prop == false) {
            $prop = [
                "class" => "text-center"
            ];
        }
        if (!is_numeric($giaBan)) {
            return ElementHTML::tag("div", "", $prop);
        }
        if ($giaBan == null) {
            return ElementHTML::tag("div", "", $prop);
        }

        return ElementHTML::tag("div", self::ViewPrice($giaBan, false), $prop);
    }
    static function ViewGiaDuKien($giaBan)
    {
        if (!is_numeric($giaBan)) {
            return "";
        }
        if ($giaBan == null) {
            return "";
        }
        return ElementHTML::tag("div", self::ViewPrice($giaBan, false), [
            "class" => "line-text text-center text-italic"
        ]);
    }
    static function ViewThanhTienDK($giaBan)
    {
        return ElementHTML::tag("div", Common::ViewPrice($giaBan, false), [
            "class" => "line-text text-right text-italic"
        ]);
    }
    static function ViewThanhTien($giaBan, $prop = false)
    {
        if ($prop == false) {
            $prop = [
                "class" => "line-text thanhtientt text-right"
            ];
        }
        return ElementHTML::tag("div", Common::ViewPrice($giaBan, false), $prop);
    }
    static function ViewTenNhaThau($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "line-text"
        ]);
    }
    static function ViewId($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "text-center"
        ]);
    }
    static function ViewSoNgay($giaBan)
    {
        if ($giaBan == null) {
            return "";
        }
        return ElementHTML::tag("div", Common::ViewNumber($giaBan) . " ngày", [
            "class" => "text-center"
        ]);
    }
    static function ViewSoLuong($giaBan)
    {
        if ($giaBan == null) {
            return "";
        }
        return ElementHTML::tag("div", Common::ViewNumber($giaBan), [
            "class" => "text-center"
        ]);
    }
    static function ViewMaHangHoa($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "text-center"
        ]);
    }
    static function ViewDiaChi($diaChi)
    {
        return ElementHTML::tag("div", $diaChi, [
            "class" => "line-text",
            "style" => "max-width: 250px; text-overflow: ellipsis; white-space: nowrap;overflow: hidden;",

        ]);
    }
    static function ViewSoHopDong($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "text-center"
        ]);
    }
    static function ViewNgay($giaBan)
    {
        return ElementHTML::tag("div", Common::ViewDate($giaBan), [
            "class" => "text-center"
        ]);
    }
    static function ViewUserId($giaBan)
    {
        return ElementHTML::tag("div", $giaBan, [
            "class" => "text-center"
        ]);
    }

    public static function ValueDate($strdate)
    {
        if ($strdate) {
            return date("Y-m-d", strtotime($strdate));
        }
        return null;
    }
    public static function ViewDate($strdate, $fomat = null)
    {
        if ($fomat == null) {
            $fomat = self::Date_FOMAT_VIEW;
        }
        if ($strdate) {
            return date($fomat, strtotime($strdate));
        }
        return null;
    }
    public static function ViewDay($ngay)
    {
        return $ngay . ' ngày';
    }
    public static function ViewDateTime($strdate, $fomat = null)
    {
        if ($fomat == null) {
            $fomat = self::DateTime_FOMAT_VIEW;
        }
        return date($fomat, strtotime($strdate));
    }
    public static function StrToDateDB($strdate)
    {
        return date(\Model\Common::DateFomatDatabase(), strtotime($strdate));
    }
    public static function StrToDateTimeDB($strdate)
    {
        return date(\Model\Common::DateTimeFomatDatabase(), strtotime($strdate));
    }

    public static function ForMatDMY($strdate)
    {
        return date(\Model\Common::DateFomatView(), strtotime($strdate));
    }

    public static function ForMatDMYHIS($strdate)
    {
        return date(\Model\Common::DateTimeFomat(), strtotime($strdate));
    }

    public static function DateFomatView()
    {
        return "d-m-Y";
    }
    public static function Pagination($dataparams, $Module = null, $Controller = null, $action = null)
    {
        $item["TotalPage"] = ceil($dataparams["Total"] / $dataparams["PageNumber"]);
        $item["PageIndex"] = $dataparams["PageIndex"];
        $item["PageNumber"] = $dataparams["PageNumber"];
        if ($Module == null) {
            $Module = "";
        }
        if ($Controller == null) {
            $Controller = Application::$controller;
        }
        if ($action == null) {
            $action = Application::$action;
        }

        $LinkPhanTrang = "/{$Module}/{$Controller}/$action/";
        if ($Module == null) {
            $LinkPhanTrang = "/{$Controller}/$action/";
        }
        $dataparams["Params"]["PageIndex"] = "_i_";
        $dataparams["Params"]["PageNumber"] = $item["PageNumber"];
        $LinkPhanTrang .= http_build_query($dataparams["Params"]);
        $LinkPhanTrang = str_replace("_i_", "[i]", $LinkPhanTrang);
        // echo $LinkPhanTrang;
        return self::PhanTrang($item["TotalPage"], $item["PageIndex"], $item["PageNumber"], $LinkPhanTrang);
    }
    public static function PhanTrang($TongSoDong, $TrangThuBaoNhieu, $SoDong, $LinkPhanTrang)
    {
        $SoDong = max(1, intval($SoDong));
        $TrangThuBaoNhieu = max(1, intval($TrangThuBaoNhieu));
        $SoTrang = ceil($TongSoDong / $SoDong);
        $SoTrang = max(0, $SoTrang);
        $TrangTrai = $TrangThuBaoNhieu - 1;
        $TrangTrai = max(1, $TrangTrai);
        $TrangPhai = $TrangThuBaoNhieu + 1;
        $TrangPhai = min($TrangPhai, $SoTrang);
        $TrangMin = $TrangThuBaoNhieu - 3;
        $TrangMin = $TrangThuBaoNhieu - 3;
        $TrangMin = max(1, $TrangMin);
        $TrangMax = $TrangThuBaoNhieu + 3;
        $TrangMax = min($TrangMax, $SoTrang);
        $TrangTraiCham = $TrangThuBaoNhieu - 7;
        $TrangTraiCham = max(1, $TrangTraiCham);
        $TrangPhaiCham = $TrangThuBaoNhieu + 7;
        $TrangPhaiCham = min($TrangPhaiCham, $SoTrang);

        $_linkTrangDau = str_replace("[i]", 1, $LinkPhanTrang);
        $_linkTrangTrai = str_replace("[i]", $TrangTrai, $LinkPhanTrang);
        $_linkTrangCuoi = str_replace("[i]", $SoTrang, $LinkPhanTrang);
        $_linkTrangPhai = str_replace("[i]", $TrangPhai, $LinkPhanTrang);
        $_linkTrangTraiCham = str_replace("[i]", $TrangTraiCham, $LinkPhanTrang);
        $_linkTrangPhaiCham = str_replace("[i]", $TrangPhaiCham, $LinkPhanTrang);


        ob_start();
        ?>
        <ul class="pagination pagination-md no-margin">
            <li><a>
                    <?php echo $TrangThuBaoNhieu . "/" . $SoTrang; ?>
                </a></li>
            <li><a href="<?php echo $_linkTrangDau ?>"><i class="fa fa-angle-double-left"></i></a></li>
            <li><a href="<?php echo $_linkTrangTrai ?>"><i class="fa fa-angle-left"></i></a></li>
            <li class="hidden-xs"><a href="<?php echo $_linkTrangTraiCham ?>">...</a></li>
            <?php
            for ($index = $TrangMin; $index <= $TrangMax; $index++) {
                $_link = str_replace("[i]", $index, $LinkPhanTrang);
                ?>
                <li class="<?php echo $TrangThuBaoNhieu == $index ? 'active' : ''; ?>">
                    <a href="<?php echo $_link; ?>">
                        <?php echo $index; ?>
                    </a>
                </li>
                <?php
            }
            ?>
            <li class="hidden-xs"><a href="<?php echo $_linkTrangPhaiCham ?>">...</a></li>
            <li><a href="<?php echo $_linkTrangPhai ?>"><i class="fa fa-angle-right"></i></a></li>
            <li><a href="<?php echo $_linkTrangCuoi ?>"><i class="fa fa-angle-double-right"></i></a></li>
        </ul>
        <?php
        $str = ob_get_clean();
        return $str;
    }

    public static function BoDauTienViet($str)
    {
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

    public static function ViewPrice($number, $hasTag = true)
    {
        if (!is_numeric($number)) {
            return "";
        }
        if ($hasTag) {
            return "<p style='white-space: nowrap;' >" . number_format($number ?? 0, 0, ".", ",") . " đ" . "</p>";
        }
        return number_format($number ?? 0, 0, ",", ".") . " đ";
    }

    static public function ToolTipProp($var, $placement = "top")
    {
        return [
            "data-toggle" => "tooltip",
            "data-placement" => $placement,
            "title" => $var
        ];

    }
    static public function ToolTip($var, $placement = "top")
    {
        return 'data-toggle="tooltip" data-placement="' . $placement . '" title="' . $var . '"';
    }
    static public function ToolTipElement($content, $contentView = null, $placement = "top")
    {
        ob_start();
        ?>
        <span <?php echo self::ToolTip($content, $placement); ?>>
            <?php echo $contentView; ?>
        </span>
        <?php
        $str = ob_get_clean();
        return $str;
    }
    public static function ViewNumber($number, $ot = 0)
    {
        if ($number === null) {
            return "";
        }
        if ($number === "") {
            return $number;
        }
        return number_format(Common::Floatval($number ?? 0), $ot, ".", ",");
    }
    public static function ViewNumberFloat($number)
    {
        return number_format($number ?? 0, 2, ".", ".");
    }
    public static function ViewPersenInt($number, $hasTag = true)
    {
        if ($hasTag) {
            return "<p style='white-space: nowrap;' >" . number_format($number ?? 0, 0, ".", ".") . " %" . "</p>";
        }
        return number_format($number ?? 0, 0, ",", ".") . " %";
    }
    public static function ViewPersen($number, $hasTag = true)
    {
        if ($hasTag) {
            return "<p style='white-space: nowrap;' >" . number_format($number ?? 0, 2, ".", ".") . " %" . "</p>";
        }
        return number_format($number ?? 0, 2, ".", ".") . " %";
    }
    public static function ViewTaxPersen($number, $hasTag = true)
    {
        if ($hasTag) {
            return "<p style='white-space: nowrap;' >" . number_format($number ?? 0, 1, ".", ".") . " %" . "</p>";
        }
        return number_format($number ?? 0, 1, ".", ".") . " %";
    }


    public static function CheckName($param)
    {
        return strip_tags($param);
    }

    public static function DateTime()
    {
        return date("Y-m-d H:i:s", time());
    }

    public static function TextInputNoHtml($text)
    {
        $text = strip_tags($text);
        $text = trim($text);
        $text = addslashes($text);
        return $text;
    }

    public static function Index($index, $indexPage, $pageNumber)
    {
        return ($indexPage - 1) * $pageNumber + $index + 1;
    }

    public static function DaysInMonth($month, $year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public static function NameDateByDate($ngayThanhNam, $isvalue = false)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $weekday = date("l", strtotime($ngayThanhNam));
        $weekday = strtolower($weekday);

        $a = [
            "monday" => "Thứ Hai",
            "tuesday" => "Thứ ba",
            "wednesday" => "Thứ Tư",
            "thursday" => "Thứ Năm",
            "friday" => "Thứ Sáu",
            "saturday" => "Thứ Bảy",
            "sunday" => "Chủ Nhật",
        ];
        if ($isvalue == FALSE)
            return $a[$weekday];
        return $weekday;
    }

    public static function FromDateToDateToList($begin, $end)
    {
        $begin = new \DateTime($begin);
        $end = new \DateTime($end);
        $end->setTime(0, 0, 1);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);
        $dateList = [];
        foreach ($period as $dt) {
            $dateList[] = $dt->format("Y-m-d");
        }
        return $dateList;
    }

    public static function NgayTrongTuan()
    {
        $a = [
            "monday" => "Thứ Hai",
            "tuesday" => "Thứ ba",
            "wednesday" => "Thứ Tư",
            "thursday" => "Thứ Năm",
            "friday" => "Thứ Sáu",
            "saturday" => "Thứ Bảy",
            "sunday" => "Chủ Nhật",
        ];
        return $a;
    }

    static function ObjToTableHtml($objArray, $prop = [])
    {
        $classTable = $prop["class"] ?? "";
        $idTable = $prop["id"] ?? "";
        $htmlTable = "";
        foreach ($objArray as $k => $v) {
            $htmlTable .= <<<TABLETR
            <tr>
                <td>{$k}</td>
                <td>{$v}</td>
            </tr>
TABLETR;
        }
        $str = <<<HTML
    <table class="{$classTable}" id="{$idTable}" >
    {$htmlTable}
    </table>

HTML;
        return $str;
    }

    public static function ViewNumberToText($number)
    {
        $a = new Common();
        return $a->convert_number_to_words($number);
    }
    public static function ViewSTT($index)
    {
        return ElementHTML::tag("div", $index, ["class" => "text-center"]);
    }
    public static function ViewMaNhaThau($index)
    {
        return ElementHTML::tag("div", $index, ["class" => "text-center"]);
    }
    public static function ViewNCC($nccname, $prop = [])
    {
        return ElementHTML::tag(
            "div",
            $nccname,
            [
                "data-toggle" => "tooltip",
                "data-html" => "true",
                "class" => "text-over",
                "title" => $nccname
            ] + $prop
        );
    }

    function convert_number_to_words($number)
    {
        $hyphen = ' ';
        $conjunction = '  ';
        $separator = ' ';
        $negative = 'âm ';
        $decimal = ', ';
        $dictionary = array(
            0 => 'không',
            1 => 'một',
            2 => 'hai',
            3 => 'ba',
            4 => 'bốn',
            5 => 'năm',
            6 => 'sáu',
            7 => 'bảy',
            8 => 'tám',
            9 => 'chín',
            10 => 'mười',
            11 => 'mười một',
            12 => 'mười hai',
            13 => 'mười ba',
            14 => 'mười bốn',
            15 => 'mười năm',
            16 => 'mười sáu',
            17 => 'mười bảy',
            18 => 'mười tám',
            19 => 'mười chín',
            20 => 'hai mươi',
            30 => 'ba mươi',
            40 => 'bốn mươi',
            50 => 'năm mươi',
            60 => 'sáu mươi',
            70 => 'bảy mươi',
            80 => 'tám mươi',
            90 => 'chín mươi',
            100 => 'trăm',
            1000 => 'nghìn',
            1000000 => 'triệu',
            1000000000 => 'tỷ',
            1000000000000 => 'nghìn tỷ',
            1000000000000000 => 'nghìn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );
        if (!is_numeric($number)) {
            return false;
        }
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }
        $string = $fraction = null;
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $hundreds = intval($hundreds);
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        return $string;
    }

    static function ArrayToGridHTML($data, $classCss = "")
    {
        $html = "";
        foreach ($data as $key => $value) {
            $html .= "<div class='keyitem {$classCss}' >{$key}:</div><div class='{$classCss} valueitem' >{$value}</div>";
        }

        return '<div class="itemDetail">' . $html . '</div>';
    }
    static function ArrayToGridHTMLClass($data, $classCss = "")
    {
        $html = "";
        $index = 0;
        foreach ($data as $key => $value) {
            if (is_array($classCss)) {
                $classCsshtml = $classCss[$index++] ?? "";
            } else {
                $classCsshtml = $classCss;
            }
            $html .= "<div class='{$classCsshtml}' ><b>{$key}</b>: {$value}</div>";
        }
        return $html;
    }

    static function Lang($content)
    {
        return $content;
    }
    static function GetFirsString($name)
    {
        $name = self::BoDauTienViet($name);
        $name = strtoupper($name);
        $name = trim($name);
        $name = str_replace("-", " ", $name);

        $nameArray = explode(" ", $name);
        $nameStr = "";
        if ($nameArray) {
            foreach ($nameArray as $key => $value) {
                if ($value) {
                    $_varray = substr($value, 0, 1);
                    $nameStr .= $_varray;
                }
            }
        }
        return $nameStr;
    }

    function SaveCache($key, $value)
    {

    }

    static function DataToTable(
        $Items,
        $columnName,
        $className,
        $prop
    ) {


        $HasAction = $prop["HasAction"] ?? false;
        $thead = $prop["headtable"] ?? "";
        $tfoot = $prop["foottable"] ?? "";
        $items1 = [];
        foreach ($Items as $key => $value) {
            $items1[] = $value;
        }
        $response = new Response();
        $response->items = $items1;
        $response->rows = $items1;
        $response->columns = $columnName;
        $table = new MyTable($response->ToRow(), $className, $HasAction);
        $table->tfoot = $tfoot;
        $table->thead = $thead;
        $table->setPropTable($prop);
        return $table->ToString();

    }

    static function GetTemplateName($id)
    {
        $a = [
            "thongbaophieunhaphang" => Lang("Thông báo phiếu nhập kho"),
            "nhapkho" => Lang("Phiếu nhập kho"),
            "xuatkho" => Lang("Phiếu xuất kho"),
            "dathang" => Lang("Phiếu đặt hàng"),
            "phieuxuathang" => Lang("Phiếu xuất hàng")
        ];
        return $a[$id] ?? $id;
    }
    static function usortbyindex(&$itemPost)
    {
        usort(
            $itemPost,
            function ($a, $b) {
                $a = isset($a['index']) ? intval($a['index']) : 1;
                $b = isset($b['index']) ? intval($b['index']) : 0;
                if ($a == $b) {
                    return 0;
                }
                return ($a > $b) ? 1 : -1;
            }
        );
    }
    static function DropdownMenu($listBtn, $prop = [])
    {
        $propstr = ElementHTML::setPropTable($prop);

        return <<<HTML

        <span {$propstr} class="btn-group">
                    <a class="dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="true">
                        <i class="fa fa-caret-down"></i>
                    </a>
            <div class="dropdown-menu " role="menu">
                    {$listBtn}
            </div>
        </span>

HTML;

    }

    public static function GetFromDateToDate($item, $name)
    {
        $listvalueName = [];
        foreach ($item as $k => $v) {
            $listvalueName[] = $v[$name];
        }
        // $listvalueName
        // Common::var_dump($listvalueName);
        return [
            "fromDate" => min($listvalueName),
            "toDate" => max($listvalueName),
        ];

    }

    public static function DropdownMenuToolbox($listBtn)
    {
        $strbtn = "";

        foreach ($listBtn as $k => $v) {
            $strbtn .= "<li>" . $v . "</li>";
        }

        return <<<HTML

    <div class="btn-group">
        <button style="height: 30px;line-height: 20px;" class="btn btn-xs btn-primary dropdown-toggle"
            data-toggle="dropdown" aria-expanded="true">
            <i class="fa  fa-ellipsis-h"></i>
        </button>
        <ul class="dropdown-menu pull-right" style="200px"  role="menu">
            {$strbtn}
        </ul>
    </div>

HTML;

    }
    public static function DropdownMenuToolboxNoBtn($listBtn)
    {
        $strbtn = "";

        foreach ($listBtn as $k => $v) {
            $strbtn .= "<li>" . $v . "</li>";
        }

        return <<<HTML

    <div class="btn-group">
    <button style="border-radius: 25% !important;height: 30px;line-height: 20px; color: #fff;box-shadow: 0px 0px 8px #FFE inset;" class="btn btn-xs dropdown-toggle"
            data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu pull-right" role="menu" style="min-width: 200px;">
            {$strbtn}
        </ul>
    </div>

HTML;

    }

    static function OnInvalid($mess)
    {
        return [
            FormRender::Required => 1,
            "oninvalid" => "this.setCustomValidity('{$mess}')",
            "oninput" => "this.setCustomValidity('')",
        ];
    }
    static function Remover_Empty($a1)
    {
        foreach ($a1 as $key => $value) {
            if ($value == "" || $value == null) {
                unset($a1[$key]);
            }
        }
        return $a1;
    }
    static function Mer_Request($a1, $a2)
    {
        $a3 = [];
        if (is_array($a1)) {
            $a3 = array_merge($a3, $a1);
        } else {
            $a3 = array_merge($a3, [$a1]);
        }
        if (is_array($a2)) {
            $a3 = array_merge($a3, $a2);
        } else {
            $a3 = array_merge($a3, [$a2]);
        }
        $a3 = array_unique($a3);
        return $a3;
    }

    static function DataToTableHTML($data, $prop)
    {
        $tr = "";
        foreach ($data as $key => $value) {
            $td = "";
            foreach ($value as $k => $v) {
                $td .= ElementHTML::tag("td", $v, []);
            }
            $tr .= ElementHTML::tag("tr", $td, []);
        }
        return ElementHTML::tag("table", $tr, $prop);
    }



}
