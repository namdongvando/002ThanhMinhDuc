<?php

namespace Module\sanpham\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class SanPhamData extends \datatable\ZendData implements \Model\IModel
{

    private static $tableNews;
    private $TableName;

    public function __construct()
    {
        $this->TableName = table_prefix . "sanpham";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function GetAll()
    {
        return $this->GetRows();
    }

    public function GetById($id)
    {
        return $this->GetRowByWhere("`Id` = '{$id}' or md5(`Id`) = '{$id}'");
    }

    public function GetByName($name)
    {
        return $this->GetRowsTableByName($name);
    }

    public function InsertSubmit($model)
    {
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model)
    {
        $this->UpdateRowTable($model);
        $ModelLogSP = new \Module\sanpham\Model\SanPhamLog();
        $model["NgayTao"] = date("Y-m-d H:i:s", time());
        $model["NgaySua"] = date("Y-m-d H:i:s", time());
        $model["idKhachHang"] = $model["idKhachHang"] == null ? 0 : $model["idKhachHang"];
        $model["HinhAnh"] = $model["HinhAnh"] == null ? "" : $model["HinhAnh"];
        return $ModelLogSP->InsertSubmit($model);
    }

    public function DeleteSubmit($id)
    {
        return $this->DeleteRowById($id);
    }

    function GetAll2Option($where = null)
    {
        if ($where == null)
            $where = " 1=1";
        return $this->getColumnsOption(["Id", "Code", "Name"], $where);
    }
}
