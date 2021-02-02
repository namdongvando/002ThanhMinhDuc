<?php

namespace Module\trungtambaohanh\Controller;

class index extends \ApplicationM implements \Controller\IController {

    static public $UserLayout = "backend";

    function __construct() {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    function index() {

        return $this->ViewThemeModlue();
    }

    function controller() {

        $this->ViewThemeModlue();
    }

    public function create() {
        if (\Module\project\Model\ProjectForm::onSubmit()) {
            try {
                $project = $_POST[\Module\trungtambaohanh\Model\TrungTamBaoHanhForm::nameForm];
                $pr = new \Module\trungtambaohanh\Model\TrungTamBaoHanh();
                $pr->InsertSubmit($project);
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function delete() {
        $ModelProject = new \Module\project\Model\Project();
        if (\Module\project\Model\ProjectForm::onSubmit()) {
            try {
                $Password = $_POST["password"];
                $user = \Module\user\Model\Admin::getCurentUser(true);
                if (!$user->CheckPassword($Password)) {
                    throw new \Exception("Mật Khẩu Không Đúng.");
                }
                $projectData = $this->getParam()[0];
                $projectObjData = \Module\project\Model\Project::DecodeData($projectData);
                $ModelProject->DeleteProject($projectObjData->Id);
            } catch (\Exception $ex) {
                \Common\Alert::setAlert("danger", $ex->getMessage());
            }
            \Application\redirectTo::Url("/project/index/");
            exit();
        }
        $DataId = \Module\project\Model\Project::DecodeData($this->getParam()[0]);
        $id = $DataId->Id;
        \Module\project\Model\Project::SetEditProject($id);

        $_Model = $ModelProject->GetById($id);
        $this->ViewThemeModlue(["project" => $_Model], self::$UserLayout);
    }

    public function detail() {

    }

    public function edit() {
        $ModelProject = new \Module\project\Model\Project();
        if (\Module\project\Model\ProjectForm::onSubmit()) {
            try {
                $project = $_POST[\Module\trungtambaohanh\Model\TrungTamBaoHanhForm::nameForm];
                $pr = new \Module\trungtambaohanh\Model\TrungTamBaoHanh();

                $pr->UpdateSubmit($project);
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            exit();
        }
        $id = $this->getParam(0);
        $ttbh = new \Module\trungtambaohanh\Model\TrungTamBaoHanh($id);
        $this->ViewThemeModlue(["TrungTamBaoHanh" => $ttbh], self::$UserLayout);
    }

}
