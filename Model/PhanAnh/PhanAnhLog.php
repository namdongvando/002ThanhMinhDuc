<?php

namespace Model\PhanAnh;

class PhanAnhLog  extends PhanAnhLogData
{


    public $Id;
    public $IdPhanAnh;
    public $Content;
    public $Comment;
    public $Type;
    public $UpdateRecord;
    public $CreateRecord;

    public function __construct($dv = null)
    {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $id = $dv;
                $dv = $this->GetById($id);
            }
            $this->Id = $dv["Id"] ?? null;
            $this->Content = $dv["Content"] ?? null;
            $this->Comment = $dv["Comment"] ?? null;
            $this->IdPhanAnh = $dv["IdPhanAnh"] ?? null;
            $this->Type = $dv["Type"] ?? null;
            $this->UpdateRecord = $dv["UpdateRecord"] ?? null;
            $this->CreateRecord = $dv["CreateRecord"] ?? null;
        }
    }
    public function Content()
    {
        return json_decode($this->Content, JSON_OBJECT_AS_ARRAY);
    }
    public function PhanAnh()
    {
        return new PhanAnh($this->Content()["PhanAnh"]);
    }
    public function PhanAnhChiTiet()
    {
        return  $this->Content()["PhanAnhChiTiet"];
    }

    public function GetByMaPhanAnh($code)
    {
        return $this->GetRowsByWhere("`IdPhanAnh` = '{$code}'");
    }

    public function Post($model)
    {
        return $this->InsertSubmit($model);
    }
    public function PostItems($items)
    {
        foreach ($items as $key => $model) {
            $this->InsertSubmit($model);
        }
        return true;
    }
    public function Put($model)
    {
        return $this->UpdateSubmit($model);
    }
    public function Delete($id)
    {
        return $this->DeleteSubmit($id);
    }
}
