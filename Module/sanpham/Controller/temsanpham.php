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

        if (isset($_POST["ThemTem"])) {
            $TemSanPham = new \Module\sanpham\Model\TemSanPham();
            for ($i = 0; $i < intval($_POST["SoLuong"]); $i++) {
                $date = date("ymd");
                $string = sha1(rand(1, time())) . microtime();
                $string = substr($string, 0, 10);
                $tem["Code"] = "{$date}{$string}";
                $tem["Name"] = $tem["Code"];
                $tem["Parents"] = 0;
                $tem["IsPrint"] = 0;
                $tem["CreateDate"] = date("Y-m-d H:i:s", time());
                $tem["ModifyDate"] = date("Y-m-d H:i:s", time());
                $TemSanPham->InsertSubmit($tem);
            }
        }
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
        $temSanPham = new \Module\sanpham\Model\TemSanPham();
        $temSanPham->DeleteSubmit($this->getParam()[0], true);
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    public function detailbysanpham() {

        if (\Common\Form::RequestPost("IsSubmit", null)) {
            $temSP = \Common\Form::RequestPost("temsanpham", []);
            $khachHanhTieuDung = \Common\Form::RequestPost("khachhangtieudung", []);
            $sanPhamPost = \Common\Form::RequestPost("sanpham", []);
            $ModelTemSP = new \Module\sanpham\Model\TemSanPham();
            $ModelSP = new \Module\sanpham\Model\SanPham();
            $ModelKhachHanhTieuDung = new \Module\khachhang\Model\KhachHangTieuDung();
            $temSP["NgayBatDau"] = !empty($temSP["NgayBatDau"]) ? date("Y-m-d", strtotime($temSP["NgayBatDau"])) : null;
            $temSP["ThangKetThuc"] = !empty($temSP["ThangKetThuc"]) ? $temSP["ThangKetThuc"] : 0;
            $ngayBd = strtotime($temSP["NgayBatDau"]);
            $soNgay = $temSP["ThangKetThuc"] * 30 * 24 * 3600;
            $a = $ngayBd + $soNgay;
            $temSP["NgayKetThuc"] = date("Y-m-d H:i:s", $a);
            $temSP["ModifyDate"] = date("Y-m-d H:i:s", time());
            $ModelTemSP->UpdateRowTable($temSP);
            $MSP = $ModelSP->GetById($sanPhamPost["Id"]);
//            var_dump($sanPhamPost);
            $MSP["Name"] = $sanPhamPost["Name"];
            $MSP["Mota"] = $sanPhamPost["Mota"];
            $MSP["ChungLoaiSP"] = $sanPhamPost["ChungLoaiSP"];
            $MSP["DanhMuc"] = $sanPhamPost["DanhMuc"];
            $MSP["Code"] = $sanPhamPost["Code"];
            if ($_FILES["HinhAnhSanPham"]["error"] == 0) {
                $adapter = new \Core\Adapter();
                $img = "Module/sanpham/public/images/";
                $imgName = $adapter->upload_image1($_FILES["HinhAnhSanPham"], $img, $sanPhamPost["Code"], false);
                $imgName = "/{$imgName}";
                $sanPhamPost["HinhAnh"] = $imgName;
                $MSP["HinhAnh"] = $sanPhamPost["HinhAnh"];
            }
            unset($sanPhamPost["Code"]);
            $ModelSP->UpdateSubmit($MSP);
//            var_dump($MSP);
//            die();
            $ModelKhachHanhTieuDung->UpdateRowTable($khachHanhTieuDung);
        }
        if (\Common\Form::RequestPost("ThenTemPhu", null)) {

        }
        $ModelTemSanPham = new \Module\sanpham\Model\TemSanPham();
        // mã sản phẩm
        $idSanPham = $this->getParam(0);
        $maKhachHangTieuDung = md5(time() . rand(1, time()));
// mã khách hàng tiêu dung
        $temSanPham = \Module\sanpham\Model\TemSanPham::GetByCode($idSanPham);

        // kiểm tra tem sản phẩm
        $sanPham = new \Module\sanpham\Model\SanPham();
//        var_dump($temSanPham["MaSanPham"]);
        if ($temSanPham["MaSanPham"] == 0) {
            $idSP = $sanPham->TaoSanPham($temSanPham["Code"]);
            $temSanPham["MaSanPham"] = $idSP;
            $ModelTemSanPham->UpdateSubmit($temSanPham);
        }
        $khachHang = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($temSanPham["KhachHangTieuDung"]);
        $tsp = new \Module\sanpham\Model\TemSanPham($temSanPham);

        $kH = new \Module\khachhang\Model\KhachHangTieuDung($khachHang);
        return $this->ViewThemeModlue(["temSanPham" => $tsp, "khachHang" => $kH]);
    }

    public function detail() {
        return $this->ViewThemeModlue();
    }

    public function export() {
        set_time_limit(0);
        $Excell = new \Module\excell\Model\excell\ExcelReader();
        $fileName = "public/temsanpham.xlsx";
        $MTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $data = $MTemSanPham->GetAll();
        $Excell->CreateFile($fileName, $data);
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

    function quanlytem() {

        return $this->ViewThemeModlue();
    }

}
