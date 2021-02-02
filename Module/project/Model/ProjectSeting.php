<?php

namespace Module\project\Model;

/**
 * Description of ProjecctSeting
 *
 * @author MSI
 */
class ProjectSeting extends ProjectSetingTable {

    public $Id;
    public $Name;
    public $PId;
    public $Keyword;
    public $TextValues;
    public $UUID;

    public function __construct($ps = null) {
        parent::__construct();
        if ($ps) {
            $this->Id = $ps["Id"];
            $this->Name = $ps["Name"];
            $this->PId = $ps["PId"];
            $this->Keyword = $ps["Keyword"];
            $this->TextValues = $ps["TextValues"];
            $this->UUID = $ps["UUID"];
        }
    }

    function ToArray() {
        $ps["Id"] = $this->Id;
        $ps["Name"] = $this->Name;
        $ps["PId"] = $this->PId;
        $ps["Keyword"] = $this->Keyword;
        $ps["TextValues"] = htmlspecialchars_decode($this->TextValues);
        $ps["UUID"] = $this->UUIDs;
    }

    public function createProjectSeting($Name, $PId, $Keyword, $Values) {
        $ProjecSeting["Name"] = htmlspecialchars($Name);
        $ProjecSeting["PId"] = $PId;
        $ProjecSeting["Keyword"] = $Keyword;
        $ProjecSeting["TextValues"] = htmlspecialchars($Values);
        $ProjecSeting["UUID"] = \Application\UUID::v4();
        return $this->InsertSubmit($ProjecSeting);
    }

    public function UpdateProjectSeting($PS) {
        return $this->UpdateSubmit($PS);
    }

    public function GetProjectSetingByKeyPid($key, $pid) {
        $where = "`Keyword` = '{$key}' and `PId` = '{$pid}' ";
        return $this->GetRowByWhere($where);
    }

}
