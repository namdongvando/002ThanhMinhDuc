<?php

namespace Module\user\Controller;

define("AppDir", "Module/user");
define("Token", "Token");
define("AppPath", "/Module/user");

class users extends \ApplicationM implements \Controller\IController {

    static public $UserLayout = "user";

    function __construct() {
        new \Controller\backend();
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
                if (strlen($user["Phone"]) > 10) {
                    throw new \Exception("Số Điện Thoại Quá Dài");
                }
                $user["Active"] = $_newUser["Active"];
                $user["Address"] = $_newUser["Address"];
                $user["Note"] = isset($_newUser["Note"]) ? $_newUser["Note"] : "";
                $user["Groups"] = $_newUser["Groups"];
                $user["Image"] = "";
                $ModelAdmin->InsertSubmit($user);
            } catch (\Exception $ex) {
                \Common\Alert::setAlert("danger", $ex->getMessage());
            }
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
        }
    }

    public function delete() {

    }

    public function detail() {

    }

    public function edit() {
        $admin = new \Module\user\Model\Admin();
        if (\Module\user\Model\AdminForm::onSubmit()) {
            $userPost = $_POST["users"];
            $User = $admin->GetById($userPost["Id"]);
            if ($User) {
                $User["Name"] = $userPost["Name"];
                $User["Phone"] = $userPost["Phone"];
                $User["Email"] = $userPost["Email"];
                $User["Address"] = $userPost["Address"];
                $User["Active"] = $userPost["Active"];
                $User["Groups"] = $userPost["Groups"];
                $admin->UpdateSubmit($User);
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
                exit();
            }
        }
        $id = $this->getParam()[0];
        $admin = $admin->GetById($id);
        return $this->ViewThemeModlue(["admin" => $admin]);
    }

    public function index() {

        return $this->ViewThemeModlue();
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
            echo $admin->ResetPassword($Model);
//        $Mail = new \Module\mail\Model\PHPMailerService();
//        $Mail->sendMail();
    }

}
?>

