<?php

namespace Module\rmm\Model;

class Option extends OptionData {

    public
            $Id,
            $Name,
            $Code,
            $Groups,
            $OrderBy;

    public function __construct($dv = null) {
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->RoomById($dv);
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Code = $dv["Value"];
            $this->Groups = $dv["Groups"];
            $this->OrderBy = $dv["OrderBy"];
        }
        parent::__construct();
    }

}
?>

