<?php

namespace Module\trungtambaohanh\Model;

class TrungTamBaoHanhForm extends \PFBC\Form implements ITrungTamBaoHanhForm {

    const nameForm = "ttbh";

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function Address($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox("Địa Chỉ", "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Hotline($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox("SĐT", "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Id($value = null) {
        $nameForm = self::nameForm;
        return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
    }

    public static function KhuVuc($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        $Options = \Module\option\Model\Option::GetAll2OptionsByGroups(\Module\option\Model\Option::KhuVuc);
        return new \PFBC\Element\Select("Khu Vực", "{$nameForm}[" . __FUNCTION__ . "]", $Options, $Option);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox("Tên Trung Tâm", "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function TenNhanVien($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox("Tên Nhân Viên", "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function UserId($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        $Options = \Module\user\Model\Admin::GetUsersByGroups2Options([\Module\user\Model\Admin::TTBH]);

        $Options = array_merge(["0" => "Chọn Tài Khoản"], $Options);
        return new \PFBC\Element\Select("Tài Khoản", "{$nameForm}[" . __FUNCTION__ . "]", $Options, $Option);
    }

    public static function btnThem(
    $btnThem) {
        $link = <<<Link
                <a href="/trungtambaohanh/index/add/" class="btn btn-success" >{$btnThem}</a>
Link;
        return $link;
    }

    public static function Sua($id) {

        if (\Module\user\Model\Admin::CheckQuyen() == false) {
            return;
        }
        $link = <<<Link
                <a href="/trungtambaohanh/index/edit/{$id}" class="btn btn-sm btn-success" >Sửa</a>
Link;
        return $link;
    }

    public static function Xoa(
    $id) {
        $link = <<<Link
                <a href="/trungtambaohanh/index/delete/{$id}" class="btn btn-sm btn-danger" >Xóa</a>
Link;
        return $link;
    }

    public static function btnTrungTamBaoHanh(
    $btnThem) {
        $link = <<<Link
                <a href="/trungtambaohanh/index/" class="btn btn-success" >{$btnThem}</a>
Link;
        return $link;
    }

}
?>

