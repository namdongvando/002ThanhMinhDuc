<?php

namespace Module\user\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class userGroupsTable extends \Core\DatabaseZend {

    private $TableConnect;
    static private $TableName;

    function __construct() {
        self::$TableName = table_prefix . 'admin_groups';
        $this->TableConnect = new TableGateway(self::$TableName, $this->Connect());
        $this->setConnetTable(self::$TableName);
    }

}
?>

