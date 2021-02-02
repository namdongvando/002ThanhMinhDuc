<?php

namespace Core;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;
use \Zend\Db\Sql\Select;

class DatabaseZend implements \Model\IModel {

    public $ConnetTable;
    private static $Conneted;
    private static $TableName;

    function Connect() {

        global $INI;
//        self::$_conn = mysqli_connect($INI['host'], $INI['username'], $INI['password'], $INI['DBname']) or mysqli_errno("Can't connect database");
//        mysqli_query(self::$_conn, "SET NAMES utf8"); // Chuyển dữ liệu trả về sang kiểu utf8
        if (!self::$Conneted) {
            self::$Conneted = new Adapter([
                "driver" => "Pdo_Mysql"
                , "database" => $INI['DBname']
                , "username" => $INI['username']
                , "password" => $INI['password']
                , "hostname" => $INI['host']
                , "post" => "8080"
                , "charset" => "utf8"
            ]);
        }
        return self::$Conneted;
    }

    function setConnetTable($tableName) {
        $this->ConnetTable = new TableGateway($tableName, $this->Connect());
        self::$TableName = $tableName;
    }

    function getColumnsOption($columns = [], $where = "") {
        $select = new Select();
        $select->from(self::$TableName);
        $select->columns($columns);
        if ($where)
            $select->where($where);
        $a = (array) $this->ToArray($this->ConnetTable->selectWith($select));
        $d = [];
        foreach ($a as $value) {
            if (isset($columns[2])) {
                $d[$value[$columns[0]]] = $value[$columns[1]] . " _ " . $value[$columns[2]];
            } else {
                $d[$value[$columns[0]]] = $value[$columns[1]];
            }
        }
        return $d;
    }

    function Query($sql) {
        return $this->Connect()->query($sql, Adapter::QUERY_MODE_EXECUTE);
    }

    function ToRow($res) {
        if ($res)
            return (array) $res->current();
        return null;
    }

    function getRowById($id) {
        $where = " `Id` = '{$id}' ";
        $row = $this->Select($where);
        if ($row)
            return $this->ToRow($row);
        return $row;
    }

    function ToArray($res) {
        return $res->toArray();
    }

    function Update($QA, $where = "") {
        if (!$where)
            $where = " `Id` = '{$QA["Id"]}' ";
        return $this->ConnetTable->update($QA, $where);
    }

    function Insert($QA) {
        return $this->ConnetTable->insert($QA);
    }

    function Delete($Id) {
        $where = " `Id` = '{$Id}' ";
        return $this->ConnetTable->delete($where);
    }

    function Select($Where = "") {
        if ($Where)
            return $this->ConnetTable->select($Where);
        return $this->ConnetTable->select();
    }

    public function DeleteSubmit($id) {
        return $this->Delete($id);
    }

    public function GetAll() {
        return $this->ToArray($this->Select());
    }

    public function GetById($id) {
        $where = "`Id` = '{$id}'";
        return $this->ToRow($this->Select($where));
    }

    public function GetByName($name) {
        $where = "`Name` = '{$name}'";
        return $this->ToRow($this->Select($where));
    }

    public function InsertSubmit($model) {
        return $this->Insert($model);
    }

    public function UpdateSubmit($model) {
        return $this->Update($model);
    }

}

?>
