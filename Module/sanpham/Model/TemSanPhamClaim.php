<?php
namespace Module\sanpham\Model;

use Zend\Db\TableGateway\TableGateway;

class TemSanPhamClaim extends \datatable\ZendData implements \Model\IModel
{

    // `Id`, `CodeTem`, `ClaimType`, `ClaimValue`, `UpdateRecord`, `CreateRecord`
    private static $tableNews;

    private $TableName;

    public function __construct()
    {
        $this->TableName = table_prefix . "tembaohanh_claim";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
    }
    /**
     * @return mixed
     */
    public function GetAll()
    {
    }

    /**
     *
     * @param mixed $id
     * @return mixed
     */
    public function GetById($id)
    {
    }

    /**
     *
     * @param mixed $name
     * @return mixed
     */
    public function GetByName($name)
    {
    }

    /**
     *
     * @param mixed $model
     * @return mixed
     */
    public function InsertSubmit($model)
    {
    }

    /**
     *
     * @param mixed $model
     * @return mixed
     */
    public function UpdateSubmit($model)
    {
    }

    /**
     *
     * @param mixed $id
     * @return mixed
     */
    public function DeleteSubmit($id)
    {
    }
}


?>