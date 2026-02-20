<?php
namespace Model;

class FormBase
{

    public $formValue;
    public $formName = __CLASS__;
    public $formProp = ["class" => "form-control"];

    function __construct($val = null)
    {
        $this->formValue = $val;
    }
    function GetVal($col)
    {
        return $this->formValue[$col] ?? null;

    }

    function GetProp($colProp = [])
    {
        $_prop = $this->formProp;
        if ($colProp) {
            foreach ($colProp as $key => $value) {
                $_prop[$key] = $value;
            }
        }
        return $_prop;
    }
    function GetName($col)
    {
        $formName = $this->formName;
        return "{$formName}[$col]";
    }
}


?>