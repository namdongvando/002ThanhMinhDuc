<?php

namespace Module\trungtambaohanh\Model;

class YeuCauBaoHanhForm implements IYeuCauBaoHanh {

    const nameForm = "yecaubaphanh";

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function Id($values = null, $title = null) {
        $nameForm = self::nameForm;
        return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $values);
    }

    public static function Code($value = null, $title = null) {
        if ($title == null)
            $title = "Mã yêu cầu";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function MaTem($value = null, $title = null, $isHidden = false) {
        if ($title == null)
            $title = "Mã Tem Bảo Hành";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        if ($isHidden == true)
            return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function CreateDate($value = null, $title = null) {
        if ($title == null)
            $title = "Ngày Tạo";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function DiaChi($value = null, $title = null) {
        if ($title == null)
            $title = "Địa Chỉ";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function KhachHangTieuDung($value = null, $title = null, $isHidden = false) {
        if ($title == null)
            $title = "Khách Hàng Tiêu Dùng";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        if ($isHidden == true)
            return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Name($value = null, $title = null) {
        if ($title == null)
            $title = "Nội Dung Công Việc";
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function NgayBaoHanh($value = null, $title = null) {
        if ($title == null)
            $title = "Ngày Bảo Hành";
        $Option = self::$Option;

        if ($value == null) {
            $value = date("Y-m-d", time() + 3600 * 24);
        }
        $Option["value"] = $value;
        $Option["type"] = "date";
        $Option["min"] = date("Y-m-d", time() + 3600 * 24);
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function NoiDung($value = null, $title = null) {
        if ($title == null)
            $title = "Sự Cố Mắc Phải";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function SDT($value = null, $title = null) {
        if ($title == null)
            $title = "SĐT Liên Hệ";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["maxlength"] = 11;
        $Option["required"] = true;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function UpdateDate($value = null, $title = null) {
        if ($title == null)
            $title = "Ngày Cập Nhật";
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "date";
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

}
?>

