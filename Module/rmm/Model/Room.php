<?php

namespace Module\rmm\Model;

class Room extends RoomData {

    public
            $Id,
            $Name,
            $Adreess,
            $MaxNumber,
            $Type,
            $Code,
            $Config;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->RoomById($dv);
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Type = $dv["Type"];
            $this->Code = $dv["Code"];
            $this->Adreess = $dv["Adreess"];
            $this->MaxNumber = $dv["MaxNumber"];
            $this->Config = $dv["Config"];
        }
    }

    function ToArray() {
        return [
            "Id" => $this->Id,
            "Name" => $this->Name,
            "Type" => $this->Type,
            "Code" => $this->Code,
            "Adreess" => $this->Adreess,
            "MaxNumber" => $this->MaxNumber,
            "Config" => $this->Config,
        ];
    }

    function Type() {
        $option = new Option();
        return new Option($option->GetById($this->Type));
    }

    /**
      Tìm Phong theo ID
     *
     * @param {type} parameter
     */
    public function RoomById($dv) {
        $where = "`Id` = '{$dv}'";
        return $this->GetRowByWhere($where);
    }

    function GetAll2Option($where = "") {
        return $this->getColumnsOption(["Id", "Name"], $where);
    }

    /**
     * get All Room
     * @param {type} parameter
     */
    public function Rooms() {
        return $this->GetRows();
    }

}
?>

