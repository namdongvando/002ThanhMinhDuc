<?php

namespace Module\sanpham\Model;

class SanPham extends SanPhamData
{

    const DangOCty = 0;
    const DangODaiLy = 1;
    const DangOChiNhanh = 2;
    const DangSuDung = 3;

    public $Id, $Name, $Code, $ChungLoaiSP, $Mota, $Gia, $HinhAnh, $DanhMuc, $TinhTrang, $MaDaiLy;
    public $idKhachHang;
    public $isLook;
    public $Wfstatus;

    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            if ($dv) {
                $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
                $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
                $this->idKhachHang = !empty($dv["idKhachHang"]) ? $dv["idKhachHang"] : null;
                $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
                $this->ChungLoaiSP = !empty($dv["ChungLoaiSP"]) ? $dv["ChungLoaiSP"] : null;
                $this->Mota = !empty($dv["Mota"]) ? $dv["Mota"] : null;
                $this->Gia = !empty($dv["Gia"]) ? $dv["Gia"] : 0;
                $this->HinhAnh = !empty($dv["HinhAnh"]) ? $dv["HinhAnh"] : null;
                $this->DanhMuc = !empty($dv["DanhMuc"]) ? $dv["DanhMuc"] : null;
                $this->TinhTrang = !empty($dv["TinhTrang"]) ? $dv["TinhTrang"] : 0;
                $this->Wfstatus = $dv["Wfstatus"] ?? 0;
                $this->MaDaiLy = !empty($dv["MaDaiLy"]) ? $dv["MaDaiLy"] : "";
                $this->isLook = !empty($dv["isLook"]) ? $dv["isLook"] : "";
            }
        }
    }

    function DanhMuc()
    {
        if ($this->DanhMuc)
            return new \Module\option\Model\Option($this->DanhMuc);
        return new \Module\option\Model\Option();
    }

    function ChungLoaiSP()
    {
        return new \Module\option\Model\Option($this->ChungLoaiSP);
    }

    public static function ListTinhTrang()
    {
        return [
            self::DangOCty => "Đang Ở Công Ty",
            self::DangODaiLy => "Nhà Phân Phối",
            self::DangOChiNhanh => "Đại Lý",
            self::DangSuDung => "Người Tiêu Dùng",
        ];
    }

    public function TinhTrang()
    {
        if (isset(self::ListTinhTrang()[$this->TinhTrang]))
            return self::ListTinhTrang()[$this->TinhTrang];
        return self::ListTinhTrang()[self::DangOCty] ?? "N/a";
    }

    public static function SanPhams()
    {
        $sanpham = new SanPham();
        $sanpham->GetRows();
    }

    function SanPhamLog()
    {
        $SanPhamLog = new SanPhamLog();
        return $SanPhamLog->GetByIdSP($this->Id);
    }

    public static function SanPhamsPT($option, $pagesIndex, $pageNumber, &$tong)
    {
        $sqlCount = "SELECT count(*) as `Tong`  FROM `" . table_prefix . "sanpham` as `sp`,`" . table_prefix . "tembaohanh` as `temsp` 
        WHERE `temsp`.`MaSanPham` = `sp`.`Id` ";
        $sql = "SELECT `sp`.* FROM `" . table_prefix . "sanpham` as `sp`,`" . table_prefix . "tembaohanh` as `temsp` 
        WHERE `temsp`.`MaSanPham` = `sp`.`Id` ";

        $sanpham = new SanPham();
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        if (is_array($option)) {
            $name = $option["keyword"];
            $TinhTrang = intval($option["TinhTrang"]);
            $danhmuc = $option["danhmuc"];
            $madaily = $option["madaily"];
            $danhmucSql = "";
            $MaDaiLySql = "";
            if ($danhmuc != "0") {
                $danhmucSql = "and `sp`.`DanhMuc` = '{$danhmuc}'";
            }
            if ($madaily != "all") {
                if ($madaily == -1) {
                    $madaily = 0;
                }
                $MaDaiLySql = "and `sp`.`MaDaiLy` = '{$madaily}'";
            }
            $tinhTrangSql = "";
            if ($TinhTrang > -1) {
                $TenChuaKichHoatSQL = "";
                if ($TinhTrang == TemSanPham::DeActive) {
                    // tem chưa kích hoạt 
                    /* Là tem đã được khai báo tên sp và khách hàng chưa gửi yêu cầu kích hoạt */
                    $TenChuaKichHoatSQL = "and `sp`.`DanhMuc` != ''";
                }
                $tinhTrangSql = "and `temsp`.`Status` = '{$TinhTrang}' {$TenChuaKichHoatSQL}";
            }
            //            phân theo dai lý
            $daily = !empty($option["daily"]) ? $option["daily"] : null;
            $dailySql = "";
            if ($daily != null) {
                $dailySql = " and `sp`.`MaDaiLy` = '{$daily}'";
            }
            $sqlCount .= " {$danhmucSql} {$dailySql} {$MaDaiLySql} {$tinhTrangSql} ";
            // $tong = $sanpham->GetRowsNumber($where);
            $sql .= " {$danhmucSql} {$dailySql} {$MaDaiLySql} {$tinhTrangSql} ";
        } else {
            $name = $option;
            $sqlCount .= " and `sp`.`Name` like '%{$name}%' and `Name` != '' ";
            $sql .= " and `sp`.`Name` like '%{$name}%' and `Name` != '' ";
        }
        // echo $sqlCount;
        $tongSql =  $sanpham->runsqlToArray($sqlCount);
        $tong = ($tongSql[0]["Tong"]);
        $sql .= "limit {$pagesIndex},{$pageNumber}";
        return $sanpham->runsqlToArray($sql);
    }

    function resettem()
    {
        $where = "`Name` != ''";
        $sanphams = $this->GetRowsByWhere($where);
        foreach ($sanphams as $key => $sanPham) {
            $sanPham["Name"] = "";
            $sanPham["Mota"] = "";
            $sanPham["Gia"] = 0;
            $sanPham["MaDaiLy"] = "";
            $sanPham["ChungLoaiSP"] = "";
            $sanPham["HinhAnh"] = "";
            $sanPham["DanhMuc"] = "";
            $sanPham["idKhachHang"] = "";
            $sanPham["TinhTrang"] = self::DangOCty;
            $sanPham["isLook"] = false;
            $this->UpdateSubmit($sanPham);
        }
    }

    public function Code($code = null)
    {
        if ($code == null)
            return $this->Code;
        $this->Code = $code;
    }

    public static function CreateCode()
    {
        return strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    }

    public function CountRows()
    {
        return $this->GetRowsNumber();
    }

    public function TemBaoHanh()
    {
        $tem = new TemSanPham();
        $a = $tem->GetBySanPham($this->Id);
        if ($a)
            return new TemSanPham($a);
        return null;
    }

    public function TemBaoHang()
    {
        $tem = new TemSanPham();
        $a = $tem->GetBySanPham($this->Id);
        if ($a)
            return new TemSanPham($a);
        return null;
    }

    public static function GetItemById($idSanPham)
    {
        $tem = new SanPham();
        $a = $tem->GetById($idSanPham);
        if ($a)
            return new SanPham($a);
        return new SanPham();
    }

    public static function GetItemByCode($idSanPham)
    {
        $tem = new SanPham();
        $where = "`Code` like '%$idSanPham%'";
        $a = $tem->GetRowByWhere($where);
        return $a;
    }

    public static function ListTinhTrangToOptions()
    {
        $lisTinhTrang = self::ListTinhTrang();
        $options = [];
        foreach ($lisTinhTrang as $key => $value) {
            //            $option["Id"] = $key;
            //            $option["Name"] = $value;
            $options[$key] = $value;
        }
        return $options;
    }

    /**
     * Tao5 san pham
     * @param {type} parameter
     */
    public function TaoSanPham($code, $id = null)
    {
        $a = self::GetByCode($code);
        if ($a)
            return $a["Id"];
        if ($id) {
            $sanPham["Id"] = $id;
        }
        $sanPham["Code"] = $code;
        $sanPham["Wfstatus"] = 0;
        $sanPham["Name"] = "";
        $sanPham["Name"] = "";
        $sanPham["MoTa"] = "";
        $sanPham["Gia"] = 0;
        $sanPham["ChungLoaiSP"] = "";
        $sanPham["HinhAnh"] = "";
        $sanPham["DanhMuc"] = "";
        $sanPham["idKhachHang"] = 0;
        $sanPham["TinhTrang"] = SanPham::DangOCty;
        return $this->InsertSubmit($sanPham);
    }

    /**
     * tim2 san pham them code
     * @param {type} parameter
     */
    public static function GetByCode($code)
    {
        $where = "`Code` like '{$code}'";
        $SanPham = new SanPham();
        $a = $SanPham->GetRowByWhere($where);
        return $a;
    }

    public function ToArray()
    {

        $sanPham["Id"] = $this->Id;
        $sanPham["Code"] = $this->Code;
        $sanPham["Name"] = $this->Name;
        $sanPham["MoTa"] = $this->Mota;
        $sanPham["Gia"] = $this->Gia;
        $sanPham["MaDaiLy"] = $this->MaDaiLy;
        $sanPham["ChungLoaiSP"] = $this->ChungLoaiSP;
        $sanPham["HinhAnh"] = $this->HinhAnh;
        $sanPham["DanhMuc"] = $this->DanhMuc;
        $sanPham["idKhachHang"] = $this->idKhachHang;
        $sanPham["TinhTrang"] = $this->TinhTrang;
        $sanPham["Wfstatus"] = $this->Wfstatus;
        $sanPham["isLook"] = $this->isLook == "" ? 0 : intval($this->isLook);
        return $sanPham;
    }

    function DaiLy()
    {
        return new \Module\khachhang\Model\KhachHang($this->MaDaiLy);
    }

    public static function SanPhamsDaiLyPT($name, $pagesIndex, $pageNumber, $tong)
    {
        $MaDaiLy = \Module\user\Model\Admin::getCurentUser(true)->KhachHang()->idKhachHang;
        return self::GetSanPhamsDaiLyPT($MaDaiLy, $name, $pagesIndex, $pageNumber, $tong);
    }

    public static function GetSanPhamsDaiLyPT($MaDaiLy, $name, $pagesIndex, $pageNumber, &$tong)
    {
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $pagesIndex = max($pagesIndex, 0);
        $SanPham = new SanPham();
        $where = "`MaDaiLy` in ({$MaDaiLy})";
        $tong = $SanPham->GetNumberRows($where);
        $where = "`MaDaiLy` in ({$MaDaiLy}) limit {$pagesIndex},{$pageNumber}";
        return $SanPham->GetRows($where);
    }

    public function LinkBaoHanh()
    {
        return "https://cskhtmd.com/" . $this->TemBaoHang()->Code . "/";
    }

    public function LinkQRcodeBaoHanh()
    {
        return "/public/phpqrcode/index.php?data=" . $this->LinkBaoHanh();
    }

    public function Id()
    {
        return md5($this->Id);
    }
}
