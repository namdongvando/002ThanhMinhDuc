<?php

namespace Module\project\Model;

class Project extends ProjectTable {

    public $Id;
    public $Name;
    public $Address;
    public $Phone;
    public $Email;
    public $Active;

    const CurentProject = "CurentProject";
    const EditProject = "EditProject";
    const IsXoa = -1;
    const IsKhoa = 0;
    const IsActive = 1;

    /**
     * số controller tối đa
     * @param {type} parameter
     */
    public $MaxNumberController;

    function __construct($user = null) {
        parent::__construct();

        if ($user) {
            if (!is_array($user)) {
                $user = $this->GetById($user);
            }
            $this->Id = !empty($user["Id"]) ? $user["Id"] : null;
            $this->Name = !empty($user["Name"]) ? $user["Name"] : null;
            $this->Address = !empty($user["Address"]) ? $user["Address"] : null;
            $this->Phone = !empty($user["Phone"]) ? $user["Phone"] : null;
            $this->Email = !empty($user["Email"]) ? $user["Email"] : null;
            $this->Active = !empty($user["Active"]) ? $user["Active"] : self::IsKhoa;
            $this->MaxNumberController = !empty($user["MaxNumberController"]) ? $user["MaxNumberController"] : 5;
        }
    }

    public static function SetCurentProject($param0) {
        $p = new Project();
        $project = $p->GetById($param0);
        if ($project) {
            $_SESSION[self::CurentProject] = $project;
        }
    }

    public static function SetEditProject($param0) {
        $p = new Project();
        $project = $p->GetById($param0);
        if ($project) {
            $_SESSION[self::EditProject] = $project;
        }
    }

    public static function GetEditProject($isobj) {
        if (isset($_SESSION[self::EditProject])) {
            if ($isobj)
                return new Project($_SESSION[self::EditProject]);
            else
                return $_SESSION[self::EditProject];
        }
        return null;
    }

    public static function GetCurentProject($isobj = false) {
        if (isset($_SESSION[self::CurentProject])) {
            if ($isobj)
                return new Project($_SESSION[self::CurentProject]);
            else
                return $_SESSION[self::CurentProject];
        }
        return null;
    }

    public function Controllers() {
        $Controller = new \Module\project\Model\Controller();
        $Controllers = $Controller->GetControllerByProject($this->Id);
        return $Controllers;
    }

    public function GetControllersId() {
        $Controller = new \Module\project\Model\Controller();
        $IdControllers = $Controller->GetIdControllerByProject($this->Id);
        return $IdControllers;
    }

    public static function DecodeData($param0) {

        $param0 = str_replace("%2F", "/", $param0);
        return json_decode(base64_decode($param0));
    }

    public function EncodeData() {
        $a["Id"] = $this->Id;
        $a["Email"] = $this->Email;
        $a["Name"] = $this->Name;
        $a["Phone"] = $this->Phone;
        $a["Active"] = $this->Active;
        $string = json_encode($a, JSON_UNESCAPED_UNICODE);
        $string = str_replace("/", "%2F", $string);
        return base64_encode($string);
    }

    public function ProjecViewModel() {
        $a["Id"] = $this->EncodeData();
        $a["Email"] = $this->Email;
        $a["Name"] = $this->Name;
        $a["Phone"] = $this->Phone;
        $a["Address"] = $this->Address;
        $a["Active"] = $this->Active;
        $a["token"] = $this->EncodeData();
        return $a;
    }

    /**
     * lấy thông tin của project va user
     * @param {type} parameter
     */
    public function GetProjectUser() {
        $JU = new ProjectUsers();
        return $JU->GetByProjectIdUser();
    }

    public function TongKhachHang() {
        $ControllerIds = $this->GetCurentProject(true)->GetControllersId();
        $ControllData = new ControllerData();
        $Tong = $ControllData->TongControllerData($ControllerIds);
        return $Tong;
//        $ProjecUsre = new Projec
    }

    public function GetControllersArrayId($ControllerIds) {
        $ControllerIdsStr = implode(",", $ControllerIds);
        $where = " `ControllerId` in ({$ControllerIdsStr}) ";
        $a = $this->GetRows($where);
    }

    public function TongControler() {
        $ControllerIds = $this->GetControllersId();
        return count($ControllerIds);
    }

    public function CanInsertController() {
        $Controller = new Controller();
        return $Controller->CanInsert($this->Id);
    }

    /**
     * Xóa project
     * @param {type} parameter
     */
    public function DeleteProject($id) {
        $Project = $this->GetById($id);
        $Project["Active"] = self::IsXoa;
        $where = "`Id` = '{$id}'";
        return $this->UpdateRowTable($Project, $where);
    }

    public function Status() {
        $Lisstatus[self::IsXoa] = "Xóa";
        $Lisstatus[self::IsKhoa] = "Khóa";
        $Lisstatus[self::IsActive] = "Hoạt Động";
        return $Lisstatus[$this->Active];
    }

    public function KhoaDuAn() {
        $id = $this->Id;
        $Project = $this->GetById($id);
        if ($this->Active == self::IsKhoa)
            $Project["Active"] = self::IsActive;

        if ($this->Active == self::IsActive)
            $Project["Active"] = self::IsKhoa;
        $where = "`Id` = '{$id}'";
        return $this->UpdateRowTable($Project, $where);
    }

}
