<?php

namespace Module\rmm\Model;

class RoomForm extends \PFBC\Form {

    public
            $Id,
            $Name,
            $Adreess,
            $MaxNumber,
            $Type,
            $Code,
            $Config;
    private $NameGroupsType = "RoomType";

    public function __construct($dv = null) {
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->RoomById($dv);
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Type = $dv["Type"];
            $this->Code = $dv["Code"];
            $this->Adreess = $dv["Adreess"];
            $this->MaxNumber = $dv["MaxNumber"];
            $this->Config = $dv["Config"];
        }
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
        return new \PFBC\Element\Hidden("room[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Tên Phòng", "room[Name]", $Option);
    }

    public static function Type($value = []) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["class"] = "select2 form-control";
        $ModelOption = new Option();
        $dataOptions = $ModelOption->GetAll2Option("RoomType");
        return new \PFBC\Element\Select("Loại Phòng", "room[Type]", $dataOptions, $Option);
    }

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Mã Phòng", "room[Code]", $Option);
    }

    public static function Adreess($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Địa Chỉ", "room[Adreess]", $Option);
    }

    public static function MaxNumber($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Số Người Tối Đa", "room[MaxNumber]", $Option);
    }

    public static function Config($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Cấu Hình Khác", "room[Config]", $Option);
    }

    public static function btnSubmit() {
        return new \PFBC\Element\Button("Thêm Phòng Họp", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function btnSave() {
        return new \PFBC\Element\Button("Lưu", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function btnEdit($options) {
        $link = <<<Link
                <a href="/rmm/index/edit/{$options}" class="btn btn-primary" >Sửa</a>
Link;
        echo $link;
    }

    public static function btnDelete($options) {
        $link = <<<Link
                <a href="/rmm/index/delete/{$options}" data-confirm="Bạn Muốn Xóa Phòng Này?" class="btn xoa btn-danger" >Xóa</a>
Link;
        echo $link;
    }

}
?>

