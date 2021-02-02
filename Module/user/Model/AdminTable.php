<?php

namespace Module\user\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class AdminTable extends \Core\DatabaseZend {

    private $TableConnect;
    static private $TableName;

    function __construct() {
        self::$TableName = table_prefix . 'admin';
        $this->setConnetTable(self::$TableName);
    }

    protected function userByUsernamePassword($u, $p) {
        $where = " (Email = '{$u}' or `Username` = '{$u}') and  `Password` = SHA1(concat('$p' ,`Random`))";
        $res = $this->Select($where);
        return $this->ToRow($res);
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

