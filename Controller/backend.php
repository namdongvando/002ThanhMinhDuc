<?php

namespace Controller;

class backend extends \Application {

    public $param;
    public $Layout;
    public $Bread;

    function __construct() {
        $this->param = $this->getParam();

        if (!\Module\user\Model\Admin::IsLogin()) {
            \Common\Common::toUrl("/user/login/index");
        }
        $this->Bread[] = [
            "title" => "Dashboard",
            "link" => "/backend/"
        ];

//        echo "asdas";
        \Core\ViewTheme::set_viewthene("backend");

//        var_dump(Model_ViewTheme::get_viewthene());
    }

    function index() {
        $Bread = new \Model\Breadcrumb();
        $Bread->setBreadcrumb($this->Bread);
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "main");
    }

    function index1() {
        $Bread = new \Model\Breadcrumb();
        $Bread->setBreadcrumb($this->Bread);

        var_dump(\Application\Model\Permission::checkPermission(__CLASS__));
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "main1");
    }

    function tieudiem() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function wellcome() {
        if ($this->is_mobile())
            Model_ViewTheme::set_viewthene("cms");
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function timkiem() {

        $Bread = new \Model\Breadcrumb();
        $Bread->setBreadcrumb($this->Bread);
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function logout($param = "") {
        try {
            unset($_SESSION[QuanTri]);
            Model\Common::_header("/mlogin");
        } catch (Exception $ex) {

        }
    }

    function cattegorydetail() {
        $cat = new \Model\Category();
        $a = $cat->Category4Id($this->param[0]);
        echo $cat->_encode($a);
    }

    function getCategorys() {
        $cat = new \Model\Category();
        $a = $cat->AllCategorys(FALSE);
        echo $cat->_encode($a);
    }

    function getCategorysByParentID() {
        $cat = new \Model\Category();
        $listCatID = [];
        $cat->AllCategoryByParentID([$this->param[0]], $listCatID);
        $a = [];
        foreach ($listCatID as $k => $v) {
            $a[] = $cat->Category4Id($v);
        }
        echo $cat->_encode($a);
    }

    function getThemes() {
        $cat = new Model_Adapter();
        $a = ["home"];
        echo $cat->_encode($a);
    }

    function getThemeAlFileconfig() {
        $cat = new Model_Adapter();
        $Lib = new \lib\redDirectory();
        $Lib->redDirectoryByPath(__DIR__ . "\..\\theme\\" . $this->param[0] . "\\config\\", $a);
        echo $cat->_encode($a);
    }

    function getConfig() {
        $cat = new Model_Adapter();
        $Lib = new \lib\io();
        $filename = __DIR__ . "/../theme/" . $this->param[0] . "/config/" . $this->param[1];
        $a = $Lib->readFile($filename);
        echo $a;
    }

    function CreateApi($array) {
        $a = new \Model_Adapter();
        if ($array) {
            echo $a->_encode($array);
        } else {
            echo "[]";
        }
    }

    function ifame() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "main");
    }

    function test() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function getMenuByuser() {
        $admin = new \datatable\Admin($_SESSION[QuanTri]);
        $menu = \Application\Model\Permission::getMenuByUser($admin->Groups);
        echo json_encode($menu);
    }

    function danhsachtin() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function tinxemnhieu() {

        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function tindangviet() {

        if ($this->is_mobile()) {
            Model_ViewTheme::set_viewthene("cms");
        }
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function backendhomeapi() {
        $dataJ = [];
        $data = [];
        /**
         * Them bài viết
         * @param {type} parameter
         */
        $data ["number"] = "";
        $data ["title"] = "Thêm Bài Viết";
        $data ["icon"] = "fa fa-edit";
        $data ["link"] = "/mnews/addnews/";
        $dataJ[] = $data;

        /**
         * tin dang dang
         * @param {type} parameter
         */
        $news = new \datatable\News();
        $data["number"] = $news->getTongSoTinTheoAnHienUser(datatable\AnHien::DangDang, Permission::NhomQuenSuaTatCa());
        $data["title"] = "Tin Đang Đăng";
        $data ["icon"] = "fa fa-list";
        $data["link"] = "/backend/danhsachtin/";
        $dataJ[] = $data;
        /**
         * tin xem nhieu
         * @param {type} parameter
         */
        $data = [];
        $data ["number"] = 10;
        $data ["title"] = "Tin Xem Nhiều Nhất";
        $data ["link"] = "/backend/tinxemnhieu/";
        $dataJ[] = $data;
        /**
         * tin tieu diem
         * @param {type} parameter
         */
        $data = [];
        $data ["number"] = count($news->getNewsHot());
        $data ["title"] = "Tin Tiêu Điểm";
        $data ["link"] = "/backend/tieudiem/";
        $dataJ[] = $data;
        /**
         * tài khoản
         * @param {type} parameter
         */
        if (Application\Model\Permission::QuenXemTaiKhoan()) {
            $data = [];
            $data ["number"] = datatable\Admin::getTongSoUser();
            $data ["title"] = "Tài Khoản";
            $data ["link"] = "/backend/wellcome/";
            $dataJ[] = $data;
        }

        $data = [];
        $data ["number"] = $news->getTongSoTinTheoAnHienUser(\datatable\AnHien::DangCapNhat);
        $data ["title"] = "Tin Đang Viết";
        $data ["link"] = "/backend/tindangviet/";
        $dataJ[] = $data;
        $data = [];
        $data ["number"] = count($news->ThongBao());
        $data ["title"] = "Thông Báo";
        $data ["icon"] = "fa-bullhorn fa";
        $data ["link"] = "/backend/thongbao/";
        $dataJ[] = $data;
        $data = [];
        /**
         * danh sach tin dang cho duyet
         * @param {type} parameter
         */
        $data ["number"] = $news->getTongSoTinTheoAnHien(\datatable\AnHien::ChoDuyet);
        $data ["title"] = "Tin Chờ Duyệt";
        $data ["link"] = "/duyettin/";
        if (datatable\Admin::CurerntUser(true)->Groups != Application\Model\Permission::BienTap)
            $dataJ[] = $data;
        $data = [];
        /**
         * danh sach tin dang cho duyet
         * @param {type} parameter
         */
        $data ["number"] = $news->getTongSoTinTheoAnHien(\datatable\AnHien::ChoDuyet);
        $data ["title"] = "Tin Đã Gửi Duyệt";
        $data ["link"] = "/backend/tindagui/";
        $dataJ[] = $data;
        $data = [];
        echo json_encode($dataJ);
    }

    private function DeNghiSuaTin() {

        $new = new \datatable\News();
        $a = $new->getNewsByAnHienUser(datatable\AnHien::YeuCauSua);
        $b = [];

        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $an = $value->AnHien == 0 ? 'selected="selected"' : "";
                $hien = $value->AnHien == 1 ? 'selected="selected"' : "";
                $Id = <<<Name
<a href="/mnews/editnews/{$value->Id}"   >{$value->Id}</a>
Name;
                $Name = <<<Name
<a href="/mnews/editnews/{$value->Id}"   ><span class="bg-danger" >[Yêu Cầu Chỉnh Sửa]</span> {$value->Name}</a>
Name;

                $b[$k][] = $k + 1;
                $b[$k][] = $Name;
                $b[$k][] = $value->NgaySua;
            }
        }

        return $b;
    }

    private function DuyetTin() {

        $new = new \datatable\News();
        $a = $new->getNewsByAnHienAndLevelUser([datatable\AnHien::ChoDuyet]);
        $b = [];
        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
//                if (Permission::QuyenDuyetBaiViet($value)) {
//                } else {
//                    $Name = <<<Name
//<span class="bg-success" >[{$value->AnHien()}]</span> {$value->Name}
//Name;
//                }

                $Name = <<<Name
<a href="/duyettin/xem/{$value->Id}"   ><span class="bg-success" >[{$value->AnHien()}]</span> {$value->Name}</a>
Name;
                $b[$k][] = $k + 1;
                $b[$k][] = $Name;
                $b[$k][] = $value->Username;
                $b[$k][] = $value->NgaySua;
            }
        }

        return $b;
    }

    private function BaiDaDang() {

        $new = new \datatable\News();
        $a = $new->getNewsByAnHienAndLevelUser([datatable\AnHien::DangDang]);
        $b = [];
        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $Name = <<<Name
<span class="bg-success" >[{$value->AnHien()}]</span> {$value->Name}
Name;
//                if (Permission::QuyenGoDangBaiViet($value)) {
                $Name = <<<Name
<a href="/duyettin/xem/{$value->Id}"   >{$Name}</a>
Name;
//                }
                $b[$k][] = $k + 1;
                $b[$k][] = $Name;
                $b[$k][] = $value->Username;
                $b[$k][] = $value->NgayDang();
            }
        }

        return $b;
    }

    private function TinDangCapNhat() {

        $new = new \datatable\News();
        $a = $new->getNewsByAnHienUser([datatable\AnHien::DangCapNhat, datatable\AnHien::YeuCauSua]);
        $b = [];
        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);

                $Name = <<<Name
<a href="/duyettin/xem/{$value->Id}"   ><span class="bg-success" >[{$value->AnHien()}]</span> {$value->Name}</a>
Name;

                $b[$k][] = $k + 1;
                $b[$k][] = $Name;
                $b[$k][] = $value->NgayDang();
            }
        }

        return $b;
    }

    function getCongViec() {
        $a = $this->DuyetTin();
        $b = $this->DeNghiSuaTin();
        $d = [];
        if (Permission::QuyenDangNgay()) {
            $d = $this->TinChoDang();
        }
        $e = array_merge($d, $a);
        $c["data"] = array_merge($e, $b);

        echo json_encode($c);
    }

    function getCongViecMobie() {
        $a = $this->DuyetTinMobie();
        $b = $this->DeNghiSuaTinMobie();
        $d = $this->TinChoDangMobie();
        $e = array_merge($d, $a);
        $c["data"] = array_merge($e, $b);

        echo json_encode($c);
    }

    function libimg() {

        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function thongbao() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    function thuvien() {
        if (Permission::QuyenXemThuVienKhac()) {

            $Code = Model\Site::getCurentSite(true)->Code;
            $path = "public/img/" . sha1($Code) . "/";
            \Model\PathCKfinder::set($path);
        } else {
            \Model\PathCKfinder::set();
        }
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    public function DuyetTinMobie() {
        if (datatable\Admin::CurerntUser(true)->Groups == Application\Model\Permission::BienTap)
            return [];
        $new = new \datatable\News();
        $a = $new->getNewsByAnHien(datatable\AnHien::ChoDuyet);
        $b = [];
        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $an = $value->AnHien == 0 ? 'selected="selected"' : "";
                $hien = $value->AnHien == 1 ? 'selected="selected"' : "";
                $Id = <<<Name
<a href="/duyettin/xem/{$value->Id}"   >{$value->Id}</a>
Name;
                $Name = <<<Name
<a href="/duyettin/xem/{$value->Id}"   ><span class="bg-success" >[Chờ Duyệt Tin]</span> {$value->Name}</a>
Name;


                $b[$k][] = $Name;
                $b[$k][] = $value->NgayDang();
            }
        }

        return $b;
    }

    public function DeNghiSuaTinMobie() {
        $new = new \datatable\News();
        $a = $new->getNewsByAnHienUser(datatable\AnHien::YeuCauSua);
        $b = [];

        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $an = $value->AnHien == 0 ? 'selected="selected"' : "";
                $hien = $value->AnHien == 1 ? 'selected="selected"' : "";
                $Id = <<<Name
<a href="/mnews/editnews/{$value->Id}"   >{$value->Id}</a>
Name;
                $Name = <<<Name
<a href="/mnews/editnews/{$value->Id}"   ><span class="bg-danger" >[Chờ Chỉnh Sửa]</span> {$value->Name}</a>
Name;


                $b[$k][] = $Name;
                $b[$k][] = $value->NgayDang();
            }
        }

        return $b;
    }

    public function TinChoDangMobie() {
        $new = new \datatable\News();
        $a = $new->getNewsByAnHienUser(datatable\AnHien::ChoDang);
        $b = [];

        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $an = $value->AnHien == 0 ? 'selected="selected"' : "";
                $hien = $value->AnHien == 1 ? 'selected="selected"' : "";
                $Id = <<<Name
<a href="/duyettin/xem/{$value->Id}"   >{$value->Id}</a>
Name;
                $Name = <<<Name
<a href="/duyettin/xem/{$value->Id}"   >
    <span class="bg-danger" >[Chờ Đăng Tin] </span>{$value->Name}
</a>
Name;
                $b[$k][] = $Name;
                $b[$k][] = $value->NgaySua;
            }
        }
        return $b;
    }

    public function danhsachtinuser() {

    }

    public function TinChoDang() {
        $new = new \datatable\News();
        /**
         * lay bai viet cua user có quyền thấp hơn
         * @param {type} parameter
         */
        $a = $new->getNewsByAnHienAndLevelUser([datatable\AnHien::ChoDang, datatable\AnHien::HuyDang]);
        $b = [];
        if ($a) {
            foreach ($a as $k => $value) {
                $value = new \datatable\News($value);
                $an = $value->AnHien == 0 ? 'selected="selected"' : "";
                $hien = $value->AnHien == 1 ? 'selected="selected"' : "";
                $Id = <<<Name
<a class="linktotab" data-target="tindangdang{$value->Id}" href="/duyettin/xem/{$value->Id}"   >{$value->Id}</a>
Name;
                $Name = <<<Name
    <span class="bg-danger" >[{$value->AnHien()}] </span>{$value->Name}
Name;
//                if (Permission::QuyenDangNgay($value)) {
                $Name = <<<Name
<a class="linktotab" data-target="tindangdang{$value->Id}" href="/duyettin/xem/{$value->Id}"   >
    <span class="bg-danger" >[{$value->AnHien()}] </span>{$value->Name}
</a>
Name;
//                }



                $b[$k][] = $k + 1;
                $b[$k][] = $Name;
                $b[$k][] = $value->Username;
                $b[$k][] = $value->NgayDang();
            }
        }

        return $b;
    }

    function TinGoDang() {

    }

    function tindagui() {
        $this->ViewTheme("", Model_ViewTheme::get_viewthene(), "nolayout");
    }

    /**
     * tin chờ duỵet
     * @param {type} parameter
     */
    function gettinchouyet() {
        $a = $this->DuyetTin();
        $c["data"] = $a;
        echo json_encode($c);
    }

    /**
     * bài viet dang cho đăng
     * @param {type} parameter
     */
    function gettinchodang() {
        $a = $this->TinChoDang();
        $c["data"] = $a;
        echo json_encode($c);
    }

    /**
     * bài viết dang chờ cập nhật
     * @param {type} parameter
     */
    function gettindangcapnhat() {
        $a = $this->TinDangCapNhat();
        $c["data"] = $a;

        echo json_encode($c);
    }

    /**
     * bài viết dang đăng
     * @param {type} parameter
     */
    function gettindangdang() {
        $a = $this->BaiDaDang();
        $c["data"] = $a;
        echo json_encode($c);
    }

}

?>