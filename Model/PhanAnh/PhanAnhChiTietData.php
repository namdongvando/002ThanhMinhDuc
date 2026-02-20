<?php

namespace Model\PhanAnh;


use Zend\Db\TableGateway\TableGateway;

class PhanAnhChiTietData  extends \datatable\ZendData implements \Model\IModel
{
    private static $tableNews;
    private $TableName;

    public function __construct()
    {
        $this->TableName = table_prefix . "phananh_chitiet";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    function GetAll()
    {
    }

    /**
     *
     * @param mixed $id
     *
     * @return mixed
     */
    function GetById($id)
    {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }

    /**
     *
     * @param mixed $name
     *
     * @return mixed
     */
    function GetByName($name)
    {
        return $this->GetRowsTableByName($name);
    }

    /**
     *
     * @param mixed $model
     *
     * @return mixed
     */
    function InsertSubmit($model)
    {
        return $this->InsertRowsTable($model);
    }

    /**
     *
     * @param mixed $model
     *
     * @return mixed
     */
    function UpdateSubmit($model)
    {
        return $this->UpdateRowTable($model);
    }

    /**
     *
     * @param mixed $id
     *
     * @return mixed
     */
    function DeleteSubmit($id)
    {
        return $this->DeleteRowById($id);
    }
}
