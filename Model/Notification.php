<?php
namespace Model;

class Notification
{

    public $type;
    public $content;
    static public $Content = [];

    function __construct($content = null)
    {
        $this->type = $content["type"] ?? null;
        $this->content = $content["content"] ?? null;
    }

    function SetContent($content)
    {
        $_SESSION[__CLASS__] = $content;
    }
    function GetContent()
    {
        $content = $_SESSION[__CLASS__] ?? null;
        unset($_SESSION[__CLASS__]);
        return new Notification($content);
    }

}


?>