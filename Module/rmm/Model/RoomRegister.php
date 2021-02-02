<?php

namespace Module\rmm\Model;

class RoomRegister extends RoomRegisterData {

    public
            $Id,
            $Code,
            $Name,
            $UserId,
            $Groups,
            $NumberPerson,
            $OrderBy,
            $StartTime,
            $EndTime;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->RoomById($dv);
            }
            $this->$Id = $dvp["Id"];
            $this->$Code = $dvp["Code"];
            $this->$Name = $dvp["Name"];
            $this->$UserId = $dvp["UserId"];
            $this->$Groups = $dvp["Groups"];
            $this->$NumberPerson = $dvp["NumberPerson"];
            $this->$OrderBy = $dvp["OrderBy"];
            $this->$StartTime = $dvp["StartTime"];
            $this->$EndTime = $dvp["EndTime"];
        }
    }

    function ToArray() {
        return [
            "Id" => $this->Id,
            "Code" => $this->Code,
            "Name" => $this->Name,
            "UserId" => $this->UserId,
            "Groups" => $this->Groups,
            "SoNguoiHop" => $this->NumberPerson,
            "OrderBy" => $this->OrderBy,
            "StartTime" => $this->StartTime,
            "EndTime" => $this->EndTime,
        ];
    }

}
?>

