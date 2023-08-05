<?php

namespace Module\option\Model;

class OptionForm extends \PFBC\Form {

    public
            $Id,
            $Name,
            $Code,
            $Groups,
            $Note,
            $Parents,
            $OrderBy;

    public function __construct($dv = null) {
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->RoomById($dv);
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Code = $dv["Code"];
            $this->Groups = $dv["Groups"];
            $this->Note = $dv["Note"];
            $this->Parents = $dv["Note"];
            $this->OrderBy = $dv["OrderBy"];
        }
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
//        return new \PFBC\Element\Hidden("option[Id]", $Id, []);
        return new \PFBC\Element\Hidden("option[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Tên Option", "option[Name]", $Option);
    }

    public static function Groups($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        $Option["style"] = "width:100%;";

        $options1 = Option::GetAll2OptionsByGroups("SettingService");
        $options = Option::GetGroupsOption();

        $optionstotal = $options1 + $options;
        return new \PFBC\Element\Select("Nhóm", "option[Groups]", $optionstotal, $Option);
    }

    public static function Parents($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        $Option["style"] = "width:100%;";
        $options = Option::GetALL2Options(["Id", "Name"]);
        array_unshift($options, "Là Cấp Cha");
        return new \PFBC\Element\Select("Cấp Cha", "option[Parents]", $options, $Option);
    }

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Giá Trị", "option[Code]", $Option);
    }

    public static function OrderBy($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["type"] = "number";
        return new \PFBC\Element\Textbox("Sắp Xếp", "option[OrderBy]", $Option);
    }

    public static function btnSubmit() {
        return new \PFBC\Element\Button("OK", "submit", ["class" => "btn-succes", "Name" => "OnSave"]);
    }

    public static function btnXoa($options) {
        $link = <<<Link
                <a href="/rmm/roomtype/delete/{$options}" data-confirm="Bạn Muốn Xóa Loại Phòng Này" class="btn xoa btn-danger" >Xóa</a>
Link;
        echo $link;
    }

    public static function btnEdit($options) {
        $link = <<<Link
                <a href="/rmm/roomtype/edit/{$options}" class="btn btn-primary" >Sửa</a>
Link;
        echo $link;
    }

    public static function Note($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textarea("Ghi Chú", "option[Note]", $Option);
    }

    public static function SelectGroupsID($title, $name, $groups, $value = null) {
        $Option = self::$Option;
        $Option["required"] = true;
        $Option["value"] = $value;
        $Option["style"] = "width:100%;";
        $options = Option::GetAll2OptionsByGroupsID($groups);
        return new \PFBC\Element\Select($title, $name, $options, $Option);
    }

    public static function SelectGroups($title, $name, $groups) {
        $Option = self::$Option;
        $Option["required"] = true;
        $Option["style"] = "width:100%;";
        $options = Option::GetAll2OptionsByGroups($groups);
        return new \PFBC\Element\Select($title, $name, $options, $Option);
    }

    public static function Hidden($name, $value) {
        return new \PFBC\Element\Hidden($name, $value);
    }

}
?>

