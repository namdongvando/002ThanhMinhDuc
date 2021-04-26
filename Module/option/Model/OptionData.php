<?php

namespace Module\option\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class OptionData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "options";
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

    function GetAll2Option($groups = null, $array = null) {
        if ($groups) {
            $where = " `Groups` = '{$groups}'  ORDER BY `OrderBy` ASC";
        } else {
            $where = " 1=1 ORDER BY `OrderBy` ASC";
        }
        if ($array == null)
            return $this->getColumnsOption(["Code", "Name"], $where);
        return $this->getColumnsOption($array, $where);
    }

    function GetAll2OptionId($groups = null, $array = null) {
        if ($groups) {
            $where = " `Groups` = '{$groups}'  ORDER BY `OrderBy` ASC";
        } else {
            $where = " 1=1 ORDER BY `OrderBy` ASC";
        }
        if ($array == null)
            return $this->getColumnsOption(["Id", "Name"], $where);
        return $this->getColumnsOption($array, $where);
    }

}
?>

