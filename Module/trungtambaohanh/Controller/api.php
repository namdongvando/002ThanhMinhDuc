<?php

namespace Module\trungtambaohanh\Controller;

class api extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
        header('Content-Type: application/json');
    }

    public function TokenDeCode($param0) {

    }

    function GetYeuCauBaoHanhByCode() {
        $code = $this->getParam()[0];
        $a = \Module\trungtambaohanh\Model\YeuCauBaoHanh::GetByCode($code);
        $yeuCau = new \Module\trungtambaohanh\Model\YeuCauBaoHanh($a);

        $a["ThongTinKhachHang"] = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($a["KhachHangTieuDung"]);
//        var_dump($yeuCau->TemSanPham());
        $a["ThongTinSanPham"] = $yeuCau->TemSanPham()->SanPham()->ToArray();
//        $sanPham = new \Module\sanpham\Model\SanPham($a["ThongTinSanPham"]);
        $a["TemSanPham"] = $yeuCau->TemSanPham();
        $a["NoiDungBaoHanh"] = $yeuCau->NoiDungBaoHanh()->Name;
        $api = new \lib\APIs();
        $api->ArrayToApi($a);
    }

    function GetStatusYeuCauBaoHanh() {
        $a = \Module\trungtambaohanh\Model\YeuCauBaoHanh::ListStatusToOption();
        $api = new \lib\APIs();
        $api->ArrayToApi($a);
//        \lib\APIs::Json_encode($a);
    }

    function ycbhUpdate() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, JSON_OBJECT_AS_ARRAY);
        $code = $request["Code"];
        $status["Status"] = $request["Status"];
        $status["IdTrungTamBaoHanh"] = $request["IdTrungTamBaoHanh"];
        $status["idNhanVien"] = $request["idNhanVien"];
        $YeuCau = new \Module\trungtambaohanh\Model\YeuCauBaoHanh();

        $YeuCau->UpdateStatus($code, $status);
        echo json_encode($status);
    }

    function getTTBH() {
        $TrungTBH = \Module\trungtambaohanh\Model\TrungTamBaoHanh::TrungTamBaoHanhs();
        $api = new \lib\APIs();
        $api->ArrayToApi($TrungTBH);
    }

    function thongtinkhachhang() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, JSON_OBJECT_AS_ARRAY);
        $_POST = $request;
        $khachHang = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($_POST["Code"]);
        $khachHang["Name"] = $_POST["Name"];
        $khachHang["KhuVuc"] = $_POST["KhuVuc"];
        $khachHang["Phone"] = $_POST["Phone"];
        $khachHang["CMNN"] = $_POST["CMNN"];
        $khachHang["DiaChi"] = $_POST["DiaChi"];
        \Module\khachhang\Model\KhachHangTieuDung::Update($khachHang);
    }

    function NhanVienBaoHang() {
        $admin = new \Module\user\Model\Admin();
        $user = $admin->GetUserByGroups(\Module\user\Model\Admin::NVKT);
        $api = new \lib\APIs();
        foreach ($user as $k => $value) {
            $a["Id"] = $value["Id"];
            $a["Name"] = $value["Name"];
            $user[$k] = $a;
        }
        echo $api->ArrayToStringJson($user);
    }

}
?>

