<?php

namespace Module\dashboard\Controller;

use Module\sanpham\Model\SanPhamForm;

class nhaptem extends \ApplicationM {

    const AppDir = "Module/dashboard";
    const AppPath = "/Module/dashboard";

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
    }

    function index() {

        if (isset($_POST["ChonDanhMucSanPham"])) {
            try {
                $temSanPham = new \Module\sanpham\Model\TemSanPham();
                $Chon = $_POST["Chon"];
                $MaDanhMuc = $Chon["MaDanhMuc"];
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
                        $SanPham->TinhTrang = $sanphamPost["TinhTrang"];
                        $SanPham->MaDaiLy = $sanphamPost["MaDaiLy"];
                        $SanPham->Code = $op->Code;
                        $SanPham->DanhMuc = $op->Code;
                        $SanPham->ChungLoaiSP = $op->Parents()->Code;
                        $SanPham->Mota = $op->Note;
                        $model = $SanPham->ToArray();
                        $SanPham->UpdateSubmit($model);
                    }
                }
            } catch (\Exception $exc) {
                echo $exc->getMessage();
            }
        }
        return $this->ViewThemeModlue([], null, "qr");
    }

    function scan() {
        return $this->ViewThemeModlue([], null, "qr");
    }

    function savecode() {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $code->SaveCode($this->getParam()[0]);
        $a = $code->GetCodes();
        var_dump($a);
    }

    function clear() {
        $user = "admin";
        if (\Module\user\Model\Admin::getCurentUser(false)) {
            $user = \Module\user\Model\Admin::getCurentUser(true)->Username;
        }
        $code = new \Model\CodeQR($user);
        $code->clearCode();
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    function coderefesh() {
        header('Content-Type: application/json');
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();
        $str = sha1(json_encode($ds));
        echo json_encode(["code" => $str]);
    }

    function danhsachtem() {
        $admin = \Module\user\Model\Admin::getCurentUser(true);
        $CodeQr = new \Model\CodeQR($admin->Username);
        $ds = $CodeQr->GetCodes();

        $index = 0;
        foreach ($ds as $k => $code) {
            $temSP = new \Module\sanpham\Model\TemSanPham($code);
            ?>
            <tr>
                <td><?php echo 1 + $index++; ?></td>
                <td><?php echo $temSP->Code; ?></td>
                <td>
                    <p style="margin: 0px;" ><?php echo $temSP->SanPham()->Name; ?></p>
                    <p style="margin: 0px;" ><?php echo $temSP->SanPham()->TinhTrang(); ?></p>
                    <p style="margin: 0px;" ><?php echo $temSP->SanPham()->DaiLy()->Name; ?></p>
                </td>
            </tr>
            <?php
        }
    }

}
?>

