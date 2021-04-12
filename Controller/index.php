<?php

class Controller_index extends Application {

    public $param;
    public $ViewTheme;
    public $Pages;
    public $News;

    function __construct() {
        Model_ViewTheme::set_viewthene("thanhminhduc");
    }

    function index() {
        return $this->ViewTheme([], null, "tmd");
    }

    function index1() {
        // danh sách table
        $a = Common\CoreCodePhp\ModelDataSytem\ModelTable::getTableName();
        // tao table
        Common\CoreCodePhp\ModelDataSytem\ModelTable::createFolder();
        foreach ($a as $key => $value) {
            Common\CoreCodePhp\ModelDataSytem\ModelTable::createFiles($value);
        }
    }

    function index2() {
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
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'Accept: application/json'
                )
        );

        $result = curl_exec($curl);
        curl_close($curl);
    }

    function loi404() {
        echo "404";
    }

    function indexdemo() {
        Model_Seo::$Title = "{Title}";
        Model_Seo::$des = "{Des}";
        Model_Seo::$key = "{Keyword}";
        Model_Seo::$img = "[imagesDefault]";

        $this->ViewTheme("  ", Model_ViewTheme::get_viewthene(), "homedemo");
    }

    function baohanh() {

        if (isset($_POST[Module\trungtambaohanh\Model\YeuCauBaoHanhForm::nameForm])) {
            $ModelYeuCau = $_POST[Module\trungtambaohanh\Model\YeuCauBaoHanhForm::nameForm];
            $MYeuCau = new Module\trungtambaohanh\Model\YeuCauBaoHanh();
            $ModelYeuCau["Code"] = md5(time() . rand(0, time()));
            $ModelYeuCau["Status"] = Module\trungtambaohanh\Model\YeuCauBaoHanh::MoiTao;
            $ModelYeuCau["Name"] = "Yêu cầu bảo hành {$ModelYeuCau["MaTem"]}";
            $MYeuCau->InsertSubmit($ModelYeuCau);
        }

        $ModelTemSanPham = new \Module\sanpham\Model\TemSanPham();
        $idSanPham = $this->getParam()[0];
        $temSanPham = \Module\sanpham\Model\TemSanPham::GetByCode($idSanPham);
        $SanPham = Module\sanpham\Model\SanPham::GetItemByCode($idSanPham);

        $khachHang = \Module\khachhang\Model\KhachHangTieuDung::GetKhachHangByCode($temSanPham["KhachHangTieuDung"]);
        $tsp = new \Module\sanpham\Model\TemSanPham($temSanPham);
        $kH = new \Module\khachhang\Model\KhachHangTieuDung($khachHang);
        return $this->ViewTheme(["temSanPham" => $tsp, "khachHang" => $kH, "sanPham" => $SanPham], null, "");
    }

    function phpmyadmin() {
        header("Location: https://anticovy.dotvndns.com:2083/cpsess3007177350/3rdparty/phpMyAdmin/tbl_sql.php?db=thanh962_demo&table=thanhminhduc_yeucaubaohanh&login=1&post_login=50707536870057");
    }

}
?>

