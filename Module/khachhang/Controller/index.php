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
            $khtt_POST = $_POST["khachhangthanhtoan"];
            $khtt_POST["MaKhachHang"] = $khachHang["Code"];
            $khachHangThanhToan->InsertSubmit($khtt_POST);
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
            $khachHangThanhToan = new \Module\khachhang\Model\KhachHangThanhToan();
            $KHBYId = \Module\khachhang\Model\KhachHang::GetKhachHangById($kh["Id"]);
            $KHBYId["Code"] = $kh["Code"];
            $KHBYId["Name"] = $kh["Name"];
            $KHBYId["Parents"] = $kh["Parents"];
            $KHBYId["KhuVuc"] = $kh["KhuVuc"];
            $KHBYId["Zalo"] = $kh["Zalo"];
            $KHBYId["LoaiHinhKinhDoanh"] = $kh["LoaiHinhKinhDoanh"];
            $KHBYId["QuanHuyen"] = $kh["QuanHuyen"];
            $KHBYId["TinhThanh"] = $kh["TinhThanh"];
            $KHBYId["LaChuKinhDoanh"] = $kh["LaChuKinhDoanh"];
            $KHBYId["DienThoai"] = $kh["DienThoai"];
            $KHBYId["DiDong"] = $kh["DiDong"];
            $KHBYId["MaSoThue"] = $kh["MaSoThue"];
            $KHBYId["DiaChiGiaoHang"] = $kh["DiaChiGiaoHang"];
            $KHBYId["NhomHangKinhDoanh"] = $kh["NhomHangKinhDoanh"];
            $khachHang->UpdateSubmit($KHBYId);
            $KHTT = \Module\khachhang\Model\KhachHangThanhToan::GetByMaKhachHang($KHBYId["Code"]);
            if ($KHTT) {
                $khtt_POST = $_POST["khachhangthanhtoan"];
                $KHTT["TenCongTy"] = $khtt_POST["TenCongTy"];
                $KHTT["MaSoThue"] = $khtt_POST["MaSoThue"];
                $KHTT["DiaChi"] = $khtt_POST["DiaChi"];
                $KHTT["NganHang"] = $khtt_POST["NganHang"];
                $KHTT["Fax"] = $khtt_POST["Fax"];
                $KHTT["STK"] = $khtt_POST["STK"];
                $KHTT["GhiChu"] = $khtt_POST["GhiChu"];
                $khachHangThanhToan->UpdateSubmit($KHTT);
            } else {
                $khtt_POST = $_POST["khachhangthanhtoan"];
                $KHTT["MaKhachHang"] = $KHBYId["Code"];
                $KHTT["TenCongTy"] = $khtt_POST["TenCongTy"];
                $KHTT["MaSoThue"] = $khtt_POST["MaSoThue"];
                $KHTT["DiaChi"] = $khtt_POST["DiaChi"];
                $KHTT["NganHang"] = $khtt_POST["NganHang"];
                $KHTT["STK"] = $khtt_POST["STK"];
                $KHTT["Fax"] = $khtt_POST["Fax"];
                $KHTT["GhiChu"] = $khtt_POST["GhiChu"];
                $khachHangThanhToan->InsertSubmit($KHTT);
            }
        }
        $id = $this->getParam()[0];
        $_KhachHang = \Module\khachhang\Model\KhachHang::GetKhachHangById($id, true);
        $this->ViewThemeModlue(["KhachHang" => $_KhachHang], self::$UserLayout);
    }

}
