<?php

namespace Module\rmm\Controller;

define("AppDir", "Module/rmm");
define("AppPath", "/Module/rmm");

class index extends \ApplicationM implements \Controller\IController {

    static public $UserLayout = "user";

    function __construct() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        new \Controller\backend();
//        new \Model\ConfigTheme();
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

    function roomtype() {

        return $this->ModelView([], "");
    }

    public function create() {
        if (\Application\Request\Post::IsPost()) {

            $Room = new \Module\rmm\Model\Room();
            $Room->Name = \Application\Request\Post::GetPost("Name", "NaN", "room");
            $Room->Code = \Application\Request\Post::GetPost("Code", "rmm1" . time(), "room");
            $Room->Config = \Application\Request\Post::GetPost("Config", "{}", "room");
            $Room->MaxNumber = \Application\Request\Post::GetPost("MaxNumber", 1, "room");
            $Room->Type = \Application\Request\Post::GetPost("Type", "0", "room");
            $Room->Adreess = \Application\Request\Post::GetPost("Adreess", "", "room");

            $id = $Room->InsertSubmit($Room->ToArray());
            \Application\redirectTo::Url("/rmm/index/detail/" . $id);
            exit();
        }
        return $this->ModelView([], "");
    }

    public function delete() {
        $id = $this->getParam()[0];
        $Room = new \Module\rmm\Model\Room();
        $room = $Room->DeleteSubmit($id);
        \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
    }

    public function detail() {
        $id = $this->getParam()[0];
        $Room = new \Module\rmm\Model\Room();
        $room = $Room->GetById($id);
        return $this->ModelView(["Room" => $room], "");
    }

    public function edit() {
        if (\Application\Request\Post::IsPost()) {

            $Room = new \Module\rmm\Model\Room();
            $Room->Id = \Application\Request\Post::GetPost("Id", "0", "room");
            $Room->Name = \Application\Request\Post::GetPost("Name", "NaN", "room");
            $Room->Code = \Application\Request\Post::GetPost("Code", "rmm1" . time(), "room");
            $Room->Config = \Application\Request\Post::GetPost("Config", "{}", "room");
            $Room->MaxNumber = \Application\Request\Post::GetPost("MaxNumber", 1, "room");
            $Room->Type = \Application\Request\Post::GetPost("Type", "0", "room");
            $Room->Adreess = \Application\Request\Post::GetPost("Adreess", "", "room");

            $Room->UpdateSubmit($Room->ToArray());
        }
        $id = $this->getParam()[0];
        $Room = new \Module\rmm\Model\Room();
        $room = $Room->GetById($id);
        return $this->ModelView(["Room" => $room], "");
    }

}
?>

