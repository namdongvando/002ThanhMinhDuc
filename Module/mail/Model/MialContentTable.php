<?php

namespace Module\mail\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Select;

class MialContentTable extends \Model\Database {

    private $CoSoTable;
    private $CoSoTableName;

    function __construct() {
        $this->CoSoTableName = self::TablePrefix . 'mailcontent';
        $this->CoSoTable = new TableGateway($this->CoSoTableName, $this->Connect());
        $this->setDataTable($this->CoSoTableName);
    }

    function DonVis() {
        return $this->fechArray($this->CoSoTable->select());
    }

}
