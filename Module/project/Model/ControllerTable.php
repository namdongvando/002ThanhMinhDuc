<?php

namespace Module\project\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Select;

class ControllerTable extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "project_controller";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function GetAll() {
        return $this->GetRows();
    }

    public function GetById($id) {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }

    public function GetByName($name) {
        return $this->GetRowsTableByName($name);
    }

    public function InsertSubmit($model) {
        if ($this->PreInsert($model["PId"]))
            return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {
        return $this->UpdateRowTable($model);
    }

    public function DeleteSubmit($id) {
        if ($this->CanDelete($id))
            return $this->DeleteRowById($id);
    }

    public function PreDelete($id = null) {
        $ControllerData = new ControllerData();
        return $ControllerData->GetDataByController($id) == null;
    }

    function GetAll2Option($groups = null) {
        if ($groups) {
            $where = " `Groups` = '{$groups}' ";
        } else {
            $where = " 1=1";
        }
        return $this->getColumnsOption(["Id", "Code", "Name"], $where);
    }

    public function PreInsert($id) {
        $proj = new Project();
        $a = new Project($proj->GetById($id));
        return $a->TongControler() < $a->MaxNumberController;
    }

}
