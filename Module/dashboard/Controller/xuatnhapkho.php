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
        $pageIndex = intval($_REQUEST["indexPage"] ?? "1");
        $params["pageSize"] = intval($_REQUEST["pageIndex"] ?? "10");
        $items = $XuatNhapKho->GetItems([], $pageIndex, $params["pageSize"], $total);
        $response = new Response();
        $response->params = $params;
        $response->totalrows = $total;
        $response->number = $params["pageSize"];
        $response->indexPage = $pageIndex;
        $response->totalPage = ceil($total / $params["pageSize"]);
        $response->rows = $items;
        $response->status = Response::OK;
        $response->columns = [
            "Id" => "#",
            "Code" => "Mã Phiếu",
            "Name" => "Tên Phiếu",
            "UserId" => "Nhân Viên Bán Hàng",
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