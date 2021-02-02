<?php

namespace Module\project\Model;

class ProjectUsers extends ProjectUsersTable {

    public $Id;
    public $Name;
    public $Address;
    public $Phone;
    public $Email;

    const CurentProject = "CurentProject";

    function __construct($user = null) {
        parent::__construct();
        if ($user) {
            $this->Id = !empty($user["Id"]) ? $user["Id"] : null;
            $this->Pid = !empty($user["Pid"]) ? $user["Pid"] : null;
            $this->AdminId = !empty($user["AdminId"]) ? $user["AdminId"] : null;
            $this->Active = !empty($user["Active"]) ? $user["Active"] : null;
            $this->DateCreate = !empty($user["DateCreate"]) ? $user["DateCreate"] : null;
        }
    }

    public function GetByUserId($id = null) {
        $a = \Module\user\Model\Admin::getCurentUser(true);
        if ($id == NULL)
            $id = $a->Id;
        //SELECT * FROM `genco_project_users` WHERE `AdminId` = 2 GROUP by PId
        return $this->GetRows("`AdminId` = '{$id}' Group by `PId`");
    }

    public function GetByProjectIdUser($pid = null, $aid = null) {

        $a = \Module\user\Model\Admin::getCurentUser(true);
        if ($aid == NULL)
            $aid = $a->Id;
        $a = Project::GetCurentProject(true);
        if ($pid == NULL)
            $pid = $a->Id;
        return $this->GetRowByWhere("`AdminId` = '{$aid}' and `PId` = '{$pid}'");
    }

}
