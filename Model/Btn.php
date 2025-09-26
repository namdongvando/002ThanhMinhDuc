<?php
namespace Model;

class Btn extends ElementHTML
{

    function __construct($e)
    {
        parent::__construct($e);
    }

    static function BtnReset($prop = null)
    {
        if ($prop == null) {
            $prop = ["class" => "btn-img"];
        }
        unset($prop["type"]);
        $propStr = self::setPropTable($prop);

        $icon = Icon::Reset;
        return <<<HTML
         <button type="reset" $propStr >
            {$icon}
         </button>
HTML;
    }
    static function BtnSubmit($prop = [])
    {
        unset($prop["type"]);
        $prop["class"] = $prop["class"] ?? "btn-img";
        $propStr = self::setPropTable($prop);
        $icon = $prop["value"] ?? Icon::Save;
        return <<<HTML
         <button type="submit" $propStr >
            {$icon}
         </button>
HTML;
    }
    static function BtnButton($prop = [])
    {
        unset($prop["type"]);
        $prop["class"] = $prop["class"] ?? "btn-img";
        $propStr = self::setPropTable($prop);
        $icon = $prop["value"] ?? Icon::Save;
        unset($prop["value"]);
        return <<<HTML
         <button type="button" $propStr >
            {$icon}
         </button>
HTML;
    }
    static function Btn_OK(
        $content,
        $prop = []
    ) {
        $prop["value"] = $content;
        $prop["class"] = $prop["class"] ?? "btn BTN_OK btn-primary";
        return Btn::BtnButton($prop);
    }

    static function BtnDeleteDBForm($FormName = null)
    {
        return Btn::BtnSubmit([
            "value" => Icon::Remove,
            "name" => FormRender::OnDelete,
            "form" => $FormName ?? "FormDelete",
            "title" => "Xóa các mục đã chọn",
            "class" => "btn-img btn-delete",
        ]);
    }

    static function BtnDeleteForm($FormName = null)
    {
        return Btn::BtnSubmit([
            "value" => Icon::Remove,
            "name" => "Delete",
            "form" => $FormName ?? "FormDelete",
            "title" => "Xóa các mục đã chọn",
            "class" => "btn-img btn-delete",
        ]);
    }
    static function BtnList($link)
    {
        return Btn::Btn(Icon::List , [
            "value" => Icon::Remove,
            "href" => $link,
            "class" => "btn-img ",
        ]);
    }
    static function BtnTrash($link)
    {
        return Btn::Btn(Icon::Trash, [
            "href" => $link,
            "class" => "btn-img",
        ]);
    }
    static function BtnRestoreForm($FormName = null)
    {
        return Btn::BtnSubmit([
            "value" => Icon::Restore,
            "name" => FormRender::OnRestore,
            "form" => $FormName ?? "FormDelete",
            "title" => "Khôi phục các mục đã chọn",
            "class" => "btn-img btn-delete",
        ]);
    }
    static function BtnGoBack($href, $icon = null, $class = null)
    {
        $class = $class ?? "btn btn-primary";
        $icon = $icon ?? Icon::ArrowLeft;
        return Btn::Btn($icon, [
            "href" => $href,
            "class" => $class,
        ]);
    }


    public static function BtnCheckAllTargetTableHeader($label, $target)
    {
        return ElementHTML::tag("div", self::BtnCheckAllTarget($label, $target)->ToString(), [
            "class" => "text-center checkallcontent"
        ]);
    }
    public static function BtnCheckAllTarget($label, $target, $hasChane = 1)
    {

        return FormCommon::Check(
            "",
            "Check_All_Item",
            ["" => $label],
            [
                "type" => "checkbox",
                "class" => "CheckBox_Check_All",
                "haschange" => $hasChane,
                "id" => "BtnCheckAllTarget__" . Common::uuid(),
                "targetitems" => $target
            ]
        );
    }
    public static function BtnCheckAllTargetTable($label, $target, $hasChane = 1)
    {
        return ElementHTML::tag(
            "label",
            FormCommon::TextBox(
                $label,
                "Check_All_Item",
                [
                    "type" => "checkbox",
                    "class" => "CheckBox_Check_All",
                    "haschange" => $hasChane,
                    "id" => "BtnTarget__" . Common::uuid(),
                    "targetitems" => $target
                ]
            )->ToString(),
            ["class" => "text-center"]
        );
    }

    static function CloseModalIcon($title = null, $class = "btn btn-outline-warning btn-default")
    {
        $title = $title ?? Icon::Power_off;
        return <<<HTML
        <button type="button" data-dismiss="modal" class="{$class}" >
                     {$title}
         </button>
HTML;

    }
    static function CloseModal($title = null)
    {
        $title = $title ?? Lang("Đóng");
        return <<<HTML
        <button type="button" data-dismiss="modal" class="btn btn-primary" >
                     {$title}
         </button>
HTML;

    }
    static function CloseModalLink($title = null, $prop = [])
    {
        $title = $title ?? Lang("Đóng");
        $propStr = self::setPropTable($prop);
        return <<<HTML
        <a type="button" {$propStr} href="#" data-dismiss="modal" >
                     {$title}
         </a>
HTML;

    }

}


?>