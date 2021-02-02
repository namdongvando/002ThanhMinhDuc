<?php

namespace Module\project\Model;

class Controller extends ControllerTable {

    public $Id,
            $Name,
            $PId,
            $Lat,
            $Lon,
            $Ip,
            $Username,
            $Password;

    function __construct($user = null) {
        parent::__construct();
        if ($user) {
            $this->Id = !empty($user["Id"]) ? $user["Id"] : null;
            $this->Name = !empty($user["Name"]) ? $user["Name"] : null;
            $this->PId = !empty($user["PId"]) ? $user["PId"] : null;
            $this->Lat = !empty($user["Lat"]) ? $user["Lat"] : null;
            $this->Lon = !empty($user["Lon"]) ? $user["Lon"] : null;
            $this->Ip = !empty($user["Ip"]) ? $user["Ip"] : null;
            $this->Username = !empty($user["Username"]) ? $user["Username"] : null;
            $this->Password = !empty($user["Password"]) ? $user["Password"] : null;
        }
    }

    public function GetControllerByProject($param0) {
        $where = "`PId` = '{$param0}'";
        return $this->GetRowsTableByWhere($where);
    }

    public function GetIdControllerByProject($param0) {
        $where = "`PId` = '{$param0}'";
        return $this->getArrayBy1Columns(["Id"], $where);
    }

    function CodeId($id = null) {
        if ($id == null)
            $id = $this->Id;
        $dataToken = [
            "Id" => $id
            , "Name" => $this->Name
            , "Username" => $this->Username
            , "Password" => $this->Password
        ];
        return base64_encode(json_encode($dataToken));
    }

    function TokenDecode($str) {
        return json_decode(base64_decode($str));
    }

    public function CanDelete() {
        return parent::PreDelete($this->Id);
    }

    public function CanInsert($Pid = null) {
        if ($Pid == null)
            $Pid = $this->PId;
        return parent::PreInsert($Pid);
    }

}
