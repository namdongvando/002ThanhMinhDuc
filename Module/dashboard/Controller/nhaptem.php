<?php

namespace Module\dashboard\Controller;

use Common\Alert;
use Common\Common;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\TemSanPham;
use Module\sanpham\Model\XuatNhapKho\FormPhieuXuatNhap;
use Module\sanpham\Model\XuatNhapKho\PhieuXuatNhap;
use Module\user\Model\Admin;

class nhaptem extends \ApplicationM
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

        if (isset($_POST["ChonDanhMucSanPham"])) {
            try {
                $temSanPham = new \Module\sanpham\Model\TemSanPham();
                $Chon = $_POST["Chon"];
                $SanPham = $_POST["sanpham"];
                $MaDanhMuc = $Chon["MaDanhMuc"] ?? null;
                $MaDaiLy = $SanPham["MaDaiLy"] ?? null;
                $NhanVienKyThuat = $Chon["NhanVien"] ?? null;
                $NhanVienBanHang = $Chon["NhanVienBanHang"] ?? null;
                $LyDoXuatKho = $Chon["LyDoXuatKho"] ?? null;

                $Lydo = [
                    TemSanPham::KyGui => "KyGui",
                    TemSanPham::TrungBay => "TrungBay"
                ];
                $StatusLyDo = [
                    "KyGui" => TemSanPham::KyGui,
                    "TrungBay" => TemSanPham::TrungBay
                ];

                $TemSanPhamStatus = TemSanPham::DeActive;
                // 
                if (in_array($LyDoXuatKho, $Lydo)) {
                    $TemSanPhamStatus = $StatusLyDo[$LyDoXuatKho];
                } 
                if ($NhanVienKyThuat == null) {
                    throw new \Exception("Không có thông tin nhân viên");
                }
                if ($MaDaiLy == null || $MaDaiLy == "all") {
                    throw new \Exception("Chọn Thông tin đại lý");
                }
                $sanphamPost = $_POST[SanPhamForm::formName];

                $op = new \Module\option\Model\Option($MaDanhMuc);
                $admin = \Module\user\Model\Admin::getCurentUser(true);
                $CodeQr = new \Model\CodeQR($admin->Username);
               // danh sách tem 
                $ds = $CodeQr->GetCodes();
                if ($ds == false) {
                    throw new \Exception("Không có danh sách sản phẩm");
                }
                foreach ($ds as $value) {
                    $model_Tem = $temSanPham->GetByCode($value);
                    if ($model_Tem) {
                        $tenSp = new \Module\sanpham\Model\TemSanPham($value);
                        $MaSanPham = $tenSp->SanPham()->Id;
                        $SanPham = new \Module\sanpham\Model\SanPham($MaSanPham);
                        $SanPham->Name = $op->Name;
                        $SanPham->TinhTrang = SanPham::DangODaiLy;
                        $SanPham->MaDaiLy = $sanphamPost["MaDaiLy"];
                        $SanPham->Code = $op->Code;
                        $SanPham->DanhMuc = $op->Code;
                        $SanPham->ChungLoaiSP = $op->Parents()->Code;
                        $SanPham->Mota = $op->Note;
                        $model = $SanPham->ToArray();
                        $SanPham->UpdateSubmit($model);
                        $tenSp = new \Module\sanpham\Model\TemSanPham();
                        $model_Tem["UserId"] = $NhanVienKyThuat;
                        $model_Tem["Status"] = $TemSanPhamStatus;
                        $tenSp->UpdateSubmit($model_Tem);
                          
                    }
                }
                $PhieuXuatNhap = new PhieuXuatNhap();
                $PhieuXuatNhap->Code = time();
                $PhieuXuatNhap->Name = "Xuất Kho";
                $PhieuXuatNhap->NamePhieu = "PhieuXuatKho";
                $PhieuXuatNhap->Content = "";
                $PhieuXuatNhap->Type = PhieuXuatNhap::PhieuXuat;
                $PhieuXuatNhap->LyDo =  $LyDoXuatKho;
                $PhieuXuatNhap->UserId =  $NhanVienBanHang;
                $PhieuXuatNhap->KhacHang = $MaDaiLy;
                $PhieuXuatNhap->TaoPhieu($PhieuXuatNhap->ToArray(),$ds,$NhanVienBanHang);
                Common::toUrl();
            } catch (\Exception $exc) { 
                new Alert(["danger", $exc->getMessage()]); 
            }
        }
        return $this->ViewThemeModlue([], null);
    }

    function scan()
    {
        return $this->ViewThemeModlue([], null);
    }

    function savecode()
    {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $code->SaveCode($this->getParam()[0]);
        $a = $code->GetCodes();
        var_dump($a);
    }

    function clear()
    {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $code->clearCode();
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    function xuatkho()
    {
        return $this->ViewThemeModlue([], null);
    }
    function kygui()
    {
        $admin = Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();
        if (isset($_POST["KyGui"])) {
            if ($ds) {
                $tembaohanh = new TemSanPham();
                $tembaohanh->KichHoatTrangThai($_POST["Status"], $ds);
            } else {
                new Alert(["danger", "Không có sản phẩm"]);
            }
        }
        return $this->ViewThemeModlue([], null);
    }
    function doitra()
    {
        $admin = Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();
        if (isset($_POST["DoiTra"])) {
            $admin = Admin::getCurentUser(true);
            $CodeQr = new \Model\CodeQR($admin->Username);
            $ds = $CodeQr->GetCodes();
            if ($ds) {
                $dataPost = $_POST[FormPhieuXuatNhap::nameForm];
                $phieu = new PhieuXuatNhap();
                $postData["Code"] = $phieu->GetCode();
                $postData["Name"] = "Phiếu Đổi Trả";
                $postData["NamePhieu"] = "PhieuDoiTra";
                $postData["Content"] = $dataPost["Content"];
                $postData["DieuKienNhapKho"] = $dataPost["DieuKienNhapKho"];
                $postData["TinhTrangSanPham"] = $dataPost["TinhTrangSanPham"];
                $postData["LyDo"] = $dataPost["LyDo"];
                $postData["UserId"] = $admin->Id;
                $postData["KhacHang"] = "";
                $postData["Type"] = 1;
                $code = $phieu->TaoPhieu($postData, $ds);
                $CodeQr->clearCode();
                Common::toUrl("/dashboard/xuatnhapkho/detail/{$code}");

            }
            new Alert(["danger", "Chưa có sản phẩm"]);
        }
        return $this->ViewThemeModlue([], null);
    }
    function xuatkhodanhsachtem()
    {

        $admin = Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();
        if ($ds) {
            $phieu = new PhieuXuatNhap();
            $postData["Code"] = $phieu->GetCode();
            $postData["Name"] = "Phiếu xuất kho từ nhập tem";
            $postData["Content"] = "";
            $postData["UserId"] = $admin->Id;
            $postData["KhacHang"] = "";
            $postData["Type"] = -1;
            $code = $phieu->TaoPhieu($postData, $ds);
            $CodeQr->clearCode();
            Common::toUrl("/dashboard/xuatnhapkho/detail/{$code}");
        }
        Common::toUrl();
    }

    function xuatkhosanpham()
    {
        $code = $this->getParam()[0];
        return $this->ViewThemeModlue(["code" => $code], null);
    }

    function coderefesh()
    {
        header('Content-Type: application/json');
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();
        $str = sha1(json_encode($ds));
        echo json_encode(["code" => $str]);
    }

    function danhsachtem()
    {
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();

        $index = 0;
        foreach ($ds as $k => $code) {
            $temSP = new \Module\sanpham\Model\TemSanPham($code);
            ?>
            <tr>
                <td>
                    <?php echo 1 + $index++; ?>
                </td>
                <td>
                    <a class="btn btn-primary" href="/dashboard/workflow/temsanpham/<?php echo $temSP->Code; ?>/">
                        Chọn
                    </a>
                </td>
                <td>
                    <?php echo $temSP->Code; ?>
                </td>
                <td>
                    <p style="margin: 0px;">
                        <?php echo $temSP->SanPham()->Name; ?>
                    </p>
                    <p style="margin: 0px;">
                        <?php echo $temSP->SanPham()->TinhTrang(); ?>
                    </p>
                    <p style="margin: 0px;">
                        <?php echo $temSP->SanPham()->DaiLy()->Name; ?>
                    </p>
                </td>
            </tr>
            <?php
        }
    }
}