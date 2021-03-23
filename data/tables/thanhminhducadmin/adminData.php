<?php

namespace data\tables\thanhminhducadmin;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class adminData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "admin";
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
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {
        return $this->UpdateRowTable($model);
    }

    public function DeleteSubmit($id) {
        return $this->DeleteRowById($id);
    }

}
?>

