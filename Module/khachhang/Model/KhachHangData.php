<?php

namespace Module\khachhang\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class KhachHangData extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;

    public function __construct() {
        $this->TableName = table_prefix . "khachhang";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }

    public function GetAll() {
        return $this->GetRows();
    }

    public function GetById($id, $mahoa = false) {
        if ($mahoa == true) {
            return $this->GetRowByWhere(" sha1(`Id`) = '{$id}'");
        }
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

    public function DeleteSubmit($id, $maHoa = false) {
        $kh = $this->GetById($id, $maHoa);
        $KHTT = new KhachHangThanhToan();
        $this->DeleteRowById($id, $maHoa);
        return $KHTT->DeleteByCode($kh["Code"]);
    }

    function GetAll2Option($where = null) {
        if ($where == null)
            $where = " 1=1";
        return $this->getColumnsOption(["Id", "Name"], $where);
    }

}
?>

