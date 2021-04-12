<?php

namespace Module\option\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class TinhThanhData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "tinhthanh";
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

    public function GetByIdP($id) {
        $where = "`IdP` = '{$id}'";
        return $this->GetRowsByWhere($where);
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

    function GetAll2Option($groups = 0, $array = null) {
        $where = "`IdP` = '{$groups}' ";
        if ($array == null)
            return $this->getColumnsOption(["Id", "Name"], $where);
        return $this->getColumnsOption($array, $where);
    }

}
?>

