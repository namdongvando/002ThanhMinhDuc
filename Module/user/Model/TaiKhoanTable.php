<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Module\user\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

/**
 * Description of TaiKhoanTable
 *
 * @author MSI
 */
class TaiKhoanTable extends \Core\DatabaseZend {

    //put your code here
    private $TableConnect;
    static private $TableName;

    function __construct() {
        self::$TableName = table_prefix . 'taikhoan_khachhang';
        $this->setConnetTable(self::$TableName);
    }

}
