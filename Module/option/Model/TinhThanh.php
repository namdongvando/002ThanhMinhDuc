<?php

namespace Module\option\Model;

class TinhThanh extends TinhThanhData {

    public
            $Id,
            $Name,
            $FullName,
            $Alias,
            $IdP,
            $isShow,
            $Note,
            $PostCode;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            } 
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->FullName = $dv["FullName"];
            $this->Alias = $dv["Alias"];
            $this->IdP = $dv["IdP"];
            $this->isShow = $dv["isShow"];
            $this->Note = $dv["Note"];
            $this->PostCode = $dv["PostCode"];
        }
    }

}
?>

