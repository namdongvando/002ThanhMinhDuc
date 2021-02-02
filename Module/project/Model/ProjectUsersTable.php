<?php

namespace Module\project\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Select;

class ProjectUsersTable extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "project_users";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function GetAll() {
        return $this->GetRows("1=1 Group By `Pid` ");
    }

    public function GetById($id) {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }

    public function GetByProjectId($id = null) {
        if ($id == NULL)
            $id = Project::GetCurentProject(true)->Id;
        return $this->GetRows("`PId` = '{$id}'");
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

    public function DeleteProjecUser($PId, $AdminId) {
        $where = " `Pid`='{$PId}' and `AdminId` = '{$AdminId}'";
        return $this->DeleteRowByWhere($where);
    }

    function GetAll2Option() {
        $where = " 1=1";
        return $this->getColumnsOption(["Id", "Name"], $where);
    }

}
