<?php

namespace Module\user\Controller;

class api {

    public function __construct() {
        new \Controller\backend();
        echo " ";
        ob_start();
    }

    public function users() {
        flush();
        $Admin = new \Module\user\Model\Admin();
        \Module\user\Model\Admin::getCurentUser();
        $Admins = $Admin->GetAll();
        foreach ($Admins as $key => $value) {
            $Admins[$key] = $this->UserToApi($value);
        }
        echo \lib\APIs::Json_encode($Admins);
    }

    public function usersActive() {
        flush();
        $Admin = new \Module\user\Model\Admin();
        \Module\user\Model\Admin::getCurentUser();
        $Admins = $Admin->GetUserActive();
        foreach ($Admins as $key => $value) {
            $Admins[$key] = $this->UserToApi($value);
        }
        echo \lib\APIs::Json_encode($Admins);
    }

    public function usersLocked() {
        flush();
        $Admin = new \Module\user\Model\Admin();
        \Module\user\Model\Admin::getCurentUser();
        $Admins = $Admin->GetUserByActive(\Module\user\Model\AdminStatus::sMoiTao);
        foreach ($Admins as $key => $value) {
            $Admins[$key] = $this->UserToApi($value);
        }
        echo \lib\APIs::Json_encode($Admins);
    }

    public function usersDelete() {
        flush();
        $Admin = new \Module\user\Model\Admin();
        \Module\user\Model\Admin::getCurentUser();
        $Admins = $Admin->GetUserByActive(\Module\user\Model\AdminStatus::sXoa);
        foreach ($Admins as $key => $value) {
            $Admins[$key] = $this->UserToApi($value);
        }
        echo \lib\APIs::Json_encode($Admins);
    }

    public function UserToApi($value) {
        $Admin = new \Module\user\Model\Admin();
        $user = new \Module\user\Model\Admin($Admin->GetById($value["Id"]));
        $value["ProjectName"] = $user->Groups()->Name;
        $value["ActiveName"] = $user->Active()->Name;
        return $value;
    }

}
