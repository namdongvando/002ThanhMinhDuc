<?php

namespace Module\khachhang\Controller;

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

    function add() {
//        var_dump();
        if (isset($_POST["khachhang"])) {
            $kh = $_POST["khachhang"];
            $khachHang = new \Module\khachhang\Model\KhachHang();
            $khachHang->InsertSubmit($kh);
        }
        return $this->ViewThemeModlue();
    }

    function controller() {

        $this->ViewThemeModlue();
    }

    public function create() {
        if (\Module\project\Model\ProjectForm::onSubmit()) {
            try {
                $project = $_POST["project"];
                $pr = new \Module\project\Model\Project();
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
        if (isset($_POST["khachhang"])) {
            $kh = $_POST["khachhang"];
            $khachHang = new \Module\khachhang\Model\KhachHang();
            $KHBYId = \Module\khachhang\Model\KhachHang::GetKhachHangById($kh["Id"]);
            $khachHang->UpdateSubmit($kh);
        }
        $id = $this->getParam()[0];
        $_KhachHang = \Module\khachhang\Model\KhachHang::GetKhachHangById($id);
        $this->ViewThemeModlue(["KhachHang" => $_KhachHang], self::$UserLayout);
    }

}
