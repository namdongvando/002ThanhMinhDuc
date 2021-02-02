<?php

namespace Module\rmm\Model;

class RoomRegisterForm extends \PFBC\Form {

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

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["class"] = "";
        $Option["Id"] = time();
        $Option["labelclass"] = "form-control";
        $Option["value"] = $value;
        $ModelRoom = new Room();
        $dataOptions = $ModelRoom->GetAll2Option("1=1");
        return new \PFBC\Element\Radio("Loại Phòng", "room[Type]", $dataOptions, $Option);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Tên Phòng", "room[Name]", $Option);
    }

    public static function UserId($value = []) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["class"] = "select2 form-control";
        $ModelOption = new Option();
        $dataOptions = $ModelOption->GetAll2Option("RoomType");
        return new \PFBC\Element\Select("Loại Phòng", "room[Type]", $dataOptions, $Option);
    }

    public static function NumberPerson($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Số Người Họp", "room[NumberPerson]", $Option);
    }

    public static function Groups($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Địa Chỉ", "room[Groups]", $Option);
    }

    public static function StarTime($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Số Người Tối Đa", "room[StarTime]", $Option);
    }

    public static function EndTime($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Cấu Hình Khác", "room[EndTime]", $Option);
    }

    public static function btnSubmit($title = "Lưu") {
        return new \PFBC\Element\Button($title, "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function btnSave() {
        return new \PFBC\Element\Button("Lưu", "Submit", ["name" => "IsSubmit", "class" => "btn btn-primary"]);
    }

    public static function btnEdit($options) {
        $link = <<<Link
                <a href="/rmm/register/edit/{$options}" class="btn btn-primary" >Sửa</a>
Link;
        echo $link;
    }

    public static function btnDelete($options) {
        $link = <<<Link
                <a href="/rmm/register/delete/{$options}" data-confirm="Bạn Muốn Xóa Phòng Này?" class="btn xoa btn-danger" >Xóa</a>
Link;
        echo $link;
    }

}
?>

