<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcellService
 *
 * @author MSI
 */

namespace Module\project\Model\Excell;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcellService {

    //put your code here

    public function __construct() {

    }

    function Test($array, $name = null) {
        $Col = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        foreach ($array as $k => $value) {
            $i = 0;
            count($value);
            foreach ($value as $k => $v1) {
                $sheet->setCellValue($Col[$i] . $row, $v1);
                $Col[$i] . $row;
                $i++;
            }
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        if ($name == null) {
            $name = "exportEmail" . time();
        }
        $name = $name . ".xlsx";
        $writer->save('public/' . $name);
        \Application\redirectTo::Url('/public/' . $name);
    }

    function Array2Excell($array, $name = null) {
        $Col = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        foreach ($array as $k => $value) {
            $i = 0;
            count($value);
            foreach ($value as $k => $v1) {
                $sheet->setCellValue($Col[$i] . $row, $v1);
                $Col[$i] . $row;
                $i++;
            }
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        if ($name == null) {
            $name = "exportEmail" . time();
        }
        $name = $name . ".xlsx";
        $writer->save('public/' . $name);
        \Application\redirectTo::Url('/public/' . $name);
    }

}
