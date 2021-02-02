<?php

namespace Module\sanpham\Controller;

class temsanpham extends \ApplicationM implements \Controller\IController {

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

    public function detailbysanpham() {

        if (\Common\Form::RequestPost("temsanpham", null)) {
            $temSP = \Common\Form::RequestPost("temsanpham", []);
            $khachHanhTieuDung = \Common\Form::RequestPost("khachhangtieudung", []);
            $ModelTemSP = new \Module\sanpham\Model\TemSanPham();
            $ModelKhachHanhTieuDung = new \Module\khachhang\Model\KhachHangTieuDung();
            $temSP["NgayBatDau"] = !empty($temSP["NgayBatDau"]) ? $temSP["NgayBatDau"] : null;
            $temSP["NgayKetThuc"] = !empty($temSP["NgayKetThuc"]) ? $temSP["NgayKetThuc"] : null;
            $temSP["ModifyDate"] = date("Y-m-d H:i:s");
            $ModelTemSP->UpdateRowTable($temSP);
            $ModelKhachHanhTieuDung->UpdateRowTable($khachHanhTieuDung);
        }

        $ModelTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $idSanPham = $this->getParam(0);
        $maKhachHangTieuDung = md5(time() . rand(1, time()));
        $temSanPham = \Module\sanpham\Model\TemSanPham::GetBySanPham($idSanPham);
        // kiểm tra tem sản phẩm
        if ($temSanPham == null) {
            $temSanPham = \Module\sanpham\Model\TemSanPham::TaoTemSanPham($idSanPham);
        }
        if ($temSanPham["KhachHangTieuDung"] == "") {
            $khachHang = \Module\khachhang\Model\KhachHangTieuDung::TaoKhachHang($maKhachHangTieuDung);
            $temSanPham["KhachHangTieuDung"] = $maKhachHangTieuDung;
            $ModelTemSanPham->UpdateRowTable($temSanPham);
        } else {
            $khachHang = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($temSanPham["KhachHangTieuDung"]);
        }
        $tsp = new \Module\sanpham\Model\TemSanPham($temSanPham);
        $kH = new \Module\khachhang\Model\KhachHangTieuDung($khachHang);

        return $this->ViewThemeModlue(["temSanPham" => $tsp, "khachHang" => $kH]);
    }

    public function detail() {

        return $this->ViewThemeModlue();
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

}
