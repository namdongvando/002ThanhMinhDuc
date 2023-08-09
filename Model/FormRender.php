<?php

namespace Model;

class FormRender
{

    public $element;

    const Required = "required";
    const Readonly = "readonly";
    const Disabled = "disabled";
    function __construct($element)
    {
        $this->element = $element;
    }
    static public function ToolTip($var, $placement = "top")
    {
        return  'data-toggle="tooltip" data-placement="' . $placement . '" title="' . $var . '"';
    }
    static public function ToolTipElement($var, $placement = "top", $icon = "fa-info-circle")
    {
        return  '<i data-toggle="tooltip" data-placement="' . $placement . '" title="' . $var . '" class="fa ' . $icon . '" aria-hidden="true"></i>';
    }
    public function render()
    {
        return $this->element->render();
    }

    public function renderHTML()
    {
        $attrStr =  $this->element->getAttributes();
        $required = "";
        if (strpos($attrStr, FormRender::Required) > 0) {
            $required = "(*)";
        }
        $label = $this->element->getLabel();
        $htmlTemplate = <<<HTML
                <div class="form-group"> 
                    <label >$label <span style="color:red" >$required</span> </label>
HTML;
        echo $htmlTemplate;
        $this->element->render();
        echo "</div>";
    }

    public function renderHTMLIcon($icon)
    {
        $label = $this->element->getLabel();
        $attrStr =  $this->element->getAttributes();
        $required = "";
        if (strpos($attrStr, FormRender::Required) > 0) {
            $required = "(*)";
        }
        $htmlTemplate = <<<HTML
                <div class="form-group">
                <label >$label <span style="color:red" >$required</span> </label>
                
HTML;
        echo $htmlTemplate;
        $this->element->render();
        echo "</div>";
    }
}
