<?php

namespace Module\rmm\Model;

class OptionForm extends \PFBC\Form {

    public
            $Id,
            $Name,
            $Code,
            $Groups,
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
            $this->OrderBy = $dv["OrderBy"];
        }
    }

    private static $Option = ["class" => "form-control"];

    public static function Id($Id = null) {
        return new \PFBC\Element\Hidden("option[Id]", $Id);
    }

    public static function Name($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Tên Loại", "option[Name]", $Option);
    }

    public static function Groups($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Nhóm", "option[Groups]", $Option);
    }

    public static function Code($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        $Option["required"] = true;
        return new \PFBC\Element\Textbox("Mã Loại", "option[Code]", $Option);
    }

    public static function OrderBy($value = null) {
        $Option = self::$Option;
        $Option["value"] = $value;
        return new \PFBC\Element\Textbox("Sắp Xếp", "option[OrderBy]", $Option);
    }

    public static function btnSubmit() {
        return new \PFBC\Element\Button("Lưu", "submit", ["class" => "btn-succes", "Name" => "OnSave"]);
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

}
?>

