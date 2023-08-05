<?php

namespace Model;

use Zend\Db\TableGateway\TableGateway;

class ThongBaoTable extends \Core\DatabaseZend 
{
    private $TableConnect;
    static private $TableName;

    function __construct()
    {
        self::$TableName = table_prefix . 'thongbao';
        $this->TableConnect = new TableGateway(self::$TableName, $this->Connect());
        $this->setConnetTable(self::$TableName);
         
    }
 
    
}