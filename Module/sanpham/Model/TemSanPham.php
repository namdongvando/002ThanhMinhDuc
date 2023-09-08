<?php

namespace Module\sanpham\Model;

use Datatable\Response;
use Datatable\Table;
use Module\khachhang\Model\KhachHangTieuDung;
use Module\sanpham\Model\XuatNhapKho\PhieuXuatNhap;
use Module\sanpham\Model\XuatNhapKho\PhieuXuatNhapChiTiet;
use Module\trungtambaohanh\Model\YeuCauBaoHanh;

class TemSanPham extends TemSanPhamData
{

    const ChuaDung = null;
    const Active = 1;
    const KyGui = 3;
    const TrungBay = 4;
    const DeActive = 0;
    const Huy = -1;
    const YeuCauKichHoat = 2;

    public $Id, $Name, $Code, $MaSanPham, $KhachHangTieuDung, $NgayBatDau, $ThangKetThuc, $NgayKetThuc, $Status, $UserId, $CreateDate, $ModifyDate;

    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $code = $dv;
                $dv = $this->GetByCode($code);

                if (!$dv) {
                    $dv = $this->GetById($code);
                    // echo "code";
                } else {
                    // var_dump($code);
                    // var_dump($dv);
                }
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->MaSanPham = !empty($dv["MaSanPham"]) ? $dv["MaSanPham"] : null;
            $this->KhachHangTieuDung = !empty($dv["KhachHangTieuDung"]) ? $dv["KhachHangTieuDung"] : null;
            $this->NgayBatDau = !empty($dv["NgayBatDau"]) ? $dv["NgayBatDau"] : date("Y-m-d H:i:s", time());
            $this->NgayKetThuc = !empty($dv["NgayKetThuc"]) ? $dv["NgayKetThuc"] : null;
            $this->ThangKetThuc = !empty($dv["ThangKetThuc"]) ? $dv["ThangKetThuc"] : 24;
            $this->Status = $dv["Status"] ?? null;
            $this->UserId = !empty($dv["UserId"]) ? $dv["UserId"] : 0;
            $this->CreateDate = !empty($dv["CreateDate"]) ? $dv["CreateDate"] : null;
            $this->ModifyDate = !empty($dv["ModifyDate"]) ? $dv["ModifyDate"] : null;
            $this->Parents = !empty($dv["Parents"]) ? $dv["Parents"] : null;
            $this->IsPrint = !empty($dv["IsPrint"]) ? $dv["IsPrint"] : null;
        }
    }

    function GetLichSuKiemHang()
    {
        $i = new SanPhamKiemHang();
        return $i->GetByMaTem($this->Code, 1, 100, $total);
    }
    function ThongTinKiemHang()
    {
        $i = new SanPhamKiemHang();
        return new SanPhamKiemHang($i->GetByMaTem($this->Code, 1, 1, $total)[0] ?? null);
    }

    function KiemHang($Status, $Content)
    {
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $model["Id"] = $this->Id;
        $model["UserId"] = $admin->Id;
        $model["MaSanPham"] = $this->MaSanPham;

        $this->UpdateSubmit($model);
        $spKh = new SanPhamKiemHang();
        $spKh->InsertSubmit([
            "Name" => $admin->Name,
            "MaSanPham" => $this->SanPham()->Id,
            "MaTem" => $this->Code,
            "Status" => $Status,
            "Content" => $Content,
            "UserId" => $model["UserId"],
        ]);
    }

    public static function GetRowsPT($params, $pagesIndex, $pageNumber, &$tong)
    {
        $name = $params["name"] ?? "";
        $status = $params["status"] ?? "all";
        $maTem = $params["MaTem"] ?? "";
        $statusSql = "";
        if ($status != "all") {
            $statusSql = " and `status` = '{$status}'";
        }
        $maTemSql = "";
        if ($maTem != "") {
            $maTemSql = " and `Code` like '%{$maTem}%'";
        }
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $sanpham = new TemSanPham();
        $where = " `Name` like '%{$name}%' {$statusSql} {$maTemSql} ";
        $tong = $sanpham->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";
        return $sanpham->GetRowsByWhere($where);
    }

    function NhanVienKyThuat()
    {
        return new SanPhamKiemHang($this->GetLichSuKiemHang()[0] ?? []);
    }
    function NhanVienBanHang()
    {
        $phieuChiTiet = new PhieuXuatNhapChiTiet();
        return new PhieuXuatNhapChiTiet($phieuChiTiet->GetByMaTem($this->Code)[0] ?? []);
    }

    public function Code($code = null)
    {
        if ($code == null)
            return $this->Code;
        $this->Code = $code;
    }

    public static function GetStatus()
    {
        return [
            self::Active => "Kích Hoạt",
            self::DeActive => "Chưa Kích Hoạt",
            self::YeuCauKichHoat => "Yêu cầu kích hoạt",
        ];
    }
    public static function CreateCode()
    {
        // $where = '1=1';
        // $tem = new TemSanPham();
        // $tong = $tem->GetRowsNumber($where);
        return strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    }

    public function GetByStatus($Status)
    {
        return $this->GetRows("`Status` = '{$Status}'");
    }
    public function GetByParams($Params)
    {
        $Status = $Params["Status"] ?? null;
        $fromDate = $Params["fromDate"] ?? null;
        $toDate = $Params["toDate"] ?? null;
        $dateType = $Params["dateType"] ?? null;
        $dateTypes = [
            "ThoiGianKichHoat" => "NgayBatDau",
            "ThoiGianHetBaoHang" => "NgayKetThuc",
        ];
        $dateTypeCol = $dateTypes[$dateType] ?? "NgayBatDau";
        $whereStatus = "1=1";
        if ($Status) {
            $whereStatus = "`Status` = '{$Status}'";
        }
        $whereFromDate = "";
        if ($fromDate) {
            $whereFromDate = " and `{$dateTypeCol}` > '{$fromDate}'";
        }
        $whereToDate = "";
        if ($toDate) {
            $whereToDate = " and `{$dateTypeCol}` < '{$toDate}'";
        }
        $where = "{$whereStatus} {$whereFromDate} {$whereToDate} order by `{$dateTypeCol}` DESC";
        return $this->GetRows($where);
    }
    public function GetByStatusDaiLy($Status)
    {
        return $this->GetRows("`Status` = '{$Status}' and `KhachHangTieuDung` is NULL");
    }
    public function GetByStatusNguoiDung($Status)
    {
        return $this->GetRows("`Status` = '{$Status}' and `KhachHangTieuDung` is not NULL");
    }
    public function GetByStatusNguoiDungParams($Params)
    {
        $Status = $Params["Status"] ?? null;
        $fromDate = $Params["fromDate"] ?? null;
        $dateType = $Params["dateType"] ?? null;
        $toDate = $Params["toDate"] ?? null;
        $dateTypes = [
            "ThoiGianKichHoat" => "NgayBatDau",
            "ThơiGianHetBaoHanh" => "NgayKetThuc",
        ];
        $dateTypeCol = $dateTypes[$dateType] ?? "NgayBatDau";
        $whereStatus = "1=1";
        if ($Status) {
            $whereStatus = "`Status` = '{$Status}'";
        }
        $whereFromDate = "";
        if ($fromDate) {
            $whereFromDate = " and `{$dateTypeCol}` > '{$fromDate}'";
        }
        $whereToDate = "";
        if ($toDate) {
            $whereToDate = " and `{$dateTypeCol}` < '{$toDate}'";
        }
        $where = "{$whereStatus} {$whereFromDate} {$whereToDate} and `KhachHangTieuDung` is not NULL order by `{$dateTypeCol}` DESC";
        return $this->GetRows($where);
        // return $this->GetRows("`Status` = '{$Status}' and `KhachHangTieuDung` is not NULL");
    }

    public function CountRows()
    {
        return $this->GetRowsNumber();
    }

    public static function GetBySanPham($idSP)
    {
        $temsp = new TemSanPham();
        $where = "`MaSanPham` = {$idSP}";
        return $temsp->GetRowByWhere($where);
    }

    public static function GetByCode($code)
    {
        $temsp = new TemSanPham();
        $where = "`Code` = '{$code}'";
        return $temsp->GetRowByWhere($where);
    }
    static public function GetByKhachHangTieuDung($KhachHangTieuDung)
    {
        $temsp = new TemSanPham();
        $where = "`KhachHangTieuDung` = '{$KhachHangTieuDung}'";
        return $temsp->GetRowByWhere($where);
    }


    public function KhachHangTieuDung()
    {
        return new KhachHangTieuDung($this->KhachHangTieuDung);
    }

    public static function TaoTemSanPham($idSanPham, $maKhachHangTieuDung = null)
    {
        $temsp = new TemSanPham();
        $MSanPham = new SanPham($idSanPham);
        $row["Name"] = $MSanPham->Name;
        $row["MaSanPham"] = $MSanPham->Id;
        $row["Status"] = TemSanPham::DeActive;
        $row["UserId"] = 0;
        $row["CreateDate"] = date("Y-m-d H:i:s");
        $row["ModifyDate"] = date("Y-m-d H:i:s");
        $temsp->InsertRowsTable($row);
        return $temsp->GetBySanPham($idSanPham);
    }

    function SanPham()
    {

        //if ($temSanPham["MaSanPham"] == 0) {
        //            $idSP = $sanPham->TaoSanPham($temSanPham["Code"]);
        //            $temSanPham["MaSanPham"] = $idSP;
        //            $ModelTemSanPham->UpdateSubmit($temSanPham);
        //        }
        $sanPham = new SanPham();
        if ($this->MaSanPham == 0) {
            $ModelTemSanPham = new TemSanPham();
            $temSanPham = \Module\sanpham\Model\TemSanPham::GetByCode($this->Code);
            if ($temSanPham) {
                $idSP = $sanPham->TaoSanPham($temSanPham["Code"]);
                $temSanPham["MaSanPham"] = $idSP;
                $ModelTemSanPham->UpdateSubmit($temSanPham);
            }
        }
        $sp = $sanPham->GetById($this->MaSanPham);
        return new SanPham($sp);
    }

    public function Status()
    {
        $objStatus = $this->GetStatusObj()[$this->Status];
        return json_decode(json_encode($objStatus));
        // $st = json_decode(json_encode($this->GetStatusObj(), JSON_UNESCAPED_UNICODE));
        // if ($this->Status == self::Active) {
        //     return $st->Active;
        // } else {
        //     return $st->DeActive;
        // }
    }

    public function GetStatusObj()
    {
        return [
            self::ChuaDung =>
            [
                "Id" => null,
                "Name" => "Chưa Dùng",
            ],
            self::Active =>
            [
                "Id" => self::Active,
                "Name" => "Kích Hoạt",
            ],
            self::DeActive =>
            [
                "Id" => self::DeActive,
                "Name" => "Chưa Kích Hoạt",
            ],
            self::YeuCauKichHoat =>
            [
                "Id" => self::YeuCauKichHoat,
                "Name" => "Yêu Cầu Kích Hoạt",
            ],
            self::KyGui =>
            [
                "Id" => self::KyGui,
                "Name" => "Ký gửi",
            ],
            self::TrungBay =>
            [
                "Id" => self::TrungBay,
                "Name" => "Trưng bày",
            ]
        ];
    }


    public static function GetByCodeSanPham($idSanPham)
    {
        $sanpham = new SanPham();
        $where = " `Code` = '{$idSanPham}'";
        $_sanpham = $sanpham->GetRowByWhere($where);
        if ($_sanpham) {
            $idSP = $_sanpham["Id"];
            return TemSanPham::GetBySanPham($idSP);
        }
        return [];
    }

    public function UserId()
    {
        if ($this->UserId > 0)
            return new \Module\user\Model\Admin($this->UserId);
        return new \Module\user\Model\Admin(null);
    }

    public function ModifyDate()
    {
        return date("d-m-Y", strtotime($this->ModifyDate));
    }

    public function NgayKetThuc()
    {
        if ($this->NgayKetThuc)
            return date("d-m-Y", strtotime($this->NgayKetThuc));
        return "Chưa cấu hình";
    }

    public function NgayBatDau()
    {
        if ($this->NgayBatDau != null)
            return date("d-m-Y", strtotime($this->NgayBatDau));
        return null;
    }

    public function CreateDate()
    {
        return date("d-m-Y", strtotime($this->CreateDate));
    }

    public function ThangKetThuc()
    {
        if ($this->ThangKetThuc)
            return $this->ThangKetThuc . ' Tháng';
        return "Chưa cấu hình";
    }

    function GetLichSuKiemHangHtml()
    {
        $itemsLs = $this->GetLichSuKiemHang();
        ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Họ Tên</th>
                        <th>Sản Phẩm</th>
                        <th>Mã Tem</th>
                        <th>Tình Trạng</th>
                        <th>Nội dung</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($itemsLs) {
                        foreach ($itemsLs as $key => $value) {
                            $_item = new SanPhamKiemHang($value);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $key + 1 ?>
                                </td>
                                <td>
                                    <?php echo $_item->UserId()->Username; ?>
                                </td>
                                <td>
                                    <?php echo $_item->Name ?>
                                </td>
                                <td>
                                    <?php echo $_item->SanPham()->Name; ?>
                                </td>
                                <td>
                                    <?php echo $_item->MaTem ?>
                                </td>
                                <td>
                                    <?php echo $_item->Status()->Name; ?>
                                </td>
                                <td>
                                    <?php echo $_item->Content ?>
                                </td>
                                <td>
                                    <?php echo $_item->CreateRecord ?>
                                </td>
                            </tr>
                            <?php

                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php

    }
    function PhieuXuatNhap()
    {
        $phieuChiTiet = new PhieuXuatNhapChiTiet();
        return $phieuChiTiet->GetByMaTem($this->Code);
    }
    function PhieuXuatNhapHTML()
    {
        $DS = $this->PhieuXuatNhap();
        ?>

        <?php
    }

    function DSYeuCauBaoHanhChuaHoanThanh()
    {
        $yeucau = new YeuCauBaoHanh();
        $items = $yeucau->ChuaHoanThanh($this->Code);
        return $items;
    }
    function DSLichSuBaoHanh()
    {
        $yeucau = new YeuCauBaoHanh();
        $items = $yeucau->DaHoanThanh($this->Code);
        return $items;
    }
    function DSYeuCauBaoHanh()
    {
        $yeucau = new YeuCauBaoHanh();
        $items = $yeucau->GetByMaTem($this->Code);
        return $items;
    }
    function DSYeuCauBaoHanhToHtml($items, $actions = false)
    {
        $response = new Response();
        $response->params = [];
        $response->totalrows = 100;
        $response->number = 10;
        $response->indexPage = 1;
        $response->totalPage = 1;
        $response->rows = $items;
        $response->status = Response::OK;
        $response->columns = [
            "Actions" => "Thao Tác",
            "Id" => "#",
            "NoiDung" => "Nội dung bảo hành",
            "idNhanVien" => "Nhân Viên",
            "KetQua" => "Kết Quả",
            "SDT" => "SĐT",
            "Status" => "Tình Trạng",
            "CreateDate" => "Ngày tạo yêu cầu",
            "NgayBaoHanh" => "Ngày bảo hành",

        ];
        $response = $response->ToRow();
        $dataTable = new Table([
            "rows" => $response["rows"],
            "columns" => $response["columns"]
        ], YeuCauBaoHanh::class, $actions);
        $dataTable->setPropTable(
            [
                "table" => ["id" => "table", "class" => "table table-border"],
                "thead" => ["class" => "bg-primary"],
            ]
        );
        $dataTable->RenderHtml();
    }

    function CheckPhieuDoiTra()
    {
        $code = $this->Code;
        $ChiTietPhieu = new PhieuXuatNhapChiTiet();
        return $ChiTietPhieu->GetRowByWhere(" `Code` = '{$code}' and `NamePhieu` = 'PhieuDoiTra'");
    }

    function ThongTinSanPhamHTML()
    {
        ?>
        <p style="margin: 0px;">
            <b>Mã Tem</b>:
            <?php echo $this->Code; ?>
        </p>
        <p style="margin: 0px;">
            <b>Tên sản phẩm</b>:
            <?php echo $this->SanPham()->Name; ?>
        </p>
        <p style="margin: 0px;">
            <b>Loại sản phẩm</b>:
            <?php echo $this->CheckPhieuDoiTra() == null ? "SP mới" : "Hàng nhập lại kho" ?>
        </p>
        <!-- <p style="margin: 0px;">
            <b>Trang Thái</b>:
            <?php echo $this->SanPham()->TinhTrang(); ?>
        </p> -->
        <p style="margin: 0px;">
            <b>Đại ly</b> :
            <?php echo $this->SanPham()->DaiLy()->Name; ?>
        </p>
        <p style="margin: 0px;">
            <b>Nhân viên kỹ thuật</b>:
            <?php echo $this->NhanVienKyThuat()->UserId()->Name; ?>
        </p>
        <p style="margin: 0px;">
            <b>Nhân viên Bán hàng</b>:
            <?php echo $this->NhanVienBanHang()->UserId()->Name; ?>
        </p>
        <?php
    }

}