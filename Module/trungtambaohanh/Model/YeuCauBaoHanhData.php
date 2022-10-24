<?php

namespace Module\trungtambaohanh\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class YeuCauBaoHanhData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "yeucaubaohanh";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews) {
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
        }
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
        $model["CreateDate"] = date(DateFomatDB, time());
        $model["UpdateDate"] = date(DateFomatDB, time());
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {
        $model["UpdateDate"] = date(DateFomatDB, time());
        return $this->UpdateRowTable($model);
    }

    public function DeleteSubmit($id) {
        return $this->DeleteRowById($id);
    }

}
