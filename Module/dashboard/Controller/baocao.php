<?php

namespace Module\dashboard\Controller;

use Common\Common;
use Module\excell\Model\excell\ExcelReader;
use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\TemSanPham;
use Module\sanpham\Model\XuatNhapKho\PhieuXuatNhapChiTiet;

class baocao extends \ApplicationM
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

        return $this->ViewThemeModlue([], null, "");
    }
    function baocao1()
    {
        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DateType = $_GET["DateType"] ?? "ThoiGianKichHoat";
        $fromDate = $_GET["fromDate"] ?? Common::GetFirstDateOfMonth();
        $toDate = $_GET["toDate"] ?? Common::GetLastDateOfMonth();
        $DSTem =  $TemSamPham->GetByParams(
            [
                "Status" => TemSanPham::Active,
                "dateType" => $DateType,
                "fromDate" => $fromDate,
                "toDate" => $toDate,
            ]
        );
        $dataRow = [];
        $dataRow[] = "STT";
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $dataRow[] = "Thời gian kích hoạt";
        $dataRow[] = "Thời gian hết bảo hành";
        $dataRow[] = "Tình trạng sản phẩm";

        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->SanPham()->Code();
            $dataRow[] = $_tem->Code;
            $dataRow[] = $_tem->NgayBatDau();
            $dataRow[] = $_tem->NgayKetThuc();
            $dataRow[] = $_tem->Status()->Name;
            $data[] = $dataRow;
        }
        $fileName = date("Y-m-d_His", time());
        ExcelReader::Export($data, "public/baocao1.xlsx");
    }
    function baocao2()
    {
        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DSTem =  $TemSamPham->GetByStatus(TemSanPham::Huy);
        $dataRow = [];
        $dataRow[] = "STT";
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $dataRow[] = "Thời gian kích hoạt";
        $dataRow[] = "Tình trạng sản phẩm";

        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->Code;
            $dataRow[] = $_tem->NgayBatDau;
            $dataRow[] = $_tem->NgayKetThuc();
            $dataRow[] = $_tem->Status()->Name;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao2.xlsx");
    }
    function baocao3()
    {
        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DSTem =  $TemSamPham->GetByStatusDaiLy(TemSanPham::Active);
        $dataRow = [];
        $dataRow[] = "STT";
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $dataRow[] = "Thời gian kích hoạt để xuất kho";
        $dataRow[] = "Tình trạng sản phẩm";
        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi();
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->SanPham()->Code;
            $dataRow[] = $_tem->Code;
            $dataRow[] = $_tem->NgayBatDau();
            $dataRow[] = $_tem->Status()->Name;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao3.xlsx");
    }
    function baocao4()
    {
        //4.     Xuất báo cáo danh sách thông tin người sử dụng kích hoạt
        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DateType = $_GET["DateType"] ?? "ThoiGianKichHoat";
        $fromDate = $_GET["fromDate"] ?? Common::GetFirstDateOfMonth();
        $toDate = $_GET["toDate"] ?? Common::GetLastDateOfMonth();

        $DSTem =  $TemSamPham->GetByStatusNguoiDungParams(
            [
                "Status" => TemSanPham::Active,
                "dateType" => $DateType,
                "fromDate" => $fromDate,
                "toDate" => $toDate,
            ]
        );
        $dataRow = [];

        $dataRow[] = "STT";
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên người sử dụng";
        $dataRow[] = "Địa chỉ NSD";
        $dataRow[] = "Số điện thoại NSD";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $dataRow[] = "Thời gian người sử dụng kích hoạt";
        $dataRow[] = "Thời gian hết bảo hành";
        $data[]  = $dataRow;

        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->KhachHangTieuDung()->Name;
            $dataRow[] = $_tem->KhachHangTieuDung()->DiaChi();
            $dataRow[] = $_tem->KhachHangTieuDung()->Phone;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->SanPham()->Code;
            $dataRow[] = $_tem->NgayBatDau();
            $dataRow[] = $_tem->NgayKetThuc();
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao4.xlsx");
    }
    function baocao5()
    {

        //5.     Xuất báo cáo danh sách thông tin người sử dụng kích hoạt

        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DSTem =  $TemSamPham->GetByStatus(TemSanPham::DeActive);
        $dataRow = [];
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi();
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->SanPham()->Code;
            $dataRow[] = $_tem->Code;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao6.xlsx");
    }
    function baocao6()
    {

        //6.   Xuất báo cáo danh sách thông tin khách hàng đại lý đã phát sinh đơn hàng

        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DSTem =  $TemSamPham->GetByStatus(TemSanPham::DeActive);
        $dataRow = [];
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Ngày xuất hàng";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Mã SP";
        $dataRow[] = "Mã code";
        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi();
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->NgayBatDau();
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->SanPham()->Code;
            $dataRow[] = $_tem->Code;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao6.xlsx");
    }
    function baocao7()
    {
        //7.      Xuất báo cáo danh sách số lượng tem chưa kích hoạt
        ini_set('memory_limit', '-1');
        $TemSamPham = new TemSanPham();
        $DateType = $_GET["DateType"] ?? "ThoiGianKichHoat";
        $fromDate = $_GET["fromDate"] ?? Common::GetFirstDateOfMonth();
        $toDate = $_GET["toDate"] ?? Common::GetLastDateOfMonth();
        $DSTem =  $TemSamPham->GetByParams(
            [
                "Status" => TemSanPham::ChuaDung,
                "dateType" => $DateType,
                "fromDate" => $fromDate,
                "toDate" => $toDate,
            ]
        );
        $dataRow = [];
        $dataRow[] = "STT";
        $dataRow[] = "Tên đại lý";
        $dataRow[] = "Địa chỉ đại lý";
        $dataRow[] = "Số điện thoại đại lý";
        $dataRow[] = "Tên sản phẩm";
        $dataRow[] = "Thời gian khi báo mã SP";
        $dataRow[] = "Mã code";
        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_tem = new TemSanPham($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_tem->SanPham()->DaiLy()->Name;
            $dataRow[] = $_tem->SanPham()->DaiLy()->DiaChi();
            $dataRow[] = $_tem->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_tem->SanPham()->Name;
            $dataRow[] = $_tem->NgayBatDau();
            $dataRow[] = $_tem->Code;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao7.xlsx");
    }
    function baocao8()
    {
 
        //7.      Thống kê phiếu xuất nhập
        ini_set('memory_limit', '-1');
        $phieuXuatNhapChiTiet = new PhieuXuatNhapChiTiet();
        $DateType = $_GET["DateType"] ?? "ThoiGianKichHoat";
        $fromDate = $_GET["fromDate"] ?? Common::GetFirstDateOfMonth();
        $toDate = $_GET["toDate"] ?? Common::GetLastDateOfMonth();
         
        $DSTem =  $phieuXuatNhapChiTiet->GetSanPham( $fromDate, $toDate);
        $dataRow = [];
        $dataRow[]="STT";
        $dataRow[]="Tên đại lý";
        $dataRow[]="Địa chỉ";
        $dataRow[]="đại lý";
        $dataRow[]="Số điện thoại";
        $dataRow[]="đại lý";
        $dataRow[]="Tên sản phẩm";
        $dataRow[]="Mã SP";
        $dataRow[]="Mã code";
        $dataRow[]="Nhân viên bán hàng";
        $dataRow[]="Thời gian kích hoạt";
        $dataRow[]="Thời gian hoàn trả";
        $dataRow[]="Lý do hoàn trả";
        $dataRow[]="Điều kiện nhập kho";
        $dataRow[]="Lý do";
        $dataRow[]="Tình trạng sản phẩm";
        $dataRow[]="Người nhập kho";
        $data[]  = $dataRow;
        foreach ($DSTem as $key => $value) {
            $dataRow = [];
            $_phieuChiTiet = new PhieuXuatNhapChiTiet($value);
            $dataRow[] = $key + 1;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->SanPham()->DaiLy()->Name;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->SanPham()->DaiLy()->DiaChi();
            $dataRow[] = $_phieuChiTiet->TemSanPham()->SanPham()->DaiLy()->DienThoai;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->SanPham()->Name;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->NgayBatDau();
            $dataRow[] = $_phieuChiTiet->TemSanPham()->SanPham()->Code;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->Code;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->NhanVienBanHang()->UserId()->Name;
            $dataRow[] = $_phieuChiTiet->TemSanPham()->NgayBatDau();
            $dataRow[] = $_phieuChiTiet->PhieuXuatNhap()->LyDo;
            $dataRow[] = $_phieuChiTiet->PhieuXuatNhap()->TinhTrangSanPham()->Name;
            $dataRow[] = $_phieuChiTiet->PhieuXuatNhap()->UserId()->Name;
            $data[] = $dataRow;
        }
        ExcelReader::Export($data, "public/baocao8.xlsx");
    }
}
