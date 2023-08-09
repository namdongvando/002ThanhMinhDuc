<?php

namespace Module\user\Model;

class userGroups extends userGroupsTable {

    const DoiTac = 2;
    const Admin = 1;
    const SupperAdmin = -1;
    const DaiLy = 3;
    const TrungTamBaoHanh = 4;
    const NVKT = 5;
    const KinhDoanh = 6;

    public $Id;
    public $Name;
    public $Note;
    public $Role;
    public $GroupsId;

    function __construct($u = null) {
        parent::__construct();
        if ($u) {
            $this->Id = !empty($u["Id"]) ? $u["Id"] : "";
            $this->Name = !empty($u["Name"]) ? $u["Name"] : "";
            $this->Note = !empty($u["Note"]) ? $u["Note"] : "";
            $this->Role = !empty($u["Username"]) ? $u["Username"] : "";
            $this->GroupsId = !empty($u["GroupsId"]) ? $u["GroupsId"] : "";
        }
    }

    function GetAll2Option() {
        $where = " `GroupsId` >= 0 order by `GroupsId`";
        return $this->getColumnsOption(["GroupsId", "Name"], $where);
    }

    function GetByGroupsId($id) {
        $where = " `GroupsId` = '{$id}'";
        return $this->ToRow($this->Select($where));
    }

}
?>

