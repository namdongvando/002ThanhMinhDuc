<?php

namespace Module\sanpham\Controller;

use Exception;
use lib\input;
use Module\sanpham\Model\SanPham;

class temsanpham extends \ApplicationM implements \Controller\IController
{

    static public $UserLayout = "backend";

    function __construct()
    {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    protected function CreateCode($i)
    {
        $string = input::RandomString(6, date("y", time()));
        return $string;
    }

    function index()
    {
        if (isset($_POST["ThemTem"])) {

            $TemSanPham = new \Module\sanpham\Model\TemSanPham();
            for ($i = 0; $i < intval($_POST["SoLuong"]); $i++) {
                $string = $this->CreateCode($i);
                while ($TemSanPham->GetByCode($string)) {
                    $string = $this->CreateCode($i);
                }
                $tem["Code"] = "{$string}";
                $tem["Name"] = $tem["Code"];
                $tem["MaSanPham"] = 0;
                $tem["Parents"] = 0;
                $tem["ThangKetThuc"] = null;
                $tem["IsPrint"] = 0;
                $tem["CreateDate"] = date("Y-m-d H:i:s", time());
                $tem["ModifyDate"] = date("Y-m-d H:i:s", time());
                $TemSanPham->InsertSubmit($tem);
            }
        }
        return $this->ViewThemeModlue();
    }

    public function xoatemchuain()
    {

        $TemSanPham = new \Module\sanpham\Model\TemSanPham();
        $TemSanPham->DeleteNoPrint();
        return;
    }
    public function create()
    {
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

    public function delete()
    {
        $temSanPham = new \Module\sanpham\Model\TemSanPham();
        $temSanPham->DeleteSubmit($this->getParam()[0], true);
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    public function detailbysanpham()
    {

        if (isset($_POST["ChonDanhMucSanPham"])) {
            $Chon = $_POST["Chon"];
            $MaDanhMuc = $Chon["MaDanhMuc"];
            $MaSanPham = $Chon["MaSanPham"];
            $SanPham = new \Module\sanpham\Model\SanPham($MaSanPham);
            $Option = new \Module\option\Model\Option();
            $op = new \Module\option\Model\Option($MaDanhMuc);
            $SanPham->Name = $op->Name;
            $SanPham->Code = $op->Code;
            $SanPham->DanhMuc = $op->Code;
            $SanPham->ChungLoaiSP = $op->Parents()->Code;
            $SanPham->Mota = $op->Note;
            $model = $SanPham->ToArray();
            // var_dump($model);
            $SanPham->UpdateSubmit($model);
        }

        if (\Common\Form::RequestPost("IsSubmit", null)) {
            $temSP = \Common\Form::RequestPost("temsanpham", []);
            $khachHanhTieuDung = \Common\Form::RequestPost("khachhangtieudung", []);
            $sanPhamPost = \Common\Form::RequestPost("sanpham", []);
            $ModelTemSP = new \Module\sanpham\Model\TemSanPham();
            $ModelSP = new \Module\sanpham\Model\SanPham();
            $ModelKhachHanhTieuDung = new \Module\khachhang\Model\KhachHangTieuDung();
            $temSP["NgayBatDau"] = !empty($temSP["NgayBatDau"]) ? date("Y-m-d", strtotime($temSP["NgayBatDau"])) : date("Y-m-d", time());
            $temSP["ThangKetThuc"] = !empty($temSP["ThangKetThuc"]) ? $temSP["ThangKetThuc"] : 0;
            $ngayBd = strtotime($temSP["NgayBatDau"]);
            $soNgay = $this->TinhSoNgay($temSP["ThangKetThuc"]);
            $a = $ngayBd + $soNgay;
            $temSP["NgayKetThuc"] = date("Y-m-d H:i:s", $a);
            $temSP["ModifyDate"] = date("Y-m-d H:i:s", time());
            $MSP = $ModelSP->GetById($sanPhamPost["Id"]);
            //            var_dump($sanPhamPost);
            $MSP["Name"] = $sanPhamPost["Name"];
            if (\Module\user\Model\Admin::CheckQuyen([\Module\user\Model\Admin::Admin, \Module\user\Model\Admin::SuperAdmin])) {
                $MSP["MaDaiLy"] = $sanPhamPost["MaDaiLy"];
                $MSP["TinhTrang"] = $sanPhamPost["TinhTrang"] ?? SanPham::DangODaiLy;
            }
            $MSP["Mota"] = $sanPhamPost["Mota"];
            $MSP["ChungLoaiSP"] = !empty($sanPhamPost["ChungLoaiSP"]) ? $sanPhamPost["ChungLoaiSP"] : $MSP["ChungLoaiSP"];
            $MSP["DanhMuc"] = !empty($sanPhamPost["DanhMuc"]) ? $sanPhamPost["DanhMuc"] : $MSP["DanhMuc"];
            $MSP["Code"] = $sanPhamPost["Code"];
            if (isset($_FILES["HinhAnhSanPham"])) {
                if ($_FILES["HinhAnhSanPham"]["error"] == 0) {
                    $adapter = new \Core\Adapter();
                    $img = "Module/sanpham/public/images/";
                    $imgName = $adapter->upload_image1($_FILES["HinhAnhSanPham"], $img, $sanPhamPost["Code"], false);
                    $imgName = "/{$imgName}";
                    $sanPhamPost["HinhAnh"] = $imgName;
                    $MSP["HinhAnh"] = $sanPhamPost["HinhAnh"];
                }
            }
            unset($sanPhamPost["Code"]);
            $ModelSP->UpdateSubmit($MSP);
            if ($khachHanhTieuDung["Id"] == "") {
                $khachHanhTieuDung["Code"] = "kh" . $khachHanhTieuDung["Phone"] . time();
                $idKHTieuDung = $ModelKhachHanhTieuDung->InsertSubmit($khachHanhTieuDung);
                $temSP["KhachHangTieuDung"] = $khachHanhTieuDung["Code"];
            } else {
                $ModelKhachHanhTieuDung->UpdateRowTable($khachHanhTieuDung);
            }
            $ModelTemSP->UpdateRowTable($temSP);
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

    public function detail()
    {
        return $this->ViewThemeModlue();
    }

    public function export()
    {
        return;
        set_time_limit(0);
        $MTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $tong = 0;
        $data = $MTemSanPham->GetAllPT(1, 500, $tong);
        $page = ceil($tong / 500);
        for ($i = 1; $i <= $page; $i++) {
            $data = $MTemSanPham->GetAllPT($i, 500, $tong);
            $fileName = "public/temsanpham/temsanpham{$i}.xlsx";
            $this->exporttoFire($fileName, $data);
            flush();
        }
        $this->zipfile("public/temsanpham/");
        flush();
        exit();
    }
    function exportCode()
    {
        $MTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $data = $MTemSanPham->GetTempChuaIn();
        $this->exportListCode("public/Code23.xlsx", $data);
        header("Location: /public/Code23.xlsx");
    }
    function zipfile($folder)
    {
        $rootPath = realpath($folder);
        $zip = new \ZipArchive();
        $fileName = 'public/file.zip';
        $zip->open($fileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($rootPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        header("Location: /" . $fileName);
        exit();
    }

    function exportListCode($fileName, $data)
    {
        foreach ($data as $k => $value) {
            // $link = Root_URL . "public/phpqrcode/index.php?data=http://cskhtmd.com/{$value["Code"]}";
            // $imagesQr = "public/QRCode/{$value["Code"]}.png";
            // if (!file_exists($imagesQr)) {
            //     $io = new \lib\io();
            //     $io->writeFile($imagesQr, file_get_contents($link));
            // }
            $data[$k]["Stt"] = $k + 1;
            $data[$k]["Code"] =  $value["Code"];
            $data[$k]["Code"] =  "http://cskhtmd.com/" . $value["Code"] . "/";
            unset($data[$k]["img"]);
            unset($data[$k]["KhachHangTieuDung"]);
            unset($data[$k]["NgayBatDau"]);
            unset($data[$k]["Id"]);
            unset($data[$k]["NgayKetThuc"]);
            unset($data[$k]["ThangKetThuc"]);
            unset($data[$k]["Status"]);
            unset($data[$k]["UserId"]);
            unset($data[$k]["Parents"]);
            unset($data[$k]["CreateDate"]);
            unset($data[$k]["ModifyDate"]);
            unset($data[$k]["IsPrint"]);
            unset($data[$k]["MaSanPham"]);
        }
        $Excell = new \Module\excell\Model\excell\ExcelReader();
        $Excell->CreateFileExCode($fileName, $data);
    }

    function exporttoFire($fileName, $data)
    {
        foreach ($data as $k => $value) {
            $link = Root_URL . "public/phpqrcode/index.php?data=http://cskhtmd.com/{$value["Code"]}";
            $imagesQr = "public/QRCode/{$value["Code"]}.png";
            if (!file_exists($imagesQr)) {
                $io = new \lib\io();
                $io->writeFile($imagesQr, file_get_contents($link));
            }
            $data[$k]["Stt"] = $k + 1;
            $data[$k]["img"] = $imagesQr;
            $data[$k]["Code"] = $value["Code"];
            unset($data[$k]["KhachHangTieuDung"]);
            unset($data[$k]["NgayBatDau"]);
            unset($data[$k]["Id"]);
            unset($data[$k]["NgayKetThuc"]);
            unset($data[$k]["ThangKetThuc"]);
            unset($data[$k]["Status"]);
            unset($data[$k]["UserId"]);
            unset($data[$k]["Parents"]);
            unset($data[$k]["CreateDate"]);
            unset($data[$k]["ModifyDate"]);
            unset($data[$k]["IsPrint"]);
            unset($data[$k]["MaSanPham"]);
        }
        $Excell = new \Module\excell\Model\excell\ExcelReader();
        $Excell->CreateFile($fileName, $data);
    }

    public function edit()
    {
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

    function quanlytem()
    {

        return $this->ViewThemeModlue();
    }

    public function TinhSoNgay($thang)
    {
        $nam = 0;
        if ($thang > 12) {
            $nam = floor($thang / 12);
        }
        if ($nam > 0) {
            $thang = $thang - ($nam * 12);
        }

        return $thang * 30.5 * 24 * 3600 + $nam * 365 * 24 * 3600;
    }
}
