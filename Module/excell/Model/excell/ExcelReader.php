<?php

namespace Module\excell\Model\excell;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelReader
{

    function __construct()
    {
    }

    function CreateFile($full_path = 'public/excell/data.xlsx', $data)
    {
        ini_set("memory_limit", "512M");
        ini_set("max_execution_time", 5000);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($data as $index => $value) {
            $rows = $index + 1;
            $k = 0;
            foreach ($value as $colName => $val) {
                $col = self::getNameFromNumber($k);
                $cell = "{$col}{$rows}";
                if ($colName == "img") {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Paid');
                    $drawing->setDescription('Paid');
                    $drawing->setPath($val);
                    $drawing->setCoordinates($cell);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(70);
                } else {
                    $sheet->setCellValue($cell, $val);
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(20);
                }
                $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getRowDimension($rows)->setRowHeight(340);
                $k++;
            }
            unset($data[$index]);
            ob_clean();
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($full_path);
        $full_path = "/{$full_path}?v=" . time();
        //        header("Location: $full_path");
    }
    function CreateFileExCode($full_path = 'public/excell/data.xlsx', $data)
    {
        ini_set("memory_limit", "512M");
        ini_set("max_execution_time", 50000);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($data as $index => $value) {
            $rows = $index + 1;
            $k = 0;
            foreach ($value as $colName => $val) {
                $col = self::getNameFromNumber($k);
                $cell = "{$col}{$rows}";
                if ($colName == "img") {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Paid');
                    $drawing->setDescription('Paid');
                    $drawing->setPath($val);
                    $drawing->setCoordinates($cell);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(70);
                } else {
                    $sheet->setCellValue($cell, $val);
                    // $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(20);
                }
                // $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                // $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                // $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                // $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                // $spreadsheet->getActiveSheet()->getRowDimension($rows)->setRowHeight(340);
                $k++;
            }
            unset($data[$index]);
            ob_clean();
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($full_path);
        $full_path = "/{$full_path}?v=" . time();
        //        header("Location: $full_path");
    }
    function CreateFileDowload($full_path = 'public/excell/data.xlsx', $data)
    {
        // ini_set("memory_limit", "512M");
        // ini_set("max_execution_time", 5000);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($data as $index => $value) {
            $rows = $index + 1;
            $k = 0;
            foreach ($value as $colName => $val) {
                $col = self::getNameFromNumber($k);
                $cell = "{$col}{$rows}";
                if ($colName == "img") {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Paid');
                    $drawing->setDescription('Paid');
                    $drawing->setPath($val);
                    $drawing->setCoordinates($cell);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(70);
                } else {
                    $sheet->setCellValue($cell, $val);
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(20);
                }
                $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getStyle($rows)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_DISTRIBUTED);
                $spreadsheet->getActiveSheet()->getRowDimension($rows)->setRowHeight(340);
                $k++;
            }
            unset($data[$index]);
            ob_flush();
            flush();
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Description: File Transfer');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=test.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        $fp = fopen('php://output', 'a'); // open the output stream
        fputcsv($fp, $columns); // xlsx format the data format and written to the output stream
        $dataNum = count($arrData);
        $perSize = 1000; // number of each exported
        $pages = ceil($dataNum / $perSize);

        for ($i = 1; $i <= $pages; $i++) {
            foreach ($arrData as $item) {
                fputcsv($fp, $item);
            }
            // Flush the output buffer to the browser
            ob_flush();
            flush(); // must use ob_flush () and flush () to flush the output buffer.
        }
        fclose($fp);
        exit();
    }

    static  public function Export($data, $fileName)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet0 = $spreadsheet->getActiveSheet();
        // Set kiểu chữ
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize('14');
        foreach ($data[0] as $r  => $v) {
            $sheet0->getColumnDimension(self::GetCollums($r))->setAutoSize(true);
        }
        foreach ($data as $row => $colums) {
            $colIndex = 0;
            foreach ($colums as  $value) {
                // echo $colIndex;

                $sheet0->setCellValue(
                    self::GetCellName(
                        $colIndex,
                        $row + 1
                    ),
                    $value
                );
                $colIndex++;
            }
        }
        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($fileName);
        header("Location: /{$fileName}");
    }
    static  public function GetCollums($num)
    {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return self::GetCollums($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
    static  public function GetCellName($col, $row)
    {
        $row = max($row, 1);
        $colName = self::GetCollums($col);
        return "{$colName}{$row}";
    }
    function import($File)
    {
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

    public static function ReadFile($FilePath = "", $StructArray)
    {
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

    static function getNameFromNumber($num)
    {
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
