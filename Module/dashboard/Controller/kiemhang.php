<?php

namespace Module\dashboard\Controller;

use Common\Alert;
use Common\Common;
use Exception;
use Module\sanpham\Model\FormKiemHang;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\SanPhamForm;
use Module\sanpham\Model\SanPhamKiemHang;
use Module\sanpham\Model\TemSanPham;

class kiemhang extends \ApplicationM
{

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    const funName = "kiemhang_";

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
                if ($NhanVienKyThuat == null) {
                    throw new \Exception("Không có thông tin nhân viên");
                }
                if ($MaDaiLy == null || $MaDaiLy == "all") {
                    throw new \Exception("Không có thông tin đại lý::{$MaDaiLy}");
                }
                $sanphamPost = $_POST[SanPhamForm::formName];

                $op = new \Module\option\Model\Option($MaDanhMuc);
                $admin = \Module\user\Model\Admin::getCurentUser(true);
                $CodeQr = new \Model\CodeQR($admin->Username);
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
                        $model_Tem["Status"] = TemSanPham::DeActive;
                        $tenSp->UpdateSubmit($model_Tem);
                    }
                }
            } catch (\Exception $exc) {
                echo $exc->getMessage();

            }
        }
        return $this->ViewThemeModlue([], null);
    }

    function scan()
    {
        return $this->ViewThemeModlue([], null);
    }
    function detail()
    {
        if (isset($_POST[FormKiemHang::FormName])) {
            try {
                $formData = $_POST[FormKiemHang::FormName];
                $maTem = new TemSanPham($formData["MaTem"]);
                $kihang = new SanPhamKiemHang();
                $admin = \Module\user\Model\Admin::getCurentUser(true);
                $maTem->KiemHang($formData["Status"], $formData["Content"]);
                // $p["Name"] = $admin->Name;
                // $p["MaSanPham"] = $formData["MaSanPham"];
                // $p["MaTem"] = $formData["MaTem"];
                // $p["UserId"] = $admin->Id;
                // $p["Status"] = $formData["Status"];
                // $p["Content"] = $formData["Content"];
                // $kihang->InsertSubmit($p);

                new Alert(["success", "Đã cập nhật thành công"]);
                Common::toUrl();
            } catch (Exception $th) {
                //throw $th;
            }

        }
        return $this->ViewThemeModlue([], null);
    }

    function kiemhang()
    {

        return $this->ViewThemeModlue();
    }

    function savecode()
    {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR(self::funName . $user);
        $code->SaveCode($this->getParam()[0]);
        $a = $code->GetCodes();
    }

    function clear()
    {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR(self::funName . $user);
        $code->clearCode();
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    function coderefesh()
    {
        header('Content-Type: application/json');
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR(self::funName . $admin->Username);
        $ds = $CodeQr->GetCodes();
        $str = sha1(json_encode($ds));
        echo json_encode(["code" => $str]);
    }

    function danhsachtem()
    {
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR(self::funName . $admin->Username);
        $ds = $CodeQr->GetCodes();
        $index = 0;
        foreach ($ds as $k => $code) {
            $temSP = new \Module\sanpham\Model\TemSanPham($code);

            ?>
            <tr>
                <td>
                    <a class="btn btn-primary">Chọn</a>
                </td>
                <td>
                    <?php echo 1 + $index++; ?>
                </td>
                <td>
                    <?php echo $temSP->Code; ?>
                </td>
                <td>
                    <p style="margin: 0px;">
                        <b>Tên Sản Phẩm:</b>
                        <?php echo $temSP->SanPham()->Name; ?>
                    </p>
                    <p style="margin: 0px;">
                        <b>Tình Trạng:</b>
                        <?php echo $temSP->SanPham()->TinhTrang(); ?>
                    </p>
                    <p style="margin: 0px;">
                        <b>Đại Lý:</b>
                        <?php echo $temSP->SanPham()->DaiLy()->Name; ?>
                    </p>
                </td>
            </tr>
            <?php
        }
    }
}
?>