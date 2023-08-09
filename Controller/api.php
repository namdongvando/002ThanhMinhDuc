<?php

// api này không cần dang nhap
class Controller_api extends Application
{

    public $param;
    public $Api;

    function __construct()
    {
        $this->param = $this->getParam();
        $this->Api = new \lib\APIs();
    }
    function TinhThanhTagOption()
    {
        $model_option = new \Module\option\Model\Option();
        $groups = $this->getParam()[0];
        $Options = $model_option->GetTinhThanh($groups);
        foreach ($Options as $key => $tt) {
            echo "<option value='{$tt["Id"]}' >{$tt["Name"]}</option>";
        }
    }
    public function testapi()
    {
        $infor = [
            "hoTen" => "Tèo Nguyễn",
        ];
        echo json_encode($infor);
    }
    function getNewsHot()
    {
        $new = new \datatable\News();
        $a = $new->getNewsHot();
        var_dump($a);
        echo json_encode($a);
    }

    function getMenus()
    {
        Model_SaveCache::startCache();

        $Menu = new Model\Menu();
        $ds = $Menu->Menus();
        $str = $this->Api->ArrayToStringJson($ds);
        Model_SaveCache::endCache($str);
        echo $str;
        flush();
        exit();
    }

    function getMenuByGroups()
    {
        $position = $this->getParam()[0];
        $Menu = new Model\Menu();
        $ds = $Menu->MenusByGroup($position);
        $this->Api->ArrayToApi($ds);
    }

    function index()
    {
        $cat = new Model\Category();
        $a = $cat->Categorys4IDParent(0);
        $cat->_encode($a);
    }

    function getMainMenu()
    {
        $cat = new Model\Category();
        $a = $cat->Categorys4IDParent(0);
        if ($a)
            foreach ($a as $k => $cata) {
                $a[$k]->DSDanhMucCon = $cat->Categorys4IDParent($cata->catID);
                if ($a[$k]->DSDanhMucCon)
                    foreach ($a[$k]->DSDanhMucCon as $k1 => $cata1) {
                        $a[$k]->DSDanhMucCon[$k1]->DSDanhMucCon = $cat->Categorys4IDParent($cata1->catID);
                    }
            }
        echo $cat->_encode($a);
    }

    function getAdvByGroup()
    {
        $cat = new \Model\adv();
        $a = $cat->AdvsByGroup($this->param[0], FALSE);
        echo $cat->_encode($a);
    }

    function getPages()
    {
        $Pa = new \Model\pages();
        $Apis = new \lib\APIs();
        $a = $Pa->PagesByType(1, FALSE);
        $Apis->ArrayToApi($a);
    }

    function getMainMenuThong($param)
    {
    }

    function getPagesLink()
    {
        $M_Pages = new \Model\pages();
        $lib = new lib\APIs();
        $a = $M_Pages->PagesMin(FALSE);
        $b = [];
        foreach ($a as $k => $pages) {
            $_pages = new Model\pages($pages);
            $b[$k]["Name"] = $_pages->Name;
            $b[$k]["link"] = $_pages->linkPagesCurent();
        }
        $lib->ArrayToApi($b);
    }

    function getCatLink()
    {
        $M_Cat = new \Model\Category();
        $lib = new lib\APIs();
        $a = $M_Cat->AllCategorys(FALSE);
        $b = [];
        foreach ($a as $k => $cat) {
            $_cat = new \Model\Category($cat);
            $b[$k]["link"] = $_cat->linkCurentCategory();
            $b[$k]["name"] = $_cat->catName;
        }
        $lib->ArrayToApi($b);
    }

    function counter()
    {
        $api = new lib\APIs();
        $oi = new \lib\io();
        //        $this->luuThongtin();
        $filename = "data/counter.txt";
        $a = json_decode($oi->readFile($filename), JSON_OBJECT_AS_ARRAY);
        $api->ArrayToApi($a);
        flush();
        $this->luuThongtin();
    }

    function luuThongtin()
    {
        $filename = "data/counter.txt";


        $idSession = session_id();
        $DB = new \Model\Database();
        settype($idloai, "int");
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $DB->Bokytusql($_SERVER['HTTP_USER_AGENT']);
        $username = (isset($_SESSION[QuanTri]) == true) ? implode("___", $_SESSION[QuanTri]) : "";
        $idSession = session_id();
        $ss = $DB->select(table_prefix . "sessions", [], "idSession='{$idSession}'");
        if (!$ss)
            $ss = [];
        if (count($ss) > 0) {
            $ss["lastVisit"] = time();
            $DB->update(table_prefix . "sessions", $ss[0], "idSession='{$idSession}'");
        } else {
            $data = get_class();
            $sql = "INSERT INTO " . table_prefix . "sessions SET idSession = '$idSession',
		userAgent = '{$userAgent}', lastVisit = unix_timestamp(),
		session_start = unix_timestamp(),username = '$username',
		ipAddress = '$ipAddress', idloai = $idloai";
            $DB->Query($sql);
            $DB->Luu();
            $sql = "INSERT INTO " . table_prefix . "counter SET idSession = '$idSession',
		userAgent = '{$userAgent}', lastVisit = unix_timestamp(),DateCreate = '" . date("Y-m-d", time()) . "',
		session_start = unix_timestamp(),ipAddress = '$ipAddress'";
            $DB->Query($sql);
            $DB->Luu();
        }


        $sessionTime = 5; //thời gian lưu thông tin
        $sql = "DELETE FROM " . table_prefix . "sessions WHERE unix_timestamp()-lastVisit >=$sessionTime*60";
        $DB->Query($sql);
        $DB->Luu();
        // số người xem
        $sql = "select count(*) from " . table_prefix . "sessions";
        $DB->query($sql);
        $rs = $DB->fetchRows();
        $sql = "SELECT count(*) FROM `" . table_prefix . "counter`";
        $DB->query($sql);
        $tong = $DB->fetchRows();
        $sql = "SELECT count(*) FROM `" . table_prefix . "counter`  WHERE `DateCreate` = '" . date("Y-m-d", time()) . "' group by `DateCreate`";
        $DB->query($sql);
        $homnay = $DB->fetchRows();
        $sql = "SELECT count(*) FROM `" . table_prefix . "counter` WHERE `DateCreate` = '" . date("Y-m-d", time() - 24 * 3600) . "' group by `DateCreate` ";
        $DB->query($sql);
        $homqua = $DB->fetchRows();
        $sql = "SELECT count(*) FROM `" . table_prefix . "counter` WHERE `DateCreate` like '%" . date("Y-m") . "%' group by `DateCreate` ";
        $DB->query($sql);
        $ThangNay = $DB->fetchRows();

        $io = new \lib\io();

        $a = [
            "online" => $rs[0],
            "today" => $homnay[0],
            "Homqua" => $homqua[0] == "" ? 0 : $homqua[0],
            "Thang" => $ThangNay[0] == "" ? 0 : $ThangNay[0],
            "total" => $tong[0]
        ];
        $io->writeFile($filename, json_encode($a));
        return $a;
    }

    function QuanCao()
    {
        $QuanCao = new Model\adv();
        $DS = $QuanCao->AdvsByGroup($this->getParam()[0]);
        $this->Api->ArrayToApi($DS);
    }

    function gettinhthanh()
    {
        $param = self::getParam();
        $tinhThanh = new datatable\TinhThanh();
        $a = $tinhThanh->getTinhThanhByParent($param[0]);
        echo json_encode($a);
        exit();
    }

    function getRSSAPI()
    {
        Model_SaveCache::startCache(3600 * 2);
        $RSS = \Model\RssSoYTe::getTinTuc();
        $data[0] = ["Title" => "Tin Tức", "Id" => "TinTuc"];
        $data[0]["News"] = $RSS;
        $RSS = \Model\RssSoYTe::getVanBan();
        $data[1] = ["Title" => "Văn Bản", "Id" => "VanBan"];
        $data[1]["News"] = $RSS;
        $RSS = \Model\RssSoYTe::getThongBao();
        $data[2] = ["Title" => "Thông Báo", "Id" => "ThongBao"];
        $data[2]["News"] = $RSS;
        $RSS = \Model\RssSoYTe::getThuMoi();
        $data[3] = ["Title" => "Thư Mời", "Id" => "ThuMoi"];
        $data[3]["News"] = $RSS;
        $RSS = \Model\RssSoYTe::getLichCongTac();
        $data[4] = ["Title" => "Lịch Công Tác", "Id" => "LichCongTac"];
        $data[4]["News"] = $RSS;
        $str = json_encode($data);
        echo $str;
        flush();
        Model_SaveCache::endCache($str);
        exit();
    }

    function getAdvSlide()
    {
        $QuangCao = new \Model\adv();

        \lib\imageComp::SetImagesDefault(\datatable\News::Noimages);
        $img = new \lib\imageComp();
        $Advs = $QuangCao->AdvsByGroup("homeslide", FALSE);
        foreach ($Advs as $key => $value) {
            $value = new Model\adv($value);
            $Advs[$key]["Urlimages"] = "/" . $img->layHinh($value->Urlimages, 200, 200, true);
        }
        echo json_encode($Advs);
    }

    function getLinkLienKet()
    {
        Model_SaveCache::startCache(5000);
        $QuangCao = new \Model\adv();
        $Advs = $QuangCao->AdvsByGroup("linklienket", FALSE);
        $str = json_encode($Advs);
        echo $str;
        flush();
        Model_SaveCache::endCache($str);
        exit();
    }

    function getHomerightarea()
    {
        $QuangCao = new \Model\adv();
        $Advs = $QuangCao->AdvsByGroup("homerightarea", FALSE);
        echo json_encode($Advs);
    }

    function timkiem()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $tukhoa = $this->getParam()[0];
        $news = new \datatable\News();

        $news = $news->getNewsByKeyword($tukhoa);
        $newsDataJson = [];

        foreach ($news as $k => $value) {
            $value = new \datatable\News($value);
            $news[$k]["Link"] = $value->linkNewsCurent();
            $news[$k]["PagesName"] = $value->getCategory()->Name;
            $newsDataJson[$k]["Id"] = $value->Id;
            $newsDataJson[$k]["Name"] = $value->Name;
            $newsDataJson[$k]["Link"] = $value->linkFullNewsCurent();
            $newsDataJson[$k]["Alias"] = $value->Alias;
            $newsDataJson[$k]["PageID"] = $value->PageID;
        }
        echo json_encode($newsDataJson);
    }

    function AppData()
    {
        $Menu = new Model\Menu();
        $imageComp = new \lib\imageComp();

        $ds = $Menu->MenusByGroupParent("TopMainMenu", 0);
        $data["MainMenu"] = $ds;
        $Mpages = new \datatable\Pages();
        $_Pages = new \datatable\Pages($Mpages->getPageById(\Model\ConfigTheme::getConfigThemeObj()->ThongBao->Pages));
        $News = new datatable\News();
        \lib\imageComp::SetImagesDefault($News->NoImages());
        if (\Model\ConfigTheme::getConfigThemeObj()->ThongBao->Display == 1) {
            $a = [];
            foreach ($_Pages->getNews() as $key => $_news) {
                $_news = new \datatable\News($_news);
                $a[$key]["Link"] = $_news->linkNewsCurent();
                $a[$key]["Name"] = $_news->Name;
                $a[$key]["UrlHinh"] = $imageComp->layHinh($_news->UrlHinh, 100, 100);
            }
        }
        $data["ThongBao"] = $a;


        $tieuDiem = $News->getNewsHot();
        foreach ($tieuDiem as $key => $value) {
            $value = new datatable\News($value);
            $tieuDiem[$key] = $value->newToArrayApi();
        }
        $data["TieuDiem"] = $tieuDiem;

        $tinMoiNhat = $News->getNewsByNgayDang(10);
        foreach ($tinMoiNhat as $key => $value) {
            $value = new datatable\News($value);
            $tinMoiNhat[$key] = $value->newToArrayApi();
        }
        $data["TinMoiNhat"] = $tinMoiNhat;

        $Hotnews = $News->getNewsHot();
        //        var_dump($Hotnews);
        foreach ($Hotnews as $key => $value) {
            //            echo urldecode($value["UrlHinh"]);
            $value = new datatable\News($value);
            $Hotnews[$key] = $value->newToArrayApi();
        }
        $data["ThongTinNong"] = $Hotnews;

        $QuangCao = new \Model\adv();
        $Advs = $QuangCao->AdvsByGroup("linklienket", FALSE);
        $data["LinkLienKet"] = $Advs;
        echo json_encode($data);
    }

    function getnewbydanhmuc()
    {
        $Pages = new \datatable\Pages();
        $_Page = new \datatable\Pages($Pages->getPageById($this->getParam()[0]));
        $news = $_Page->getNewsByPagesHomeNumber(6);
        foreach ($news as $key => $value) {
            $value = new datatable\News($value);
            $news[$key] = $value->newToArrayApi();
        }
        $b["owl"] = $news;
        echo json_encode($b);
    }

    function getdanhmuc()
    {
        $Mpages = new \datatable\Pages();
        $a = $Mpages->Pages();
        $b["owl"] = $a;
        echo json_encode($b);
    }

    function test()
    {
        $url = "Images%3A%2Fnews/";
        $url = str_replace("%2F", "/", $url);
        $url = str_replace("%3A", ":", $url);
        echo $url;
    }

    function getLinkTrungTamYTe()
    {
        Model_SaveCache::startCache(5000);
        $QuangCao = new \Model\adv();
        $Advs = $QuangCao->AdvsByGroup("trungtamyte", FALSE);
        $str = json_encode($Advs);
        echo $str;
        flush();
        Model_SaveCache::endCache($str);
        exit();
    }

    function couter()
    {

        echo json_encode(
            [
                "online" => rand(100, 120),
                "today" => 900,
                "total" => 1000
            ]
        );
    }
 

    //luuthongtin
}