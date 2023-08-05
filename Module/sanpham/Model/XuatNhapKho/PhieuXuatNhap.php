<?php
namespace Module\sanpham\Model\XuatNhapKho;

use datatable\ZendData;
use Module\sanpham\Model\TemSanPham;
use Module\user\Model\Admin;
use stdClass;
use Zend\Db\TableGateway\TableGateway;

class PhieuXuatNhap extends ZendData
{
    private static $tableNews;
    private $TableName;

    public $Id;
    public $Code;
    public $Name;
    public $Content;
    public $UserId;
    public $KhacHang;
    public $Type;
    public $CreateRecorde;
    public $UpdateRecorde;


    public function __construct($item = null)
    {
        $this->TableName = table_prefix . "phieuxuatnhap";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));

        if (!is_array($item)) {
            $id = $item;
            $item = $this->GetById($id);
            if ($item == null)
                $item = $this->GetByCode($id);

        }

        $this->Id = $item["Id"] ?? null;
        $this->Code = $item["Code"] ?? null;
        $this->Name = $item["Name"] ?? null;
        $this->Content = $item["Content"] ?? null;
        $this->UserId = $item["UserId"] ?? null;
        $this->KhacHang = $item["KhacHang"] ?? null;
        $this->Type = $item["Type"] ?? null;
        $this->CreateRecorde = $item["CreateRecorde"] ?? null;
        $this->UpdateRecorde = $item["UpdateRecorde"] ?? null;

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
    function UserId()
    {
        return new Admin($this->UserId);
    }
    function GetItems($params, $indexPage, $numberPage, $total)
    {
        $where = "1=1";
        return $this->GetRowsTablePt($where, $indexPage, $numberPage, $total);

    }
    function GetCode()
    {
        $dateDay = date("Y-m-d", time());
        return date("ymd") . ($this->GetNumberRows("`CreateRecorde` like '{$dateDay}%'") + 1);
    }
    function GetByCode($code)
    {
        return $this->GetRowByWhere("`Code` = '{$code}'");
    }
    function GetById($id)
    {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }
    function Post($model)
    {
        unset($model["Id"]);
        $model["CreateRecorde"] = date("Y-m-d H:i:s", time());
        $model["UpdateRecorde"] = date("Y-m-d H:i:s", time());
        return $this->InsertRowsTable($model);
    }
    function Put($model)
    {
        $model["UpdateRecorde"] = date("Y-m-d H:i:s", time());
        $this->UpdateRowTable($model);
    }

    function TaoPhieu($Phieu, $DSMtem, $UserId = null)
    {
        if ($UserId == null) {
            $admin = \Module\user\Model\Admin::getCurentUser(true);
            $UserId = $admin->Id;
        }
        $id = $this->Post($Phieu);
        foreach ($DSMtem as $key => $value) {
            $tem = new TemSanPham($value);
            $model = [
                "Code" => $tem->Code,
                "MaPhieu" => $id,
                "SanPhamId" => $tem->SanPham()->Id,
                "UserId" => $UserId,
                "Type" => $Phieu["Type"],
                "Number" => "1"
            ];
            $tem->UpdateSubmit([
                "Id" => $tem->Id,
                "UserId" => $tem->UserId
            ]);
            $ChiTietPhieu = new PhieuXuatNhapChiTiet();
            $ChiTietPhieu->Post($model);

        }
        return $Phieu["Code"];
    }

    function DanhSachSanPham()
    {
        $chitietPhieu = new PhieuXuatNhapChiTiet();
        return $chitietPhieu->DanhSachSanPham($this->Id);
    }

    function ToRow($index)
    {
        $a["Id"] = $this->Id;
        $a["Code"] = $this->Code;
        $a["Name"] = $this->Name;
        $a["Content"] = $this->Content;
        $a["UserId"] = $this->UserId()->Name;
        $a["KhacHang"] = $this->KhacHang;
        $a["Type"] = $this->Type()->Name;
        $a["CreateRecorde"] = $this->CreateRecorde;
        $a["UpdateRecorde"] = $this->UpdateRecorde;
        return $a;
    }


    function rows()
    {

    }
    function columns()
    {

    }
    function BtnGroup()
    {
        $id = $this->Code;
        return "<a href='/dashboard/xuatnhapkho/detail/{$id}' class='btn btn-primary' >Xem</a>";
    } 
}