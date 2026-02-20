<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Description of FormCommon
 *
 * @author MSI
 */

use Exception;
use PFBC\Element;
use Model\FormRender;
use Module\quanlysanpham\Model\DanhMuc;
use PFBC\Element\Button;
use PFBC\Element\Checkbox;
use PFBC\Element\Hidden;
use PFBC\Element\Textbox;
use PFBC\Form;

class FormCommon1
{

    static $ElementsName;
    static $_ValueCommon;

    public static function SetName($name)
    {
        return self::$ElementsName . "[" . $name . "]";
    }

    public static function SetInputValue($val)
    {

        return ["value" => $val];
    }

    
    
    public static function Action_Post($actionName)
    {
        if (Request::Post($actionName, null)) {
            return Request::Post("check", []);
        }
        return null;
    }
    

    static function ArrayToPropertive($prop)
    {
        $str = "";
        foreach ($prop as $key => $value) {
            $str .= " {$key}='{$value}' ";
        }
        return $str;
    }
    static function ChonNgay($value, $funcname = "SetNgay")
    {
        echo <<<HTML
         <div class="form-group">
            <label>Chọn ngày:</label>
            <div class="input-group" style="width: 100%">
                <button type="button"
                    class="daterange-btn btn-block text-left btn btn-primary"
                    id="daterange-btn" data-funcname='{$funcname}'>
                    <i class="fa fa-calendar"></i>
                    <span>{$value}</span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div>
HTML;
    }



    static function Check($label, $name, $options, $properties)
    {
        return new FormRender(new Element\Checkbox($label, $name, $options, $properties));
    }
    
    static function Select($label, $name, $options, $properties)
    {
        return new FormRender(new Element\Select($label, $name, $options, $properties));
    }
    static function Radio($label, $name, $options, $properties)
    {
        return new FormRender(new Element\Radio($label, $name, $options, $properties));
    }
    static function BtnChonHinh($idTarget, $idImages)
    {
        return new FormRender(new Button("Chon hình", "button", [
            "onclick" => "BrowseServer('{$idTarget}', '{$idImages}')",
            "class" => "btn btn-primary"
        ]));
    }
    static function HTMLTAG($tagName, $prop, $content)
    {
        $propStr = self::ArrayToPropertive($prop);
        return "<{$tagName} {$propStr}>{$content}</{$tagName}>";

    }
    static function BtnBrowseServer($idTarget, $idImages, $title, $prop = [])
    {
        return ElementHTML::tag(
            "button",
            $title,
            [
                "onclick" => "BrowseServer('{$idTarget}', '{$idImages}')",
            ] + $prop
        );
    }



    static function BtnChonFile($idTarget, $idImages)
    {
        return new FormRender(new Button("+", "button", [
            "onclick" => "BrowseServer('{$idTarget}', '{$idImages}')",
            "class" => "btn btn-primary"
        ]));
    }
    static function BtnChonFileIcon($idTarget, $idImages)
    {
        return FormCommon1::HTMLTAG("buttom", [
            "onclick" => "BrowseServer('{$idTarget}', '{$idImages}')",
            "type" => "button",
            "class" => "btn btn-primary"
        ], Icon::Edit);
    }
    static function YesNo($label, $name, $properties)
    {
        $properties["type"] = "checkbox";
        $properties["Id"] = "yesNo";
        $properties["class"] = "checkbox";
        return new FormRender(new Element\Checkbox($label, $name, ["Co" => ""], $properties));
    } 
    public static function Textarea($label, $name, $properties)
    {
        return new FormRender(new Element\Textarea($label, $name, $properties));
    }
    public static function Button($label, $type, $properties)
    {
        return new FormRender(new Button($label, $type, $properties));
    }
    public static function Link($label, $properties)
    {
        $class = $properties["class"] ?? "";
        $href = $properties["href"] ?? "";
        return <<<HTML
            <a class="{$class}" href="{$href}"  >{$label}</a>
HTML;
    }

    public static function TextBox($label, $name, $properties)
    {
        return new FormRender(new Element\Textbox($label, $name, $properties));
    }

    public static function Submit($label, $properties)
    {
        return new FormRender(new Element\Button($label, "submit", $properties));
    }
    public static function Hidden($name, $value, $properties = [])
    {
        return new FormRender(new Element\Hidden($name, $value, $properties));
    }
    public static function Editor($label, $name, $properties)
    {
        $properties["id"] = $properties["id"] ?? __FUNCTION__;
        $properties["class"] = "editorContent";
        return new FormRender(new Element\Textarea($label, $name, $properties));
    }



    static function Number($label, $targetValue, $proo)
    {
        $proo["type"] = "text";
        $proo["class"] = $proo["class"] ?? "";
        $proo["data-targetvalue"] = $targetValue;
        $proo["class"] .= " ";
        // $proo["class"] .= " viewnumber";
        return (new FormRender(new Textbox($label, "", $proo)));
    }
 

     static function DropMaHangHoa($content = null, $idTarget = "DropMaHangHoa")
    {


        return <<<HTML
    <div class="btn-group btn-timkiem">
        <a style="color:#000" type="button" class="mydropdown-toggle"  
        data-target="#{$idTarget}" 
         >
         {$content} <i class="fa fa-filter" ></i>
        </a>
        <div style="width: 250px;padding: 5px;" id="{$idTarget}" class="dropdown-menu-left dropdown-menu dropdown-left">
            <div class="d-flex form-group" style="margin: 0px" >
                <input type="text" id="DropMaHangHoaID" class="form-control" placeholder="Mã hàng hoá">
                <button type="button" data-target="#DropMaHangHoaID" class="btn btn-change-input btn-primary" >
                    <i class="fa fa-search"  ></i>
                </button>
                <button style="color:#000" type="button" class="btn btn-outline-warning mydropdown-toggle"  
                    data-target="#{$idTarget}" 
                    >
                   <i class="fa fa-power-off" ></i>
                </button>
            </div>
             
        </div>
    </div>

HTML;
    }
    static function QuyCanhHangHoa($content = null, $idTarget = "DropMaHangHoa")
    {
        return <<<HTML
    <div class="btn-group btn-timkiem">
        <a style="color:#000" type="button" class="mydropdown-toggle"  
        data-target="#{$idTarget}" 
         >
         {$content} <i class="fa fa-filter" ></i>
        </a>
        <div style="width: 250px;padding: 5px;" id="{$idTarget}" class="dropdown-menu-left dropdown-menu dropdown-left">
            <div class="d-flex form-group" style="margin: 0px" >
                <input type="text" id="DropMaHangHoaID" class="form-control" placeholder="Mã hàng hoá">
                <button type="button" data-target="#DropMaHangHoaID" class="btn btn-change-input btn-primary" >
                    <i class="fa fa-search"  ></i>
                </button>
                <button style="color:#000" type="button" class="btn btn-outline-warning mydropdown-toggle"  
                    data-target="#{$idTarget}" 
                    >
                   <i class="fa fa-power-off" ></i>
                </button>
            </div>
             
        </div>
    </div>

HTML;
    }
}