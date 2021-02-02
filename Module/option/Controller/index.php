<?php

namespace Module\option\Controller;

define("AppDir", "Module/option");
define("AppPath", "/Module/option");

class index extends \ApplicationM implements \Controller\IController {

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    function index() {
//        var_dump("aa");
        return $this->ModelView([], "");
    }

    public function import() {

    }

    public function create() {
        if (isset($_POST["btnsave"])) {
            $option = $_POST["option"];
            $ModelOption = new \Module\option\Model\Option();
            $ModelOption->InsertSubmit($option);
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            exit();
        }
    }

    public function delete() {

    }

    public function detail() {

    }

    public function edit() {
        if (\Common\Form::isPost()) {
            $option = \Common\Form::RequestPost("option", []);
            if ($option) {
                $ModelOption = new \Module\option\Model\Option();
                $ModelOption->UpdateRowTable($option);
            }
        }
        $id = $this->getParam(0);
        $option = new \Module\option\Model\Option($id);
        return $this->ModelView(["option" => $option], "");
    }

    public function groups() {
        $groups = $this->getParam(0);
        $Options = \Module\option\Model\Option::OptionByGroups($groups);
        return $this->ModelView(["Option" => $Options], "");
    }

}
?>

