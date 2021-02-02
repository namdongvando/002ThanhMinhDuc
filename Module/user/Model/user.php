<?php

namespace Module\user\Model;

class user extends userTable {

    public $Id;
    public $Name;
    public $Username;
    public $Email;
    public $Password;
    public $Code;
    public $Google2Fa;
    public $Active;
    private static $SESSIONQUANTRI = "SESSIONQUANTRI";

    function __construct($u = null) {
        parent::__construct();
        if ($u) {
            $this->Id = !empty($u["Id"]) ? $u["Id"] : "";
            $this->Name = !empty($u["Name"]) ? $u["Name"] : "";
            $this->Username = !empty($u["Username"]) ? $u["Username"] : "";
            $this->Email = !empty($u["Email"]) ? $u["Email"] : "";
            $this->Password = !empty($u["Password"]) ? $u["Password"] : "";
            $this->Code = !empty($u["Code"]) ? $u["Code"] : "";
            $this->Google2Fa = !empty($u["Google2Fa"]) ? $u["Google2Fa"] : "";
            $this->Active = !empty($u["Active"]) ? $u["Active"] : 0;
        }
    }

    function GetUser() {
        return $this->users();
    }

// kiểm tra đăng nhập
    static function CheckLogin($url) {
        if ($_SESSION[UserApp] == null) {
            header("Location: " . $url);
            exit();
        }
    }

    function getUserByUsername($username) {
        return $this->UserByUsername($username);
    }

    function getUserByEmail($email) {
        return $this->UserByEmail($email);
    }

    function CreateUser($user) {
        $this->Insert($user);
    }

    function setPassword($code, $password) {
        return sha1($code . $password);
    }

    function getPasswordByUser($Username, $password) {
        $u = $this->getUserByUsername($Username);
        if ($u) {
            return sha1($u["Code"] . $password);
        }
        return null;
    }

    function decodeUsername($username) {
        return sha1($username);
    }

    function setCurentUser($us) {
        $_SESSION[UserApp] = base64_encode(json_encode($us));
    }

    function getCurentUser() {
        return $_SESSION[UserApp];
    }

    function Login($username, $password) {
        $username = $this->decodeUsername($username);
        $password = $this->getPasswordByUser($username, $password);
        $user = $this->getUserByUsername($username);
        if ($user["Password"] == $password)
            $this->CurentUser($user);
        return $user["Password"] == $password;
    }

    public static function getCurentUserInfor($obj = false) {
        if (!isset($_SESSION[UserApp]))
            return null;
        if ($_SESSION[UserApp] == NULL)
            return null;
        if ($obj) {
//            $a = json_decode(base64_decode($_SESSION[UserApp]), JSON_OBJECT_AS_ARRAY);
            return new modeluser(json_decode(base64_decode($_SESSION[UserApp]), JSON_OBJECT_AS_ARRAY));
        }
        return json_decode(base64_decode($_SESSION[UserApp]), JSON_OBJECT_AS_ARRAY);
    }

    public static function CurentUser($a = null) {
        if ($a == null) {
            return $_SESSION[UserApp];
        } else {
            $_SESSION[UserApp] = base64_encode(json_encode($a));
        }
    }

    public static function logout() {
        unset($_SESSION[UserApp]);
    }

    function UserInfor() {
        $U = new userinfor();
        return new userinfor($U->getUserInforById($this->Id));
    }

}
?>

