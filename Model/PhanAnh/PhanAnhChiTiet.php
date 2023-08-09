<?php

namespace Model\PhanAnh;

class PhanAnhChiTiet  extends PhanAnhChiTietData
{
    public $Id;
    public $MaPhanAnh;
    public $TieuTri;
    public $KetQua;
    public $GhiChu;
    public $CreateRecord;
    public $UpdateRecord;



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
            $this->MaPhanAnh = $dv["MaPhanAnh"] ?? null;
            $this->TieuTri = $dv["TieuTri"] ?? null;
            $this->KetQua = $dv["KetQua"] ?? null;
            $this->GhiChu = $dv["GhiChu"] ?? null;
            $this->CreateRecord = $dv["CreateRecord"] ?? null;
            $this->UpdateRecord = $dv["UpdateRecord"] ?? null;
        }
    }
    public function GetByCode($code)
    {
        return $this->GetRowByWhere("`Code` = '{$code}'");
    }
    public function GetByMaPhanAnh($code)
    {
        return $this->GetRows("`MaPhanAnh` = '{$code}'");
    }
    public function PhanAnh()
    {
        return new PhanAnh($this->MaPhanAnh);
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
