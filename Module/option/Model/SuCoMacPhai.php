<?php

namespace Module\option\Model;

class SuCoMacPhai extends OptionData {

    const SuCoMacPhai = "SuCoMacPhai";

    public
            $Id,
            $Name,
            $Code,
            $Groups,
            $Note,
            $Parents,
            $OrderBy;

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $code = $dv;
                $dv = $this->GetById($dv);
                if (!$dv) {
                    $dv = $this->GetByCode($code);
                }
            }
            $this->Id = $dv["Id"];
            $this->Name = $dv["Name"];
            $this->Code = $dv["Code"];
            $this->Groups = $dv["Groups"];
            $this->Note = $dv["Note"];
            $this->Parents = $dv["Parents"];
            $this->OrderBy = $dv["OrderBy"];
        }
    }

    static function SuCoMacPhaiById($id) {
        $op = new Option();
        return $op->GetById($id);
    }

    public static function SuCoMacPhaiByCode($ModelYeuCau) {
        $op = new Option();
        $SuCoMacPhai = self::SuCoMacPhai;
        $where = "`Code` = '{$ModelYeuCau}' and `Groups` = '{$SuCoMacPhai}'";
        return $op->GetRowByWhere($where);
    }

}
?>

