<?php

namespace Module\rmm\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class RoomRegisterData extends \datatable\ZendData implements \Model\IModel {

    public function __construct($dv = null) {
        $this->TableName = table_prefix . "room_register";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function DeleteSubmit($id) {
        return $this->DeleteRowById($id);
    }

    public function GetAll() {
        return $this->GetRows();
    }

    public function GetById($id) {
        return $this->GetRowTableById($id);
    }

    public function GetByName($name) {
        $where = " `Name` like '%$name%' ";
        return $this->GetRowsTableByWhere($where);
    }

    public function InsertSubmit($model) {
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {
        return $this->UpdateRowTable($model);
    }

}
?>

