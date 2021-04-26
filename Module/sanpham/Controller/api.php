<?php

namespace Module\sanpham\Controller;

ob_start();

class api extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
        header('Content-Type: application/json');
    }

    public function TokenDeCode($param0) {

    }

    function DanhSachTemSanPham() {
        $pagesIndex = isset($this->getParam()[0]) ? $this->getParam()[0] : 1;
        $pageNumber = isset($this->getParam()[1]) ? $this->getParam()[1] : 20;
        $tong = 0;
        $name = "";
        $TemSanPhams = \Module\sanpham\Model\TemSanPham::GetRowsPT($name, $pagesIndex, $pageNumber, $tong);
        echo \lib\APIs::ResApi($TemSanPhams, $pagesIndex, $pageNumber, $tong);
    }

    function TemSanPham() {
        header("content-type: application/json");
        $number = 100;
        $TemSP = new \Module\sanpham\Model\TemSanPham();
        $tong = 0;
        $TemSP->GetAllPT(0, $number, $tong);
        $dataTong["NumberIndex"] = $number;
        $dataTong["Total"] = $tong;
        $dataTong["TotalPage"] = ceil($tong / $number);
        echo json_encode($dataTong, JSON_UNESCAPED_UNICODE);
    }

    function CreateFileExcell() {

        $timestart = microtime();
        set_time_limit(0);
        $number = 100;
        $pagesIndex = $this->getParam()[0];
        $start = ($pagesIndex - 1) * $number + 1;
        $end = $start + $number - 1;
        $fileName = "public/temsanpham/temsanpham{$pagesIndex}_{$start}_{$end}.xlsx";
        echo microtime();
        if (file_exists($fileName)) {
            exit("da co file");
        }
        $MTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $tong = 0;
        $data = $MTemSanPham->GetAllPT($pagesIndex, $number, $tong);
        echo "data: ";
        echo microtime();

        $this->exporttoFire($fileName, $data);
        echo "ok";
        echo microtime();
        $endTime = microtime();
    }

    function exporttoFire($fileName, $data) {
        foreach ($data as $k => $value) {
            $link = Root_URL . "public/phpqrcode/index.php?data=" . Root_URL . "baohanh/" . $value["Code"];
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

    function dowloadzipfile() {
        $data["url"] = "/" . $this->zipfile("public/temsanpham/");
        echo json_encode($data);
    }

    function zipfile($folder) {
        $rootPath = realpath($folder);
        $zip = new \ZipArchive();
        $fileName = 'public/file.zip';
        $zip->open($fileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($rootPath), \RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return $fileName . "?v=" . time();
    }

    function TemSanPhamPT() {
        ob_start();
        $pagesIndex = isset($_Param[0]) ? $_Param[0] : 1;
        $pageNumber = isset($_Param[1]) ? $_Param[1] : 20;
        $tong = 0;
        $name = isset($_Param[2]) ? $_Param[2] : "";
        $TemSanPhams = \Module\sanpham\Model\TemSanPham::GetRowsPT($name, $pagesIndex, $pageNumber, $tong);
        foreach ($TemSanPhams as $key => $value) {
            $_op = new \Module\sanpham\Model\TemSanPham($value);
            $TemSanPhams[$key]["SanPham"] = $_op->SanPham();
            $TemSanPhams[$key]["Status"] = $_op->Status();
            $TemSanPhams[$key]["NgayBatDau"] = $_op->NgayBatDau();
            $TemSanPhams[$key]["ThangKetThuc"] = $_op->ThangKetThuc();
            $TemSanPhams[$key]["NgayKetThuc"] = $_op->NgayKetThuc();
            $TemSanPhams[$key]["UserId"] = $_op->UserId();
            $TemSanPhams[$key]["CreateDate"] = $_op->CreateDate();
            $TemSanPhams[$key]["ModifyDate"] = $_op->ModifyDate();
        }
        echo \lib\APIs::ResApi($TemSanPhams, $pagesIndex, $pageNumber, ceil($tong / $pageNumber));
        $str = ob_get_clean();
        echo minify_output($str);
    }

}
?>

