<?php

namespace Model;

use Zend\Db\TableGateway\TableGateway;

class ThongBao extends ThongBaoTable
{

    public $Id;
    public $Code;
    public $Title;
    public $Content;
    public $Link;
    public $Status;
    public $Username;
    public $CreateRecord;
    public $UpdateRecord;




    function __construct($item = null)
    {
        parent::__construct();


        $this->Id = $item["Id"] ?? null;
        $this->Code = $item["Code"] ?? null;
        $this->Title = $item["Title"] ?? null;
        $this->Content = $item["Content"] ?? null;
        $this->Link = $item["Link"] ?? null;
        $this->Status = $item["Status"] ?? null;
        $this->Username = $item["Username"] ?? null;
        $this->CreateRecord = $item["CreateRecord"] ?? null;
        $this->UpdateRecord = $item["UpdateRecord"] ?? null;

    }

    function Post($model)
    {
        unset($model["Id"]);
        $model["CreateRecord"] = date("Y-m-d H:i:s", time());
        $model["UpdateRecord"] = date("Y-m-d H:i:s", time());
        return $this->Insert($model);
    }
    function Put($model)
    {
        $model["UpdateRecord"] = date("Y-m-d H:i:s", time());
        return $this->UpdateSubmit($model);
    }
    function DeleteTB($id)
    {
        return $this->DeleteSubmit($id);
    }

    function GetByCode($code)
    {
        $where = "`Code` = '{$code}'";
        return $this->ToRow($this->Select($where));
    }

    function SelectById($id)
    {
        return $this->GetById($id);
    }
    function GetByStatus($status)
    {
        return $this->GetRowsByWhere("`Status` = '{$status}'");
    }

    function XoaThongBao($Code)
    {
        $tt = $this->GetByCode($Code);
        if ($tt) {
            $this->DeleteTB($tt["Id"]);
        }
    }

    function TaoThongBao($code, $Title, $link, $Username, $Content = null)
    {

        $tt = [
            "Code" => $code,
            "Title" => $Title,
            "Content" => $Content ?? "",
            "Link" => $link,
            "Status" => "1",
            "Username" => $Username,
        ];
        $tt1 = $this->GetByCode($tt["Code"]);
        if ($tt1 == null) {
            $this->Post($tt);
        } else {
            $tt["Id"] = $tt1["Id"];
            $this->Put($tt);
        }

    }

}