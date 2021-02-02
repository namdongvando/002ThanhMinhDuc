<?php

namespace Module\rmm\Controller;

use \Module\rmm\Model\Option;

class register extends index implements \Controller\IController {

    static public $UserLayout = "user";
    private $OPtion;

    public function __construct() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        parent::__construct();
    }

    public function index() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $Css = <<<Css
         <link rel="stylesheet" href="/public/admin/plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="/public/admin/plugins/fullcalendar/fullcalendar.print.css" media="print">
Css;
        $fileTime = filemtime("Module/rmm/public/js/Fullcalendar.js");
        $Js = <<<JS
   <script src="/public/admin/plugins/fullcalendar/fullcalendar.min.js"></script>
   <script src="/Module/rmm/public/js/Fullcalendar.js?v={$fileTime}" type="text/javascript"></script>
JS;
        \Application\Html\Css::AddCss($Css);
        \Application\Html\Js::AddJS($Js);
        return $this->ModelView([], "");
    }

    public function create() {

    }

    public function delete() {

    }

    public function detail() {

    }

    public function edit() {

    }

}
