<?php

namespace Module\trungtambaohanh\Controller;

use Common\Alert;
use Common\Common;
use Exception;
use Module\trungtambaohanh\Model\FormXuLyYeuCau;
use Module\trungtambaohanh\Model\FormYeuCauBaoHanh;
use Module\trungtambaohanh\Model\XuLyYeuCau;
use Module\trungtambaohanh\Model\YeuCauBaoHanh as ModelYeuCauBaoHanh;
use Module\user\Model\Admin;

class yeucaubaohanh extends \ApplicationM
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

    function index()
    {
        if (isset($_POST["DieuPhoi"])) {
            $PostForm = $_POST[FormYeuCauBaoHanh::nameForm];
            $ModelyeuCau = new \Module\trungtambaohanh\Model\YeuCauBaoHanh($PostForm["Id"]);
            $yeuCau = $ModelyeuCau->GetByCode($ModelyeuCau->Code);
            $yeuCau["IdTrungTamBaoHanh"] = $PostForm["IdTrungTamBaoHanh"];
            $yeuCau["idNhanVien"] = $PostForm["idNhanVien"];
            // var_dump($PostForm);
            // var_dump($yeuCau);
            // die();
            $ModelyeuCau->UpdateSubmitDieuPhoi($yeuCau);
            Common::toUrl();
        }
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

    function LoiBaoHanh()
    {
        if (isset($_POST["LoiBaoHanh"])) {
            $PostForm = $_POST[FormYeuCauBaoHanh::nameForm];
            $ModelyeuCau = new \Module\trungtambaohanh\Model\YeuCauBaoHanh($PostForm["Id"]);
            $yeuCau = $ModelyeuCau->GetByCode($ModelyeuCau->Code);
            $yeuCau["Status"] = ModelYeuCauBaoHanh::DangXuLy;
            $yeuCau["NoiDung"] = $PostForm["NoiDung"];
            $yeuCau["NoiDungKhac"] = $PostForm["NoiDungKhac"];
            $ModelyeuCau->UpdateSubmit($yeuCau);
            new Alert(["success", "Đã cập nhật lỗi bảo hành"]);
            Common::toUrl();
        }
        return $this->ViewThemeModlue();
    }
    function PhuongAnXuLy()
    {
        if (isset($_POST["PhuongAnXuLy"])) {
            $PostForm = $_POST[FormXuLyYeuCau::nameForm];
            $ModelyeuCau = new XuLyYeuCau();
            $yeuCau["UserId"] = Admin::getCurentUser(true)->Id;
            $yeuCau["MaYeuCau"] = $PostForm["MaYeuCau"];
            $yeuCau["Type"] = "PhuongAnXuLy";
            $yeuCau["NoiDung"] = $PostForm["NoiDung"];
            $yeuCau["NoiDungKhac"] = $PostForm["NoiDungKhac"];
            $ModelyeuCau->InsertSubmit($yeuCau);
            new Alert(["success", "Đã cập nhật phương án xử lý"]);
            $ModelyeuCau = new ModelYeuCauBaoHanh($PostForm["MaYeuCau"]);
            $yeuCau = $ModelyeuCau->GetByCode($ModelyeuCau->Code);
            $yeuCau["Status"] = ModelYeuCauBaoHanh::DangXuLy;
            $yeuCau["Name"] = "PhuongAnXuLy";
            $ModelyeuCau->UpdateSubmit($yeuCau);
            $code =  $PostForm["MaYeuCau"];
            Common::toUrl("/trungtambaohanh/yeucaubaohanh/index/{$code}");
        }
        return $this->ViewThemeModlue();
    }
    function KetQuaBaoHanh()
    {
        if (isset($_POST["KetQuaBaoHanh"])) {
            $PostForm = $_POST[FormXuLyYeuCau::nameForm];
            $ModelyeuCau = new XuLyYeuCau();
            $yeuCau["UserId"] = Admin::getCurentUser(true)->Id;
            $yeuCau["MaYeuCau"] = $PostForm["MaYeuCau"];
            $yeuCau["Type"] = "KetQuaBaoHanh";
            $yeuCau["NoiDung"] = $PostForm["NoiDung"];
            $yeuCau["NoiDungKhac"] = $PostForm["NoiDungKhac"];

            $ModelyeuCau->InsertSubmit($yeuCau);
            $code = $PostForm["MaYeuCau"];

            if ($_FILES[FormXuLyYeuCau::nameForm]) {
                // var_dump($_FILES[FormXuLyYeuCau::nameForm]);
                $adapter = new \Core\Adapter();
                $yeuCauCode = $code;
                $img = "public/baohanh/{$yeuCauCode}/";
                $imgName = $adapter->upload_multi_image(
                    $_FILES[FormXuLyYeuCau::nameForm],
                    $img,
                    $code . time(),
                    true
                );
            }
            new Alert(["success", "Đã cập nhật Kết quả bảo hành"]);
            Common::toUrl("/trungtambaohanh/yeucaubaohanh/index/{$code}/");
        }
        return $this->ViewThemeModlue();
    }



    function detail()
    {
        return $this->AView();
    }

    function form()
    {
        return $this->AView();
    }

    function formcomposers()
    {
        return $this->AView();
    }

    public function SanPham()
    {

    }

    function kiemtratem()
    {
        return $this->ViewThemeModlue();
    }
    function scan()
    {
        return $this->ViewThemeModlue();
    }

    function XacNhanKQ()
    {

        $code = $this->getParam(0);
        $yeuCauBaoHanh = new ModelYeuCauBaoHanh($code);
        $yeuCauBaoHanh->Status = ModelYeuCauBaoHanh::DaXuLy;

        $yeuCauBaoHanh->UpdateSubmit($yeuCauBaoHanh->ToArray());
        Common::toUrl();
    }

}