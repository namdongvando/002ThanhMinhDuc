<?php

namespace datatable;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use lib\io;

class ZendData {

    private static $TableName;
    private static $Adapter;
    private $TableContext;
    public static $IsDebug;

    public function __construct($TableName = null) {
        if ($TableName) {
            self::$TableName = $TableName;
            $this->setTableGateway($TableName);
//            if ($this->TableContext == null) {
//                self::$TableName = $TableName;
//                $this->setTableGateway($TableName);
//            } else {
//                if (self::$TableName != $TableName) {
//                    $this->setTableGateway($TableName);
//                }
//            }
        }
    }

    function Connect() {
        global $INI;
        if (!self::$Adapter) {
            self::$Adapter = new Adapter([
                "driver" => "Pdo_Mysql"
                , "database" => $INI['DBname']
                , "username" => $INI['username']
                , "password" => $INI['password']
                , "hostname" => $INI['host']
                , "charset" => "utf8"
            ]);
            return self::$Adapter;
        }
        return self::$Adapter;
    }

    function setTableGateway($TableName, $id = null) {
        if ($id == null) {
            $this->TableContext = new TableGateway($TableName, $this->Connect());
        } else {
            $this->TableContext = new TableGateway($TableName, $this->Connect(), new \Zend\Db\TableGateway\Feature($id));
        }
        self::$TableName = $TableName;
    }

    function getSql() {
//
//        return $this->TableContext->getSql();
    }

    function GetRowTableById($id) {
        return (array) $this->fechRow($this->TableContext->select("`Id` = '{$id}'"));
    }

    function GetNumberRows($where) {
        return $this->TableContext->select($where)->count();
    }

    function GetRows($where = "") {
        if ($where)
            return (array) $this->fechArray($this->TableContext->select($where));
        return (array) $this->fechArray($this->TableContext->select());
    }

    function GetRowsNumber($where = null) {
        if (self::$IsDebug) {
//            $this->TableContext->select($where);
//            echo $this->getSql();
        }
        if ($where) {
            $res = $this->fechArray($this->TableContext->select($where));
            if ($res)
                return count($res);
            return 0;
        }
        $res = $this->fechArray($this->TableContext->select());
        if ($res)
            return count($res);
        return 0;
    }

    function getRowsColumnsByWhere($columns = [], $where = "") {
        $c = $columns;
        $select = new Select();
        $select->from(self::$TableName);
        $select->columns($c);
        if ($where)
            $select->where($where);
        $a = (array) $this->fechArray($this->TableContext->selectWith($select));
        return $a;
    }

    /**
     * lấy về 1 dòng
     * @param {type} parameter
     */
    function GetRowByWhere($where) {
        return (array) $this->fechRow($this->TableContext->select($where));
    }

    /**
     * lấy nhiều dong theo điều kiện
     * @param {type} parameter
     */
    function GetRowsByWhere($where) {

        return (array) $this->fechArray($this->TableContext->select($where));
    }

    function GetRowsTableByWhere($where) {

        return (array) $this->fechArray($this->TableContext->select($where));
    }

    function GetRowsTableByName($name) {
        return $this->fechArray($this->TableContext->select("`Name` like '%{$name}%'"));
    }

    function InsertRowsTable($row) {
        $this->TableContext->insert($row);
        return $this->TableContext->lastInsertValue;
    }

    function InsertRowsArrayTable($rows) {
//        var_dump($rows);
        foreach ($rows as $k => $v) {
            $where = "`Col0` = '{$v['Col0']}' and `ControllerId` = '{$v['ControllerId']}'";
            $a = $this->GetRowByWhere($where);
            if (!$a) {
                $this->TableContext->insert($v);
            }
        }

        return $this->TableContext->lastInsertValue;
    }

    function runsql($sql) {
        return $this->Connect()->query($sql, Adapter::QUERY_MODE_EXECUTE);
    }

    function runsqlToArray($sql) {
        return $this->fechArray($this->Connect()->query($sql, Adapter::QUERY_MODE_EXECUTE));
    }

    function UpdateRowTable($row, $where = null) {
        if ($where == null) {
            $where = "`Id` = '{$row["Id"]}'";
            unset($row["Id"]);
        }
        return $this->TableContext->update($row, $where);
    }

    function GetRowsTable() {
        return $this->fechArray($this->TableContext->select());
    }

    function GetRowsTablePt($where, $indexPage, $numberPage, &$total) {
        $indexPage = ($indexPage - 1) * $numberPage;
        $indexPage = max(0, $indexPage);
        $total = $this->GetNumberRows($where);
        return $this->fechArray($this->TableContext->select($where));
    }

    function DeleteRowById($id, $maHoa = false) {
        if ($maHoa) {
            return $this->TableContext->delete("sha1(`Id`) = '{$id}'");
        }
        return $this->TableContext->delete("`Id` = '{$id}'");
    }

    function DeleteRowByWhere($where) {
        return $this->TableContext->delete($where);
    }

    function fechArray($rowset) {
        return $rowset->toArray();
    }

    function fechRow($rowset) {
        return (array) $rowset->current();
    }

    function getArrayBy1Columns($columns = [], $where = "") {
        $c[0] = $columns[0];
        $select = new Select();
        $select->from(self::$TableName);
        $select->columns($c);
        if ($where)
            $select->where($where);
        $a = (array) $this->fechArray($this->TableContext->selectWith($select));
        $b = [];

        foreach ($a as $key => $value) {
            $b[] = $value[$c[0]];
        }
        return $b;
    }

    function getColumnsOption($columns = [], $where = "") {
        $select = new Select();
        $select->from(self::$TableName);
        $select->columns($columns);
        if ($where)
            $select->where($where);
        $a = (array) $this->fechArray($this->TableContext->selectWith($select));
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

    public function DeleteRowByListId($value) {
        if (is_array($value)) {
            $value = implode("','", $value);
        }
        echo $where = "`Id` in ('{$value}')";
        return $this->TableContext->delete($where);
    }

    function SaveLogDb() {
        $io = new io();
    }

}

?>