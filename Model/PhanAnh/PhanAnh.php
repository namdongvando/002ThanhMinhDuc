<?php

namespace Model\PhanAnh;

use Common\Common;
use Module\option\Model\Option as ModelOption;
use Module\rmm\Model\Option;
use Module\sanpham\Model\TemSanPham;

class PhanAnh  extends PhanAnhData
{
    public $Id;
    public $Code;
    public $Name;
    public $Content;
    public $MaTem;
    public $HinhAnh;
    public $TinhTrang;
    public $UpdateRecord;
    public $CreateRecord;


    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $id = $dv;
                $dv = $this->GetById($id);
                if ($dv == null) {
                    $dv = $this->GetByCode($id);
                }
            }
            $this->Id = $dv["Id"] ?? null;
            $this->Code = $dv["Code"] ?? null;
            $this->Name = $dv["Name"] ?? null;
            $this->Content = $dv["Content"] ?? null;
            $this->MaTem = $dv["MaTem"] ?? null;
            $this->HinhAnh = $dv["HinhAnh"] ?? null;
            $this->TinhTrang = $dv["TinhTrang"] ?? null;
            $this->UpdateRecord = $dv["UpdateRecord"] ?? null;
            $this->CreateRecord = $dv["CreateRecord"] ?? null;
        }
    }


    public function PhanAnhLog()
    {
        $pal = new PhanAnhLog();
        return $pal->GetByMaPhanAnh($this->Code);
    }
    public function TemSanPham()
    {
        return new TemSanPham($this->MaTem);
    }

    public function TinhTrang()
    {
        $op = ModelOption::GetOptionByGroupsCode(ModelOption::TinhTrangPhanAnh, $this->TinhTrang);
        // var_dump($op);
        return new ModelOption($op);
    }
    public function CreateCode()
    {
        return date("ymd", time())  . ($this->GetNumberRows("1=1") + 1);
    }
    public function GetByCode($code)
    {
        return $this->GetRowByWhere("`Code` = '{$code}'");
    }
    public function Post($model)
    {
        return $this->InsertSubmit($model);
    }
    public function PostFull($model)
    {
        return $this->InsertSubmit($model);
    }
    public function Put($model)
    {
        return $this->UpdateSubmit($model);
    }
    public function SaveLog($type = "Update", $comment = "")
    {


        $phanAnhLog["PhanAnh"] = $this->GetById($this->Id);
        $phanAnhLog["PhanAnhChiTiet"] = $this->PhanAnhChiTiet();
        $Logdata["Content"] = json_encode($phanAnhLog, JSON_UNESCAPED_UNICODE);
        $Logdata["Type"] = $type;
        $Logdata["Comment"] = $comment;
        $Logdata["UpdateRecord"] = date("Y-m-d H:i:s", time());
        $Logdata["CreateRecord"] = date("Y-m-d H:i:s", time());
        $Logdata["IdPhanAnh"] = $this->Code;
        $paLog = new PhanAnhLog();
        $paLog->Post($Logdata);
    }
    public function PhanAnhChiTiet()
    {
        $phanAnhChiTiet = new PhanAnhChiTiet();
        return  $phanAnhChiTiet->GetByMaPhanAnh($this->Code);
    }
    function GetItems($params, $indexPage, $numberPage, &$total)
    {

        $orderName = ["1" => "DESC", "0" => "ASC"];
        $keyword = $params["keyword"] ?? "";
        $order = $params["order"] ?? "1";
        $orderSql = $orderName[$order];
        $where = " `MaTem` like '%$keyword%' order by `CreateRecord` $orderSql ";
        return $this->GetRowsTablePt($where, $indexPage, $numberPage, $total);
    }

    public function Delete($id)
    {
        return $this->DeleteSubmit($id);
    }
}
