<?php

namespace Module\excell\Model\excell;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelReader {

    function __construct() {

    }

    function CreateFile($full_path = 'public/excell/data.xlsx', $data) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($data as $index => $value) {
            $rows = $index + 1;
            $k = 0;
            foreach ($value as $colName => $value) {
                echo $col = self::getNameFromNumber($k);
                $k++;
                $cell = "{$col}{$rows}";
                $sheet->setCellValue("{$col}{$rows}", $value);
            }
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save($full_path);
        $full_path = "/{$full_path}?v=" . time();
        header("Location: $full_path");
    }

    function import($File) {
        require_once 'PHPExcel.php';
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true); //optional
        $full_path = $File;
        $objPHPExcel = $objReader->load($full_path);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $Model_DanhMuc = new Model_DanhMuc();
        $i = 2;
        foreach ($objWorksheet->getRowIterator() as $row) {
            $DanhMuc['MaDanhMuc'] = $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();
            $DanhMuc['LoaiDanhMuc'] = $objPHPExcel->getActiveSheet()->getCell("B$i")->getValue();
            $DanhMuc['TenDanhMuc'] = $objPHPExcel->getActiveSheet()->getCell("C$i")->getValue();
            $DanhMuc['TenKhongDau'] = $objPHPExcel->getActiveSheet()->getCell("D$i")->getValue();
            $DanhMuc["UrlHinh"] = $objPHPExcel->getActiveSheet()->getCell("E$i")->getValue();
            $DanhMuc["STT"] = $objPHPExcel->getActiveSheet()->getCell("F$i")->getValue();
            $DanhMuc["NoiDung"] = $objPHPExcel->getActiveSheet()->getCell("G$i")->getValue();
            $DanhMuc["ThuocTinh"] = $objPHPExcel->getActiveSheet()->getCell("H$i")->getValue();
            $DanhMuc["CapCha"] = $objPHPExcel->getActiveSheet()->getCell("I$i")->getValue();
            $i++;
            if ($DanhMuc['MaDanhMuc'] != "")
                $DanhMucs[] = $DanhMuc;
        }
        return $DanhMucs;
    }

    public static function ReadFile($FilePath = "", $StructArray) {
        if (is_array($FilePath)) {
            if ($FilePath["error"] == 0) {
                $FilePath = $FilePath["tmp_name"];
            } else {
                return;
            }
        }
        $ColNames = [];
        foreach ($StructArray as $k => $value) {
            $ColNames[] = self::getNameFromNumber($k);
        }
        require_once 'PHPExcel.php';
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');

        $objReader->setReadDataOnly(true); //optional
        $full_path = $FilePath;
        $objPHPExcel = $objReader->load($full_path);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $i = 2;
        foreach ($objWorksheet->getRowIterator() as $row) {
            $item = [];
            foreach ($ColNames as $k => $Colname) {
                $item[$StructArray[$k]] = $objPHPExcel->getActiveSheet()->getCell($Colname . $i)->getValue();
            }
            $DanhMucs[] = $item;
            $i++;
        }
        return $DanhMucs;
    }

    static function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

}

?>