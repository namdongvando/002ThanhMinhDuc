<?php

namespace Module\user\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class userinfor extends \Core\DatabaseZend {

    public $Id, $Name, $Phone, $Email, $GhiChu, $Tinh, $Huyen, $PhuongXa, $SoNhaDuong;
    private $TableConnect;
    static private $TableName;

    function __construct($uf = null) {
        if ($uf) {
            $this->Id = !empty($uf["Id"]) ? $uf["Id"] : 0;
            $this->Name = !empty($uf["Name"]) ? $uf["Name"] : "";
            $this->Phone = !empty($uf["Phone"]) ? $uf["Phone"] : "";
            $this->Email = !empty($uf["Email"]) ? $uf["Email"] : "";
            $this->GhiChu = !empty($uf["GhiChu"]) ? $uf["GhiChu"] : "";
            $this->Tinh = !empty($uf["Tinh"]) ? $uf["Tinh"] : 1;
            $this->Huyen = !empty($uf["Huyen"]) ? $uf["Huyen"] : 2;
            $this->PhuongXa = !empty($uf["PhuongXa"]) ? $uf["PhuongXa"] : "";
            $this->SoNhaDuong = !empty($uf["SoNhaDuong"]) ? $uf["SoNhaDuong"] : "";
        }
        self::$TableName = table_prefix . 'user_infor';
        $this->TableConnect = new TableGateway(self::$TableName, $this->Connect());
        $this->setConnetTable(self::$TableName);
    }

    function getUserInforById($id) {
        return $this->getRowById($id);
    }

    function TinhThanh() {
        $TinhThanh = new \datatable\TinhThanh();
        return new \datatable\TinhThanh($TinhThanh->getTinhThanhById($this->Tinh));
    }

    function QuanHuyen() {
        $TinhThanh = new \datatable\TinhThanh();
        return new \datatable\TinhThanh($TinhThanh->getTinhThanhById($this->Huyen));
    }

    function PhuongXa() {
        return $this->PhuongXa;
    }

    function SoNhaDuong() {
        return $this->SoNhaDuong;
    }

}
?>

