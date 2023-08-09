<?php

namespace Module\user\Controller;

define("Token", "Token");

use Common\Common;
use Module\user\Model\AdminStatus;

class users extends \ApplicationM implements \Controller\IController {

    const AppDir = "Module/user";
    const AppPath = "/Module/user";

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
    }

    public function index() {

        return $this->ViewThemeModlue();
    }

    public function create() {

        if (\Module\user\Model\AdminForm::onSubmit()) {
            try {
                $ModelAdmin = new \Module\user\Model\Admin();

                $_newUser = $_POST["users"];
                $user["Username"] = $_newUser["Username"];
                $userold = $ModelAdmin->getUserByUsername($user["Username"]);
                if ($userold) {
                    throw new \Exception("Tài khoản đã được sử dụng");
                }
                $user["Random"] = \Application\UUID::v4();
                $user["Password"] = $ModelAdmin->createrPassword($_newUser["Password"], $user["Random"]);
                $user["Name"] = $_newUser["Name"];
                $user["Email"] = $_newUser["Email"];
                $userEmail = $ModelAdmin->getUserByEmail($user["Email"]);
                if ($userEmail) {
                    throw new \Exception("Email đã được sử dụng");
                }
                $user["Phone"] = $_newUser["Phone"];
                if (strlen($user["Phone"]) > 13) {
                    throw new \Exception("Số Điện Thoại Quá Dài");
                }
                $user["Active"] = $_newUser["Active"];
                $user["Address"] = $_newUser["Address"];
                $user["Note"] = isset($_newUser["Note"]) ? $_newUser["Note"] : "";
                $user["Groups"] = $_newUser["Groups"];
                $user["Image"] = "";
                $user["Parents"] = "";
                 
                $ModelAdmin->InsertSubmit($user);
                Common::toUrl("/user/users/");
            } catch (\Exception $ex) {
                \Common\Alert::setAlert("danger", $ex->getMessage());
            }
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
        }
    }

    public function delete() {
        $id = $this->getParam()[0];
        $admin = new \Module\user\Model\Admin();
        $User = $admin->GetById($id);
        if ($User) {
            $User["Active"] = AdminStatus::sXoa;
            $admin->updateUserInfor($User);
        }
        \Common\Common::toUrl();
    }

    public function detail() {

    }

    public function edit() {
        $admin = new \Module\user\Model\Admin();
        if (\Module\user\Model\AdminForm::onSubmit()) {
            $userPost = $_POST["users"];
            $taikhoanPost = $_POST["taikhoan"];
            $User = $admin->GetById($userPost["Id"]);
            if ($User) {
                $User["Name"] = $userPost["Name"];
                $User["Phone"] = $userPost["Phone"];
                $User["Email"] = $userPost["Email"];
                $User["Address"] = $userPost["Address"];
                $User["Active"] = $userPost["Active"];
                $User["Note"] = $userPost["Note"];
                $User["Groups"] = $userPost["Groups"];
                $admin->UpdateSubmit($User);
                $TaiKhoan = new \Module\user\Model\TaiKhoan();
                $TaiKhoanModel = $TaiKhoan->GetByIdUser($User["Id"], \Module\user\Model\TaiKhoan::CodeKhachHang);
//                var_dump($TaiKhoanModel);
                if ($TaiKhoanModel) {
                    $TaiKhoanModel["idKhachHang"] = $taikhoanPost["KhachHang"];
//                    var_dump($TaiKhoanModel);
                    $TaiKhoan->Put($TaiKhoanModel);
                }
                $TaiKhoanModel = $TaiKhoan->GetByIdUser($User["Id"], \Module\user\Model\TaiKhoan::CodeTrungTamBaoHanh);
                if ($TaiKhoanModel) {
                    $TaiKhoanModel["idKhachHang"] = $taikhoanPost["TrungTamBaoHang"];
                    var_dump($TaiKhoanModel);
                    $TaiKhoan->Put($TaiKhoanModel);
                }
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
                exit();
            }
        }
        $id = $this->getParam()[0];
        $admin = $admin->GetById($id);
        return $this->ViewThemeModlue(["admin" => $admin]);
    }

    public function import() {


        try {
            //        var_dump($_FILES["file"]);
            $file = $_FILES["file"];
            //        'name' => string 'Textimport.xlsx' (length = 15)
            //        'type' => string 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' (length = 65)
            //        'tmp_name' => string 'C:\wamp64\tmp\php92DC.tmp' (length = 25)
            //        'error' => int 0
            //        'size' => int 6210
            // doc file excell
            $DanhSach = \Module\excell\Model\excell\ExcelReader::ReadFile($file, ["Username", "Email", "Password", "Name", "Phone"]);
            foreach ($DanhSach as $rowuser) {
                $kt = true;
                $_newUser = $rowuser;
                var_dump($rowuser);
                $ModelAdmin = new \Module\user\Model\Admin();
                if ($_newUser["Username"] == null)
                    break;

                $user["Username"] = $_newUser["Username"];
                $userold = $ModelAdmin->getUserByUsername($user["Username"]);
                if ($userold) {
                    $kt = false;
                }
                $user["Random"] = \Application\UUID::v4();
                $user["Password"] = $ModelAdmin->createrPassword($_newUser["Password"], $user["Random"]);
                $user["Name"] = $_newUser["Name"];
                $user["Email"] = $_newUser["Email"];
                $userEmail = $ModelAdmin->getUserByEmail($user["Email"]);
                if ($userEmail) {
                    $kt = false;
                }
                $user["Phone"] = $_newUser["Phone"];
                $user["Active"] = 0;
                $user["Address"] = isset($_newUser["Address"]) ? $_newUser["Address"] : "";
                $user["Note"] = isset($_newUser["Note"]) ? $_newUser["Note"] : "";
                $user["Groups"] = isset($_newUser["Groups"]) ? $_newUser["Groups"] : 0;
                $user["Image"] = "";
                if ($kt)
                    $ModelAdmin->InsertSubmit($user);
            }
        } catch (Exception $ex) {

        }
        \Common\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

    public function resetpassword() {
        $publicKey = $_POST["publicKey"];
        $admin = new \Module\user\Model\Admin();
        $Model = $admin->getUserByPublicKey($publicKey);
        if ($Model)
            $admin->ResetPassword($Model);
    }

}
?>

