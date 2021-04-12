<?php

namespace Module\sanpham\Controller;

class taosanpham extends \ApplicationM implements \Controller\IController {

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

        if (\Common\Form::RequestPost("TaoMaSanPham", null)) {
            try {
                $sanpham = \Common\Form::RequestPost("sanpham", []);
                $danhMuc = $sanpham["DanhMuc"];
                $_DanhMuc = new \Module\option\Model\Option($danhMuc);
                $_SanPham = new \Module\sanpham\Model\SanPham();
                $SoLuong = intval(\Common\Form::RequestPost("SoLuong", 10));
                for ($index = 1; $index <= $SoLuong; $index++) {
                    $SanPham["Code"] = \Module\sanpham\Model\SanPham::CreateCode();
                    $SanPham["Name"] = $_DanhMuc->Name;
                    $SanPham["MoTa"] = $_DanhMuc->Note;
                    $SanPham["Gia"] = 0;
                    $SanPham["TinhTrang"] = \Module\sanpham\Model\SanPham::DangOCty;
                    $SanPham["HinhAnh"] = "";
                    $SanPham["DanhMuc"] = $_DanhMuc->Code;
                    $SanPham["ChungLoaiSP"] = $_DanhMuc->Parents;
                    $_SanPham->InsertSubmit($SanPham);
                }
            } catch (\Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }

        return $this->ViewThemeModlue();
    }

    public function create() {
        if (\Common\Form::RequestPost("TaoMaSanPham", null)) {
            try {

                $sanpham = \Common\Form::RequestPost("sanpham", []);
                echo $sanpham["danhmuc"];
                $SoLuong = \Common\Form::RequestPost("SoLuong", 10);


                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function delete() {
        $ModelProject = new \Module\project\Model\Project();
        if (\Module\project\Model\ProjectForm::onSubmit()) {

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
        if (\Common\Form::isPost()) {
            $sanpham = \Common\Form::RequestPost("sanpham", []);
            if ($sanpham) {
                $ModelSanPham = new \Module\sanpham\Model\SanPham();
                $ModelSanPham->UpdateRowTable($sanpham);
            }
        }
        $id = $this->getParam(0);
        $option = new \Module\sanpham\Model\SanPham($id);
        return $this->ViewThemeModlue(["SanPham" => $option], self::$UserLayout);
    }

}
