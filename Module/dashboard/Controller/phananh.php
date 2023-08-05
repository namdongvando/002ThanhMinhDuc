<?php

namespace Module\dashboard\Controller;

use Common\Common;
use Model\PhanAnh\PhanAnh as PhanAnhPhanAnh;
use Model\PhanAnh\XuLyPhanAnh;
use Model\ThongBao;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\SanPhamForm;

class phananh extends \ApplicationM
{

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    function __construct()
    {
        new \Controller\backend();
    }

    function index()
    {

        $thongBao = new ThongBao();
        $thongBao->XoaThongBao(md5("PhanAnhMoi"));
        return $this->ViewThemeModlue([], null, "qr");
    }
    function detail()
    {
        $id = $this->getParam(0, null);
        if ($id == null) {
            Common::toUrl("/dashboard/phananh/index/");
        }
        $item = new PhanAnhPhanAnh($id);
        return $this->ViewThemeModlue(["item" => json_decode(json_encode($item), JSON_OBJECT_AS_ARRAY)], null, "qr");
    }
    function post()
    {
        if (isset($_POST[XuLyPhanAnh::$FormName])) {
            $xulyDanhGia = $_POST[XuLyPhanAnh::$FormName];
            $model["Id"] = $xulyDanhGia["Id"];
            $model["TinhTrang"] = strip_tags($xulyDanhGia["TinhTrang"]);
            $Comment = $xulyDanhGia["Comment"];
            $phananh = new PhanAnhPhanAnh($model["Id"]);
            $phananh->Put($model);
            $phananh->SaveLog("Update", $Comment);
        }
    }
}