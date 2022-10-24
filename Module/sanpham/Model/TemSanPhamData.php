<?php

namespace Module\sanpham\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class TemSanPhamData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private static $GetAll;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "tembaohanh";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function GetAll() {
        if (!self::$GetAll)
            self::$GetAll = $this->GetRows();
        return self::$GetAll;
    }

    public function GetAllPT($pagesIndex = 1, $number = 500, &$tong = 0) {
        $pagesIndex = max($pagesIndex, 1);
        $pagesIndex = $pagesIndex - 1;
        $pagesIndex = $pagesIndex * $number;
        $where = " 1=1 limit {$pagesIndex},{$number}";
        $tong = $this->GetNumberRows(" 1=1 ");
        return $this->GetRowsByWhere($where);
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

    public function DeleteSubmit($id, $isMD5 = false) {
        if ($isMD5)
            return $this->DeleteRowByWhere(" md5(`Id`) = '{$id}' ");
        return $this->DeleteRowById($id);
    }

    function GetAll2Option($where = null) {
        if ($where == null)
            $where = " 1=1";
        return $this->getColumnsOption(["Id", "Code", "Name"], $where);
    }

}
