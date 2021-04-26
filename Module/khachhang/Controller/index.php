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
            $khachHangThanhToan = new \Module\khachhang\Model\KhachHangThanhToan();
            $id = $khachHang->InsertSubmit($kh);
            $khtt_POST = $_POST["khachhangthanhtoan"];
            $khtt_POST["MaKhachHang"] = $kh["Code"];
            $a = $khachHangThanhToan->GetByMaKhachHang($khtt_POST["MaKhachHang"]);
            if ($a == null) {
                $khachHangThanhToan->InsertSubmit($khtt_POST);
            }
            \Common\Common::toUrl("/khachhang/index/edit/" . sha1($id));
        }
        return $this->ViewThemeModlue();
    }

    function controller() {

        $this->ViewThemeModlue();
    }

    function import() {
        try {
            if (true) {
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
                error_reporting(E_ALL);
            }
            $khachHang = new \Module\khachhang\Model\KhachHang();
            if ($_FILES["file"]["error"] == 0) {
                $file = $_FILES["file"];
                $DanhSach = \Module\excell\Model\excell\ExcelReader::ReadFile($file, ["STT", "MaKH", "TenCuaHang", "DiaChi", "MaKH1", "Note", "SDT"]);
                foreach ($DanhSach as $rowuser) {
                    $model["Code"] = $rowuser["MaKH"];
                    $model["Name"] = $rowuser["TenCuaHang"];
                    $model["Parents"] = 0;
                    $model["KhuVuc"] = 0;
                    $model["DiaChi"] = $rowuser["DiaChi"];
                    $model["PhuongXa"] = 0;
                    $model["QuanHuyen"] = 0;
                    $model["TinhThanh"] = 0;
                    $model["LaChuKinhDoanh"] = 0;
                    $model["DienThoai"] = !empty($rowuser["SDT"]) ? $rowuser["SDT"] : "";
                    $model["DiDong"] = !empty($rowuser["SDT"]) ? $rowuser["SDT"] : "";
                    $model["Zalo"] = !empty($rowuser["SDT"]) ? $rowuser["SDT"] : "";
                    $model["MaSoThue"] = "";
                    $model["DiaChiGiaoHang"] = "";
                    $model["NhomHangKinhDoanh"] = "";
                    if ($model["Code"])
                        $khachHang->InsertSubmit($model);
                }
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
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
        $idKachHang = $this->getParam()[0];
        $khachHang = new \Module\khachhang\Model\KhachHang();
        $khachHang->DeleteSubmit($idKachHang, true);
        \Common\Common::toUrl("/khachhang/index/");
    }

    public function detail() {

    }

    public function edit() {
        if (isset($_POST["khachhang"])) {
            $kh = $_POST["khachhang"];
            $khachHang = new \Module\khachhang\Model\KhachHang();
            $khachHangThanhToan = new \Module\khachhang\Model\KhachHangThanhToan();
            $KHBYId = \Module\khachhang\Model\KhachHang::GetKhachHangById($kh["Id"]);

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
