<?php

namespace Module\project\Controller;

// controller
// tất cả class thừa kế từ class này phải check login
class users extends dashboard implements \Controller\IController {

//    static public $UserLayout = "backend";

    function __construct() {
        parent::__construct();
        parent::CheckCurentProjec();
    }

    function index() {
        if ($this->getParam()[0]) {
//            var_dump(\Module\project\Model\Project::DecodeData($this->getParam()[0]));
            $id = \Module\project\Model\Project::DecodeData($this->getParam()[0])->Id;
            \Module\project\Model\Project::SetCurentProject($id);
            \Application\redirectTo::Url("/project/controller/index/");
        }
        return $this->ModelView([], "");
    }

    public function send() {
        $Facebook = new \Module\project\Model\FacebookService\APITiepThi();
        $Facebook->SendData2Facebook();
    }

    public function create() {
        $ModelController = new \Module\project\Model\Controller();
        if (\Module\project\Model\ControllerForm::onSubmit()) {
            try {
                $proj = $_POST["controller"];
                $_Model["Name"] = $proj["Name"];
                $_Model["PId"] = \Module\project\Model\Project::GetCurentProject(true)->Id;
                $_Model["Lat"] = $proj["Lat"];
                $_Model["Lon"] = $proj["Lon"];
                $_Model["Ip"] = $proj["Ip"];
                $_Model["Username"] = $proj["Username"];
                $_Model["Password"] = $proj["Password"];
                $kt = $ModelController->InsertSubmit($_Model);
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
//            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
        }
    }

    public function delete() {
        $ModelController = new \Module\project\Model\Controller();
        $token = $this->getParam()[0];
        $Datatoken = $ModelController->TokenDecode($token);
        $_Model = $ModelController->DeleteSubmit($Datatoken->Id);
        \Application\redirectTo::Url("/project/controller/");
    }

    public function detail() {

    }

    public function datacontroller() {

        $this->ModelView();
    }

    public function datacontrollers() {


        $this->ModelView();
    }

    function datacontroller2excell() {
        $Excell = new \Module\project\Model\Excell\ExcellService();

        $Project = \Module\project\Model\Project::GetCurentProject(TRUE);
        $Controllers = $Project->GetControllersId();
        $Controllers = implode(",", $Controllers);
        $model_option = new \Module\project\Model\ControllerData();
        $where = "`ControllerId` in ({$Controllers})";
        $Options = $model_option->GetRows($where);
        $Excell->Array2Excell($Options);
    }

    public function edit() {
        $ModelController = new \Module\project\Model\Controller();
        if (\Module\project\Model\ControllerForm::onSubmit()) {
            try {
                $proj = $_POST["controller"];
                $id = $proj["Id"];
                $_Model = $ModelController->GetById($id);
                if ($_Model) {
                    $_Model["Name"] = $proj["Name"];
                    $_Model["PId"] = isset($proj["PId"]) ? $proj["PId"] : $_Model["PId"];
                    $_Model["Lat"] = $proj["Lat"];
                    $_Model["Lon"] = $proj["Lon"];
                    $_Model["Ip"] = $proj["Ip"];
                    $_Model["Username"] = $proj["Username"];
                    $_Model["Password"] = $proj["Password"];
                    $kt = $ModelController->UpdateSubmit($_Model);
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            exit();
        }
        $token = $this->getParam()[0];
        $Datatoken = $ModelController->TokenDecode($token);
        $_Model = $ModelController->GetById($Datatoken->Id);
        $this->ModelView(["project" => $_Model]);
    }

    public function TokenDeCode($param0) {
        $ModelController = new \Module\project\Model\Controller();
        $token = $this->getParam()[0];
        return $Datatoken = $ModelController->TokenDecode($token);
    }

}
