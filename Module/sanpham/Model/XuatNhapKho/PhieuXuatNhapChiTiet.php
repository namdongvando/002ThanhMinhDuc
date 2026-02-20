<?php
namespace Module\sanpham\Model\XuatNhapKho;

use datatable\ZendData;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\TemSanPham;
use Module\user\Model\Admin;
use Zend\Db\TableGateway\TableGateway;

class PhieuXuatNhapChiTiet extends ZendData
{
    private static $tableNews;
    private $TableName;

    public $Id;
    public $Code;
    public $MaPhieu;
    public $NamePhieu;
    public $SanPhamId;
    public $UserId;
    public $Type;
    public $Number;
    public $CreateRecorde;
    public $UpdateRecorde;



    public function __construct($item = null)
    {
        $this->TableName = table_prefix . "phieuxuatnhap_chitiet";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));

        if (!is_array($item)) {
            $id = $item;
            $item = $this->GetRowTableById($id);
        }
        $this->Id = $item["Id"] ?? null;
        $this->Code = $item["Code"] ?? null;
        $this->MaPhieu = $item["MaPhieu"] ?? null;
        $this->NamePhieu = $item["NamePhieu"] ?? null;
        $this->SanPhamId = $item["SanPhamId"] ?? null;
        $this->UserId = $item["UserId"] ?? null;
        $this->Type = $item["Type"] ?? null;
        $this->Number = $item["Number"] ?? null;
        $this->CreateRecorde = $item["CreateRecorde"] ?? null;
        $this->UpdateRecorde = $item["UpdateRecorde"] ?? null;

    }
    function Post($model)
    {
        unset($model["Id"]);
        $model["CreateRecorde"] = date("Y-m-d H:i:s", time());
        $model["UpdateRecorde"] = date("Y-m-d H:i:s", time());
        return $this->InsertRowsTable($model);
    }
    function DanhSachSanPham($MaPhieu)
    {
        return $this->GetRowsByWhere("`MaPhieu` = '{$MaPhieu}'");
    }
    function Put($model)
    {
        $model["UpdateRecorde"] = date("Y-m-d H:i:s", time());
        return $this->UpdateRowTable($model);
    }

    function GetByMaTem($MaTem)
    {
        return $this->GetRowsByWhere("`Code` = '{$MaTem}' order by `CreateRecorde` DESC");
    }
    function TemSanPham() {
        return new TemSanPham($this->Code);
    }
    function SanPham()
    {
        return new SanPham($this->SanPhamId);
    }
    function UserId()
    {
        return new Admin($this->UserId);
    }
    function Type()
    {
        $a = [
            1 => [
                "Id" => 1,
                "Name" => "Phiếu Nhập"
            ],
            -1 => [
                "Id" => 1,
                "Name" => "Phiếu Xuất"
            ]
        ];
        return (object) $a[$this->Type];
    }

    function PhieuXuatNhap()  {
        return new PhieuXuatNhap($this->MaPhieu);
    }
    
    function GetSanPham($formDate,$toDate)  {
        return $this->GetRowsByWhere("`NamePhieu` = 'PhieuDoiTra' and `CreateRecorde` >= '{$formDate} 00:00:00' 
        and `CreateRecorde` <= '{$toDate} 23:59:59' GROUP BY `Code`");   
    }

}