<?php

namespace Model;

use Application;

class ElementHTML
{
    static public $ELement;

    function __construct($e)
    {
        self::$ELement = $e;
    }

    public static function setPropTable($prop)
    {
        $tbl = "";
        foreach ($prop as $key => $value) {
            $tbl .= $key . ' = "' . $value . '" ';
        }
        return $tbl;
    }

    public static function TextCenter($content)
    {
        return ElementHTML::tag("div", $content, ["class" => "text-center"]);
    }

    public static function BtnMinus($prop)
    {
        $Content = Icon::Delete;
        $prop["class"] = $prop["class"] ?? "btn btn-img";
        $propHtml = self::setPropTable($prop);

        return <<<HTML
<a {$propHtml} >{$Content}</a>        
HTML;
    }
    public static function Btn($Content, $prop)
    {
        $propHtml = self::setPropTable($prop);
        return <<<HTML
<a {$propHtml} >{$Content}</a>        
HTML;
    }
    public static function BtnModal($Content, $prop, $target)
    {
        $propHtml = self::setPropTable($prop);

        return <<<HTML
<button {$propHtml} data-backdrop="static" data-toggle="modal"
        data-target='{$target}'>{$Content}</button>
HTML;
    }
    public static function BtnModalA($Content, $prop, $target)
    {

        if (isset($prop["allow"])) {
            $u = User::CusrentUser();
            if ($u->CheckPermistion($prop["allow"]) == false) {
                return "";
            }
        }

        $propHtml = self::setPropTable($prop);

        return <<<HTML
<a {$propHtml} data-backdrop="static" target="__self" data-toggle="modal"
        href='{$target}'>{$Content}</a>
HTML;
    }
    public static function Img($src, $prop)
    {
        if (!isset($prop["onerror"])) {
            // $prop["onerror"] = "this.src='/public/no-img.jpg'";
        }
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <img src="{$src}" {$propHtml}  >        
HTML;
    }
    public static function ImgLink($src, $link, $propImage = [], $prop = [])
    {
        if (!isset($propImage["onerror"])) {
            $propImage["onerror"] = "this.src='/public/no-img.jpg'";
        }
        $propHtml = self::setPropTable($prop);
        $propImageHtml = self::setPropTable($propImage);
        return <<<HTML
        <a href="{$link}" {$propHtml} >
            <img src="{$src}" {$propImageHtml}   />        
        </a>
HTML;
    }
    public static function P($content, $prop = [])
    {
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <p {$propHtml}  >{$content}</p>        
HTML;
    }

    static function Iframe($src, $prop = [])
    {
        $prop["style"] = $prop["style"] ?? "width:100%";
        $prop["class"] = $prop["class"] ?? "no-border";
        $propHtml = self::setPropTable($prop);

        return <<<HTML
        <iframe src='{$src}' {$propHtml}  ></iframe>        
HTML;

    }

    public static function tagGroup($tagName, $list, $prop = [])
    {
        $listStr = implode("", $list);
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <{$tagName} {$propHtml}  >{$listStr}</{$tagName}>        
HTML;
    }
    public static function tag($tagName, $content, $prop = [])
    {

        // var_dump($prop["allow"]);
        if (isset($prop["allow"])) {
            $u = User::CusrentUser();
            if ($u->CheckPermistion($prop["allow"]) == false) {
                return "";
            }
        }
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <{$tagName} {$propHtml}  >{$content}</{$tagName}>        
HTML;
    }

    function render()
    {
        echo self::$ELement;
    }

    static function BoxTools($BoxTitle, $link)
    {
        ?>
        <div class="box">
            <div class="box-header bg-green2">
                <h3 class="box-title"><?php echo $BoxTitle ?? ""; ?></h3>
                <div class="box-tools">
                    <?php
                    $isShow = Application::$_Action == "trash";
                    if ($isShow == false) {
                        echo Btn::BtnGoBack(
                            $link["Post"] ?? "",
                            Icon::Add,
                            "btn-img"
                        );
                        echo Btn::BtnSubmit();
                        echo Btn::BtnDeleteForm();

                        if ($link["Import"] ?? null) {
                            echo Btn::BtnGoBack(
                                $link["Import"] ?? "",
                                Icon::Import,
                                "btn-img"
                            );
                        }
                        if ($link["Export"] ?? null) {
                            echo Btn::BtnGoBack(
                                $link["Export"] ?? "",
                                Icon::Export,
                                "btn-img"
                            );
                        }
                        echo Btn::BtnGoBack(
                            $link["Reset"] ?? "",
                            Icon::Reset,
                            "btn-img"
                        );
                        echo Btn::BtnGoBack(
                            $link["Trash"] ?? "",
                            Icon::Trash,
                            "btn-img"
                        );
                        echo Btn::BtnGoBack(
                            $link["List"] ?? "",
                            Icon::List ,
                            "btn-img"
                        );
                    } else {
                        echo Btn::BtnRestoreForm();
                        echo Btn::BtnDeleteDBForm();
                        echo Btn::BtnGoBack(
                            $link["List"] ?? "",
                            Icon::List ,
                            "btn-img"
                        );
                        echo Btn::BtnGoBack(
                            $link["List"] ?? "",
                            Icon::List ,
                            "btn-img"
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    static function ImgQrCode($data, $prop = [])
    {
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <img src='/qrcode/index/index/?data={$data}' {$propHtml}  alt='{$data}'  />
HTML;
    }

    static function Dropdow($ListAction)
    {

        $toli = array_map(function ($item) {
            return ElementHTML::tag("li", $item, []);
        }, $ListAction);

        $ListActionHtml =
            implode("", $toli);

        return <<<HTML

        <div class="btn-group">
        <button class="btn btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
            <ul class="dropdown-menu " role="menu">
                {$ListActionHtml} 
            </ul>
        </div>

HTML;

    }
    static function Dropdow_Filter($content, $ListAction)
    {

        $toli = array_map(function ($item) {
            return ElementHTML::tag("div", $item, []);
        }, $ListAction);

        $ListActionHtml =
            implode("", $toli);
        $LangTangDan = Lang("Sắp xếp tăng dần");
        $LangGiamDan = Lang("Sắp xếp giảm dần");
        $orderByColum_Get = Request::Request("ordercol", "");
        $orderByColum_Value = Request::Request("ordervalue", "");
        $checkIconOrderASC = '';
        $checkIconOrderDESC = '';
        $orderByColum = $options["orderByColum"] ?? "";
        if ($orderByColum == $orderByColum_Get) {
            if ($orderByColum_Value == "ASC") {
                $checkIconOrderASC = '<i style="color:green" class="fa pull-right fa-check"  ></i>';
                $checkIconOrderDESC = '';
            }
            if ($orderByColum_Value == "DESC") {
                $checkIconOrderASC = '';
                $checkIconOrderDESC = '<i style="color:green" class="fa color-green pull-right fa-check"  ></i>';
            }
        }
        $LamLai = ElementHTML::tag("button", Lang("Làm Lại"), [
            "type" => "reset",
            "class" => "btn btn-reset btn-primay"
        ]);

        return <<<HTML

        <div class="dropdown d-flex">
            <span style="white-space: nowrap;line-height: 30px;" >{$content}</span>        
            <button style="background: #fff0 !important;"
                class="btn btn-sm dropdown-toggle"  data-toggle="dropdown" role="button"  >
                <i class="fa fa-filter" ></i>                    
            </button> 
            <div class="dropdown-menu " style="padding: 10px" role="menu">
                <div style="padding: 10px 0px" >
                    <button type="button" data-ordername="{$orderByColum}" data-ordervalue="ASC" class="btn btn-defult text-left btn-block"><i class="fa fa-long-arrow-up"></i> 
                        {$LangTangDan} 
                        {$checkIconOrderASC}
                    </button>
                    <button type="button" data-ordername="{$orderByColum}" data-ordervalue="DESC" class="btn btn-defult text-left btn-block">
                        <i class="fa fa-long-arrow-down"></i>
                        {$LangGiamDan} 
                        {$checkIconOrderDESC}
                    </button>
                </div>
                {$ListActionHtml}  
                <div class="text-right" >
                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-default">Đóng</button>
                    <!-- {$LamLai} -->
                    <button type="submit" class="btn btn-success">Đồng Ý</button>
                </div>
            </div>
        </div>
    
        


HTML;

    }



}