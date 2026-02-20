<?php
namespace Module\trungtambaohanh\Model;

use Module\option\Model\Option;
use Module\user\Model\Admin;
use Zend\Db\TableGateway\TableGateway;

class XuLyYeuCau extends \datatable\ZendData
{

    public $Id;
    public $MaYeuCau;
    public $NoiDung;
    public $NoiDungKhac;
    public $UserId;
    public $Type;
    public $CreateRecord;
    public $UpdateRecord;
    private static $tableNews;
    private $TableName;
    function __construct($item = null)
    {
        $this->TableName = table_prefix . "yeucaubaohanh_xuly";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));

        $this->Id = $item["Id"] ?? null;
        $this->MaYeuCau = $item["MaYeuCau"] ?? null;
        $this->NoiDung = $item["NoiDung"] ?? null;
        $this->NoiDungKhac = $item["NoiDungKhac"] ?? null;
        $this->UserId = $item["UserId"] ?? null;
        $this->Type = $item["Type"] ?? null;
        $this->CreateRecord = $item["CreateRecord"] ?? null;
        $this->UpdateRecord = $item["UpdateRecord"] ?? null;
    }

    public function GetById($id)
    {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }
    public function GetByStatus($id, $type)
    {
        $where = "`MaYeuCau` = '{$id}' and `Type` = '{$type}' order by `Id` DESC";

        return $this->GetRowByWhere($where);
    }

    public function GetByName($name)
    {
        return $this->GetRowsTableByName($name);
    }

    public function InsertSubmit($model)
    {
        $model["CreateRecord"] = date(DateFomatDB, time());
        $model["UpdateRecord"] = date(DateFomatDB, time());
        return $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model)
    {
        $model["UpdateDate"] = date(DateFomatDB, time());
        $model["UserId"] = Admin::getCurentUser(true)->Id;
        $this->UpdateRowTable($model);
    }
    public function DeleteSubmit($id)
    {
        return $this->DeleteRowById($id);
    }

    function NoiDungXuLy()
    {
        // var_dump((array) $this);
        if ($this->NoiDung == "Khac") {
            return new Option(["Name" => $this->NoiDungKhac]);
        }
        return new Option(
            Option::GetOptionByGroupsCode(
                $this->Type, $this->NoiDung
            )
        );

    }

}


?>