<?php

namespace Module\trungtambaohanh\Controller;

class phulucsuachua extends \ApplicationM implements \Controller\IController, \Controller\IActionImport {

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

    }

    public function delete() {

    }

    public function detail() {

    }

    public function edit() {

    }

    public function import() {
        if (isset($_FILES["fileData"])) {
            $file = $_FILES["fileData"];
            $LoaiPhuLuc = \Module\excell\Model\excell\ExcelReader::ReadFile($file, ["Code", "Name", "DonGia", "LinhKien", "YeuCau", "GiaLinhKien", "LoaiPhuLuc"]);
            $ModelPhuLuc = new \Module\trungtambaohanh\Model\PhuLucSuaChua();
            if ($LoaiPhuLuc) {
                foreach ($LoaiPhuLuc as $phuluc) {
                    if ($phuluc["Code"] != null)
                        $ModelPhuLuc->InsertSubmit($phuluc);
                }
            }
        }
    }

}
