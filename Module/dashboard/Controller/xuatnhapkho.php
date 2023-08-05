<?php

namespace Module\dashboard\Controller;

use Common\Common;
use Datatable\Response;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\TemSanPham;
use Module\sanpham\Model\XuatNhapKho\PhieuXuatNhap;
use Module\user\Model\Admin;

class xuatnhapkho extends \ApplicationM
{

    const AppDir = "Module/xuatnhapkho";
    const AppPath = "/Module/xuatnhapkho";

    static public $UserLayout = "user";

    function __construct()
    {
        new \Controller\backend();
    }


    function index()
    {
        $XuatNhapKho = new PhieuXuatNhap();
        $total = 0;
        $items = $XuatNhapKho->GetItems([], 1, 10, $total);
        $response = new Response();
        $response->params = ["number" => 1, "keyword" => $_GET["keyword"] ?? ""];
        $response->totalrows = 10;
        $response->number = 1;
        $response->indexPage = 1;
        $response->rows = $items;
        $response->status = Response::OK;
        $response->columns = [
            "Id" => "Id",
            "Code" => "Mã Phiếu",
            "Name" => "Tên Phiếu",
            "UserId" => "Nhân Viên",
            "KhacHang" => "Khách hàng",
            "Type" => "Loại Phiếu",
            "CreateRecorde" => "Ngày Tạo",
            "UpdateRecorde" => "Ngày sửa",
            "Actions" => "Thao tác",
        ];
        $data = $response->ToRow();

        return $this->ViewThemeModlue(["response" => $data], null);
    }
    function detail()
    {

        $code = $this->getParam()[0];
        return $this->ViewThemeModlue(["code" => $code], null);
    }

}
?>