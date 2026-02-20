<?php

namespace Module\trungtambaohanh\Model;

use Module\user\Model\Admin;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class YeuCauBaoHanhData extends \datatable\ZendData implements \Model\IModel
{

    private static $tableNews;
    private $TableName;

    public function __construct()
    {
        $this->TableName = table_prefix . "yeucaubaohanh";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews) {
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
        }
    }

    public function GetAll()
    {
        return $this->GetRows();
    }

    public function GetById($id)
    { 
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }

    public function GetByName($name)
    {
        return $this->GetRowsTableByName($name);
    }

    public function InsertSubmit($model)
    {
        $model["CreateDate"] = date(DateFomatDB, time());
        $model["UpdateDate"] = date(DateFomatDB, time());
        return $this->InsertRowsTable($model);
    }
    public function UpdateSubmitPhuongAnXuLy($model)
    {
        $model["UpdateDate"] = date(DateFomatDB, time());
        $this->UpdateRowTable($model);
        $a = new Admin($model["idNhanVien"]);
        $code =  $a->Username."|".$a->Name;
        $model["NoiDungKhac"] = "Điều Phối cho nhân viên {$code}";
        $model["idNhanVien"] = Admin::getCurentUser(true)->Id;
        $log = new YeuCauBaoHanhLogData();
        $log->InsertSubmit($model);
    }
    public function UpdateSubmitDieuPhoi($model)
    {
        $model["UpdateDate"] = date(DateFomatDB, time());
        $this->UpdateRowTable($model);
        $a = new Admin($model["idNhanVien"]);
        $code =  $a->Username."|".$a->Name;
        $model["NoiDung"] = "Khac";
        $model["NoiDungKhac"] = "Điều Phối cho nhân viên {$code}";
        $model["idNhanVien"] = Admin::getCurentUser(true)->Id;
        $log = new YeuCauBaoHanhLogData();
        $log->InsertSubmit($model);
    }
    public function UpdateSubmit($model)
    {
        $model["UpdateDate"] = date(DateFomatDB, time());
        $model["idNhanVien"] = Admin::getCurentUser(true)->Id;
        $this->UpdateRowTable($model);
        $log = new YeuCauBaoHanhLogData();
        $log->InsertSubmit($model);
    }
    public function XacNhanHoanThanh($model)
    {
        $model["UpdateDate"] = date(DateFomatDB, time()); 
        $this->UpdateRowTable($model);
        $log = new YeuCauBaoHanhLogData();
        $log->InsertSubmit($model);
    }
    public function DeleteSubmit($id)
    {
        return $this->DeleteRowById($id);
    }

}