<?php

namespace Module\user\Model;

class Admin extends AdminTable
{

    public $Id;
    public $Username;
    public $Password;
    public $Random;
    public $Name;
    public $Email;
    public $Phone;
    public $Address;
    public $Note;
    public $Groups;
    public $Active;

    const tableName = table_prefix . "admin";
    const Admin = 1;
    const SuperAdmin = -1;
    const Customer = 2;
    const DaiLy = 3;
    const TTBH = 4;
    const NVKT = 5;

    function __construct($NhanVien = NULL)
    {
        parent::__construct();
        if (!is_array($NhanVien)) {
            $id = $NhanVien;
            $NhanVien = $this->GetById($id);
            if ($NhanVien == null) {
                $NhanVien = $this->getUserByUsername($id);
            }
        }
        $this->Id = $NhanVien['Id'] ?? null;
        $this->Username = $NhanVien['Username'] ?? null;
        $this->Password = $NhanVien['Password'] ?? null;
        $this->Random = $NhanVien['Random'] ?? null;
        $this->Name = $NhanVien['Name'] ?? null;
        $this->Email = $NhanVien['Email'] ?? null;
        $this->Phone = $NhanVien['Phone'] ?? null;
        $this->Address = $NhanVien['Address'] ?? null;
        $this->Note = $NhanVien['Note'] ?? null;
        $this->Groups = $NhanVien['Groups'] ?? null;
        $this->Active = $NhanVien['Active'] ?? null;
    }

    function CheckLogin($Username, $Password)
    {
        return $this->userByUsernamePassword($Username, $Password);
        //        return $this->getUserByUsernamePassword($Username, $Password);
    }

    function createrPassword($p, $r)
    {
        return sha1($p . $r);
    }

    public static function getCurentUser($obj = false)
    {

        if (isset($_SESSION[QuanTri])) {
            if (!$obj)
                return $_SESSION[QuanTri];
            return new Admin($_SESSION[QuanTri]);
        }
        return NULL;
    }

    public static function setCurentUser($User)
    {
        $_SESSION[QuanTri] = $User;
    }

    public static function IsLogin()
    {
        if (!isset($_SESSION[QuanTri])) {
            return FALSE;
        }
        if (empty($_SESSION[QuanTri])) {
            return FALSE;
        }
        return True;
    }

    public static function Logout()
    {
        unset($_SESSION[QuanTri]);

        \Common\Common::toUrl("/dashboard/");
    }

    function updateUserInfor($user)
    {
        return $this->Update($user, "`Username` = '{$user["Username"]}'");
    }

    public function getUserByUsername($Username)
    {
        return $this->ToRow($this->Select("`Username` = '{$Username}'"));
    }
    public function getUserById($Id)
    {
        return $this->ToRow($this->Select("`Id` = '{$Id}'"));
    }

    function GetAll2Option()
    {
        $where = " 1=1";
        return $this->getColumnsOption(["Id", "Name"], $where);
    }

    public function Groups()
    {
        $Project = new userGroups();
        return new userGroups($Project->GetByGroupsId($this->Groups));
    }

    public function GetUserActive()
    {
        $active = AdminStatus::sActive;
        $Where = "`Active` = '{$active}' and `Groups` > 0";
        return $this->ToArray($this->Select($Where));
    }

    public function GetUserByGroups($group)
    {
        $active = AdminStatus::sActive;
        $Where = "`Active` = '{$active}' and `Groups` = '{$group}'";
        return $this->ToArray($this->Select($Where));
    }

    public function GetUserByActive($active)
    {
        $Where = "`Active` = '{$active}'";
        return $this->ToArray($this->Select($Where));
    }

    public function Active()
    {
        $ac = new AdminStatus();
        return $ac->GetById($this->Active, true);
    }

    public function publicKey()
    {
        return sha1($this->Username . $this->Email . $this->Id);
    }

    public function getUserByPublicKey($publicKey)
    {
        $Where = " SHA1(concat(`Username`,`Email`,`Id`)) = '{$publicKey}'";
        return $this->ToRow($this->Select($Where));
    }

    public function ResetPassword($Model)
    {
        $password = "zaq@123Abc";
        $Model["Password"] = $this->createrPassword($password, $Model["Random"]);
        $this->UpdateSubmit($Model);
        //        send mail
        return $password;
    }

    public function AdminViewModel()
    {
        $a["Id"] = $this->Id;

        $a["Name"] = $this->Name;
        $a["Email"] = $this->Email;
        $a["Address"] = $this->Address;
        $a["Groups"] = $this->Groups;
        $a["Phone"] = $this->Phone;
        $a["Active"] = $this->Active;
        return $a;
    }

    public function isAdmin()
    {
        return Admin::getCurentUser(true)->Groups()->GroupsId == self::Admin;
    }

    public function updatePasswordUser($User)
    {
        return $this->UpdateSubmit($User);
    }

    public function getUserByEmail($Email)
    {
        return $this->ToRow($this->Select("`Email` = '{$Email}'"));
    }

    public function CheckPassword($Password)
    {
        return $this->CheckLogin($this->Username, $Password);
    }

    public static function GetUsersOptions($groups = null)
    {
        $admin = new Admin();
        if ($groups) {
            $where = " `Groups` = '{$groups}' and `Active` = 1 ";
        } else {
            $where = "`Active` = 1";
        }
        $users = $admin->getColumnsOption(["Id", "Name"], $where);
        $admin = self::getCurentUser(true);
        foreach ($users as $key => $value) {
            if ($key == $admin->Id) {
                $users[$key] = "_Bạn_ | " . $value;
            }
        }
        return $users;
    }

    public static function GetUsersByGroups2Options($user = [])
    {
        $admin = new Admin();
        if ($user) {
            $users = implode(",", $user);
            $where = " `Groups` in ($users) ";
        } else {
            $where = " 1=1";
        }
        return $admin->getColumnsOption(["Id", "Name"], $where);
    }
 
    public function TrungTamBaoHanh()
    {
        $taiKhoan = new TaiKhoan();
        $danhSachTaiKhoan = $taiKhoan->GetByIdUser($this->Id, TaiKhoan::CodeTrungTamBaoHanh);
        if ($danhSachTaiKhoan) {
            return new TaiKhoan($danhSachTaiKhoan);
        }
        return new TaiKhoan();
    }

    public function KhachHang()
    {
        $taiKhoan = new TaiKhoan();
        $danhSachTaiKhoan = $taiKhoan->GetByIdUser($this->Id, TaiKhoan::CodeKhachHang);
        if ($danhSachTaiKhoan) {
            return new TaiKhoan($danhSachTaiKhoan);
        }
        return new TaiKhoan();
    }

    public static function CheckQuyen($nhom = [], $not = false)
    {
        $user = \Module\user\Model\Admin::getCurentUser(true)->Groups;
        if ($not == true) {
            return !in_array($user, $nhom);
        }
        return in_array($user, $nhom);
    }

    public function GetAllPT($name = "", $pagesIndex, $pageNumber, &$tong)
    {
        $superId = userGroups::SupperAdmin;
        $idGroupSql = " `Groups` != '$superId' and ";
        $where = "$idGroupSql `Active` >= 0 ";
        $ActiveSql = "";
        if (is_array($name)) {
            $Active = $name["Active"];
            if (!empty($Active)) {
                $Active = implode(",", $Active);
                $ActiveSql = "AND `Active` in ({$Active}) ";
            }
            $name = $name["keyword"];
        }
        if ($name != "") {
            $where = "$idGroupSql  (`Name` like '%{$name}%' or `Email` like '%{$name}%' or `Phone` like '%{$name}%') {$ActiveSql} ";
        }
        $pagesIndex = max($pagesIndex, 1);
        $pagesIndex = ($pagesIndex - 1) * $pageNumber;
        $Kh = new Admin();
        $tong = $Kh->GetRowsNumber($where);
        $where .= " limit {$pagesIndex},{$pageNumber}";
        return $Kh->GetRowsByWhere($where);
    }

    public function KhachHangs()
    {
        $ModelTaiKhoan = new TaiKhoan();
        return $ModelTaiKhoan->GetByKhachHangIdUser($this->Id);
    }
    public static function GetUserInfor($id)
    {
        $admin = new Admin();
        $userInfor = $admin->GetUserById($id);
        // var_dump($userInfor); 
        $userInfor = new Admin($userInfor);
        $userInfor = (array) $userInfor;
        $html = <<<HTML
            <table class="table table-border table-responsive">
                <tr>
                     <td>Tài Khoản</td>
                     <td>{$userInfor["Username"]}</td>
                </tr>
                <tr>
                     <td>SĐT</td>
                     <td>{$userInfor["Phone"]}</td>
                </tr>
                <tr>
                     <td>Email</td>
                     <td>{$userInfor["Email"]}</td>
                </tr>
                <tr>
                     <td>Họ & Tên</td>
                     <td>{$userInfor["Name"]}</td>
                </tr>
            </table>
HTML;
        return $html;
    }
}