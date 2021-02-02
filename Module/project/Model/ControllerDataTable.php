<?php

namespace Module\project\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Select;

class ControllerDataTable extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    public $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "project_controller_data";
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
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {
        return $this->UpdateRowTable($model);
    }

    public function DeleteSubmit($id) {

        return $this->DeleteRowById($id);
    }

    function GetAll2Option($groups = null) {
        if ($groups) {
            $where = " `Groups` = '{$groups}' ";
        } else {
            $where = " 1=1";
        }
        return $this->getColumnsOption(["Id", "Code", "Name"], $where);
    }

}
