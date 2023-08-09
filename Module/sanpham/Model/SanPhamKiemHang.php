<?php

namespace Module\sanpham\Model;

use Module\option\Model\Option;
use Module\user\Model\Admin;
use Zend\Db\TableGateway\TableGateway;

class SanPhamKiemHang extends \datatable\ZendData
{

    public $Id;
    public $Name;
    public $MaSanPham;
    public $MaTem;
    public $UserId;
    public $Status;
    public $Content;
    public $CreateRecord;
    public $UpdateRecord;


    private static $tableNews;
    private $TableName;

    public function __construct($item = null)
    {
        $this->TableName = table_prefix . "tembaohanh_kiemhang";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));

        $this->Id = $item["Id"] ?? null;
        $this->Name = $item["Name"] ?? null;
        $this->MaSanPham = $item["MaSanPham"] ?? null;
        $this->MaTem = $item["MaTem"] ?? null;
        $this->UserId = $item["UserId"] ?? null;
        $this->Status = $item["Status"] ?? null;
        $this->Content = $item["Content"] ?? null;
        $this->CreateRecord = $item["CreateRecord"] ?? null;
        $this->UpdateRecord = $item["UpdateRecord"] ?? null;

    }

    function UserId()
    {
        return new Admin($this->UserId);
    }
    function SanPham()
    {
        return new SanPham($this->MaSanPham);
    }

    function Status()
    {
        return new Option((new Option())->GetOptionByGroupsCode("TrangThaiKiemHang", $this->Status));
    }

    function GetItems($params, $indexPage, $numberPage, &$total)
    {
        $where = "1=1";
        return $this->GetRowsTablePt($where, $indexPage, $numberPage, $total);

    }
    function GetByMaTem($maTem, $indexPage, $numberPage, &$total)
    {
        $where = "`MaTem`= '{$maTem}' order by `Id` DESC";
        return $this->GetRowsTablePt($where, $indexPage, $numberPage, $total);
    }

    function InsertSubmit($model)
    {

        $model["CreateRecord"] = date("Y-m-d H:i:s", time());
        $model["UpdateRecord"] = date("Y-m-d H:i:s", time());
        unset($model["Id"]);

        return $this->InsertRowsTable($model);
    }


}