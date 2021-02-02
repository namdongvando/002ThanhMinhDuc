<?php

namespace Module\user\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class userTable extends \Core\DatabaseZend {

    private $TableConnect;
    static private $TableName;

    function __construct() {
        self::$TableName = table_prefix . 'user';
        $this->TableConnect = new TableGateway(self::$TableName, $this->Connect());
        $this->setConnetTable(self::$TableName);
    }

    protected function userByUsernamePassword($u, $p) {
        return $this->ToRow($this->TableConnect->select(" `Username` = '{$u}' and  `Password` => '$p'"));
    }

    protected function users() {
        return $this->ToArray($this->TableConnect->select());
    }

    protected function UserByEmail($Email) {
        return $this->ToRow($this->TableConnect->select(" `Email` = '{$Email}'"));
    }

    protected function UserByUsername($Username) {
        return $this->ToRow($this->TableConnect->select(" `Username` = '{$Username}'"));
    }

}
?>

