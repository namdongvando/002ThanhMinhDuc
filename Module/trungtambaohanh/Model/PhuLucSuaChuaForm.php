<?php

namespace Module\trungtambaohanh\Model;

class PhuLucSuaChuaForm extends \PFBC\Form implements IPhuLucSuaChuaForm {

    const nameForm = "plsc";

    public function __construct($dv = null) {

    }

    private static $Option = ["class" => "form-control"];

    public static function btnThem($btnThem) {
        $link = <<<Link
                <a href="/trungtambaohanh/phulucsuachua/add/" class="btn btn-primary" ><i class="fa fa-plus" ></i> {$btnThem}</a>
Link;
        return $link;
    }

    public static function Sua($id) {
        $link = <<<Link
                <a href="/trungtambaohanh/phulucsuachua/edit/{$id}" class="btn btn-sm btn-success" >Sửa</a>
Link;
        return $link;
    }

    public static function Xoa($id) {
        $link = <<<Link
                <a href="/trungtambaohanh/phulucsuachua/delete/{$id}" class="btn btn-sm btn-danger" >Xóa</a>
Link;
        return $link;
    }

    public static function DonGia($value = null, $title = "") {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function GiaLinhKien($value = null, $title = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Id($value = null) {
        $nameForm = self::nameForm;
        return new \PFBC\Element\Hidden("{$nameForm}[" . __FUNCTION__ . "]", $value);
    }

    public static function LinhKien($value = null, $title = '') {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function btnPhuLucSuaChua($btnThem) {
        $link = <<<Link
                <a href="/trungtambaohanh/phulucsuachua/index/" class="btn btn-primary" >{$btnThem}</a>
Link;
        return $link;
    }

    public static function Name($value = null, $title = "") {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function YeuCau($value = null, $title = "") {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function Code($value = null, $title = "") {
        $Option = self::$Option;
        $Option["value"] = $value;
        $nameForm = self::nameForm;
        return new \PFBC\Element\Textbox($title, "{$nameForm}[" . __FUNCTION__ . "]", $Option);
    }

    public static function LoaiPhuLuc($value = null, $title = "") {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Options = PhuLucSuaChua::LoaiPhuLuc2Option();
        $nameForm = self::nameForm;
        return new \PFBC\Element\Select($title, "{$nameForm}[" . __FUNCTION__ . "]", $Options, $Option);
    }

}

?>