<?php

use Common\Common;
use Model\FormTieuTriDanhGia;
use Model\PhanAnh\PhanAnhChiTiet;
use Module\sanpham\Model\YeuCauKichHoat;
use Module\trungtambaohanh\Model\YeuCauBaoHanh;
use Module\sanpham\Model\TemSanPham;
use Model\PhanAnh\PhanAnh;
use Model\PhanAnh\PhanAnhLog;

class Controller_index extends Application
{

    public $param;
    public $ViewTheme;
    public $Pages;
    public $News;

    function __construct()
    {
        Model_ViewTheme::set_viewthene("thanhminhduc");
    }

    function index()
    {
        return $this->ViewTheme([], null, "tmd");
    }

    function cam()
    {
    }

    function index1()
    {
        // danh sách table
        $a = Common\CoreCodePhp\ModelDataSytem\ModelTable::getTableName();
        // tao table
        Common\CoreCodePhp\ModelDataSytem\ModelTable::createFolder();
        foreach ($a as $key => $value) {
            Common\CoreCodePhp\ModelDataSytem\ModelTable::createFiles($value);
        }
    }

    function index2()
    {
        $data = array(
            "Phone" => "0901337411",
            "Lat" => "10.752558115898141",
            "Lng" => "106.64901473409847"
        );
        $data_string = json_encode($data);

        $curl = curl_init('https://api.vkhealth.vn/api/SOSCall/UpdateDoctorLocation');

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
                'Accept: application/json'
            )
        );

        $result = curl_exec($curl);
        curl_close($curl);
    }

    function loi404()
    {
        echo "404";
    }

    function indexdemo()
    {
        Model_Seo::$Title = "{Title}";
        Model_Seo::$des = "{Des}";
        Model_Seo::$key = "{Keyword}";
        Model_Seo::$img = "[imagesDefault]";

        $this->ViewTheme("  ", Model_ViewTheme::get_viewthene(), "homedemo");
    }



    function yeucaukichhoat()
    {
        $yeucaubaohanh = $_POST["yecaubaphanh"];


        $yeucaubaohanh["HoTen"] = Common::CheckInput($yeucaubaohanh["HoTen"]);
        $yeucaubaohanh["SDT"] = Common::CheckInput($yeucaubaohanh["SDT"]);
        $yeucaubaohanh["TinhThanh"] = Common::CheckInput($yeucaubaohanh["TinhThanh"]);
        $yeucaubaohanh["QuanHuyen"] = Common::CheckInput($yeucaubaohanh["QuanHuyen"]);
        $yeucaubaohanh["DiaChi"] = Common::CheckInput($yeucaubaohanh["DiaChi"]);
        $yeucaubaohanh["MaTem"] = Common::CheckInput($yeucaubaohanh["MaTem"]);
        $yeucaubaohanh["TinhTrang"] = YeuCauKichHoat::MoiTao;
        $yeucaubaohanh["RecCreateDate"] = date("Y-m-d H:i:s", time());
        $yeucaubaohanh["RecUpdateDate"] = date("Y-m-d H:i:s", time());
        $yeucaubaohanh["Code"] =  $yeucaubaohanh["MaTem"];
        $YeuCauKichHoat = new YeuCauKichHoat($yeucaubaohanh["Code"]);

        if ($YeuCauKichHoat->Code == null) {
            $YeuCauKichHoat->InsertSubmit($yeucaubaohanh);
        } else {
            $yeucaubaohanh["Id"] = $YeuCauKichHoat->Id;
            unset($yeucaubaohanh["TinhTrang"]);
            $YeuCauKichHoat->UpdateSubmit($yeucaubaohanh);
        }
        $temsp = new TemSanPham($yeucaubaohanh["MaTem"]);
        if ($temsp->Status == TemSanPham::DeActive) {
            $model["Id"] = $temsp->Id;
            $model["Status"] = TemSanPham::YeuCauKichHoat;
            $temsp->UpdateSubmit($model);
        }
        echo json_encode($yeucaubaohanh);
    }
    function baohanh()
    {
        $alert = null;

        if (isset($_POST[Module\trungtambaohanh\Model\YeuCauBaoHanhForm::nameForm])) {
            $ModelYeuCau = $_POST[Module\trungtambaohanh\Model\YeuCauBaoHanhForm::nameForm];
            $MYeuCau = new Module\trungtambaohanh\Model\YeuCauBaoHanh();
            $ModelYeuCau["Code"] = md5(time() . rand(0, time()));
            $ModelYeuCau["KhachHangTieuDung"] = $ModelYeuCau["KhachHangTieuDung"];
            $ModelYeuCau["Status"] = Module\trungtambaohanh\Model\YeuCauBaoHanh::MoiTao;
            $ModelYeuCau["Name"] = \Module\option\Model\SuCoMacPhai::SuCoMacPhaiByCode($ModelYeuCau["NoiDung"])["Name"];
            $ModelYeuCau["idNhanVien"] = 0;
            $ModelYeuCau["HinhAnh"] = "";
            $ModelYeuCau["TinhThanh"] = $ModelYeuCau["TinhThanh"];
            $ModelYeuCau["QuanHuyen"] = $ModelYeuCau["QuanHuyen"];
            $ModelYeuCau["DiaChi"] = \Module\option\Model\SuCoMacPhai::SuCoMacPhaiByCode($ModelYeuCau["NoiDung"])["Name"];
            $MYeuCau->InsertSubmit($ModelYeuCau);
            $alert["content"] = "Gửi yêu cầu thành công";
            $alert["type"] = "success";
        }
        $kt = $this->LuuPhanAnh();
        if ($kt) {
            $alert = $kt;
        }
        $ModelTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $idSanPham = $this->getParam()[0];
        $temSanPham = \Module\sanpham\Model\TemSanPham::GetByCode($idSanPham);
        $SanPham = Module\sanpham\Model\SanPham::GetItemByCode($idSanPham);
        if ($temSanPham["Status"] != TemSanPham::Active) {
            $temSanPham["KhachHangTieuDung"] = null;
        }
        $khachHang = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($temSanPham["KhachHangTieuDung"]);
        $tsp = new \Module\sanpham\Model\TemSanPham($temSanPham);
        $kH = new \Module\khachhang\Model\KhachHangTieuDung($khachHang);
        return $this->ViewTheme([
            "alert" => $alert,
            "temSanPham" => $tsp,
            "khachHang" => $kH,
            "sanPham" => $SanPham
        ], null, "");
    }

    public function LuuPhanAnh()
    {
        if (isset($_POST[FormTieuTriDanhGia::$FormName])) {
            if (is_dir("public/phananh/") == false) {
                mkdir("public/phananh/", 0777);
            }
            $ModelPhanAnh = new PhanAnh();
            $FormDanhGia = $_POST[FormTieuTriDanhGia::$FormName];
            if (isset($_FILES["File"])) {
                if ($_FILES["File"]["error"] == 0) {
                    $adapter = new \Core\Adapter();
                    $img = "public/phananh/";
                    $imgName = $adapter->upload_image1($_FILES["File"], $img, date("y-m-d-", time()), false);
                    $imgName = "/{$imgName}";
                    $model["HinhAnh"] = $imgName;
                }
            }

            $tieuTri =  $FormDanhGia["TieuTri"] ?? [];
            $comment = trim($FormDanhGia["Comment"]);
            $comment = htmlspecialchars($comment);
            $model["Code"] = $ModelPhanAnh->CreateCode();
            $model["Name"]  = "";
            $model["Content"] = strip_tags($comment);
            $model["MaTem"] = strip_tags($FormDanhGia["MaTem"]);
            $model["TinhTrang"] = "MoiTao";
            $model["UpdateRecord"] = date("Y-m-d H:i:s", time());
            $model["CreateRecord"] = date("Y-m-d H:i:s", time());
            $phanAnhLog["PhanAnh"] = $model;
            $ModelPhanAnh->Post($model);
            $phanAnhLog["PhanAnhChiTiet"] = [];
            if ($tieuTri) {
                $itemTieuTri = [];
                foreach ($tieuTri as $key => $value) {
                    $item = [];
                    $item["MaPhanAnh"] = $model["Code"];
                    $item["TieuTri"] = $key;
                    $item["KetQua"] = $value;
                    $item["GhiChu"] = "";
                    $item["CreateRecord"] = date("Y-m-d H:i:s", time());
                    $item["UpdateRecord"] = date("Y-m-d H:i:s", time());
                    $itemTieuTri[] = $item;
                }
                $phanAnhChiTiet = new PhanAnhChiTiet();
                $phanAnhLog["PhanAnhChiTiet"] = $itemTieuTri;
                $phanAnhChiTiet->PostItems($itemTieuTri);
            }
            $modelphanAnhLog = new PhanAnhLog();
            $paLog["Content"] = json_encode($phanAnhLog);
            $paLog["Type"] = "Insert";
            $paLog["IdPhanAnh"] = $model["Code"];
            $paLog["UpdateRecord"] = date("Y-m-d H:i:s", time());
            $paLog["CreateRecord"] = date("Y-m-d H:i:s", time());
            $modelphanAnhLog->Post($paLog);
            $alert["content"] = "Gửi đánh giá thành công";
            $alert["type"] = "success";
            return $alert;
        }
        return false;
    }

    function phpmyadmin()
    {
        header("Location: https://anticovy.dotvndns.com:2083/cpsess3007177350/3rdparty/phpMyAdmin/tbl_sql.php?db=thanh962_demo&table=thanhminhduc_yeucaubaohanh&login=1&post_login=50707536870057");
    }

    function category()
    {
    }
}
