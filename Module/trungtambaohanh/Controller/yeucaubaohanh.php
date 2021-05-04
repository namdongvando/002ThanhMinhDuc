<?php

namespace Module\trungtambaohanh\Controller;

class yeucaubaohanh extends \ApplicationM {

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
        if (isset($_POST["HoanThanh"])) {
//            var_dump($_POST);
            $Ma = $_POST["Code"];
            $ModelyeuCau = new \Module\trungtambaohanh\Model\YeuCauBaoHanh($Ma);
            $yeuCau = $ModelyeuCau->GetByCode($Ma);
            $yeuCau["Status"] = \Module\trungtambaohanh\Model\YeuCauBaoHanh::DaXuLy;
            if ($_FILES["hinhanh"]["error"] == 0) {
                $adapter = new \Core\Adapter();
                $img = "public/baohanh/";
                $imgName = $adapter->upload_image1($_FILES["hinhanh"], $img, $yeuCau["Code"] . time(), false);
                $imgName = "/{$imgName}";
                $yeuCau["HinhAnh"] = $imgName;
            }
            $ModelyeuCau->UpdateSubmit($yeuCau);
        }
        return $this->ViewThemeModlue();
    }

    function detail() {
        return $this->AView();
    }

    function form() {
        return $this->AView();
    }

    function formcomposers() {
        return $this->AView();
    }

    public function SanPham() {

    }

}
