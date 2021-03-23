<?php

namespace Module\trungtambaohanh\Model;

class YeuCauBaoHanh extends YeuCauBaoHanhData {

    public $Id, $Code, $Name, $IdTrungTamBaoHanh, $Status, $KhachHangTieuDung, $MaTem, $SDT, $DiaChi, $NgayBaoHanh, $NoiDung, $CreateDate, $UpdateDate;

    const MoiTao = "MoiTao";
    const DangXuLy = "DangXuLy";
    const DaXuLy = "DaXuLy";

    public function __construct($dv = null) {
        parent::__construct();
        if ($dv) {
            if (!is_array($dv)) {
                $dv = $this->GetById($dv);
            }
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->KhachHangTieuDung = !empty($dv["KhachHangTieuDung"]) ? $dv["KhachHangTieuDung"] : null;
            $this->SDT = !empty($dv["SDT"]) ? $dv["SDT"] : null;
            $this->Status = !empty($dv["Status"]) ? $dv["Status"] : null;
            $this->IdTrungTamBaoHanh = !empty($dv["IdTrungTamBaoHanh"]) ? $dv["IdTrungTamBaoHanh"] : null;
            $this->MaTem = !empty($dv["MaTem"]) ? $dv["MaTem"] : null;
            $this->DiaChi = !empty($dv["DiaChi"]) ? $dv["DiaChi"] : null;
            $this->NgayBaoHanh = !empty($dv["NgayBaoHanh"]) ? $dv["NgayBaoHanh"] : null;
            $this->NoiDung = !empty($dv["NoiDung"]) ? $dv["NoiDung"] : null;
            $this->CreateDate = !empty($dv["CreateDate"]) ? $dv["CreateDate"] : null;
            $this->UpdateDate = !empty($dv["UpdateDate"]) ? $dv["UpdateDate"] : null;
        }
    }

    public static function YeuCauSuaChuas() {
        $TTKH = new YeuCauBaoHanh();
        $lisStaTus = [self::MoiTao, self::DangXuLy];
        $lisStaTus = implode("','", $lisStaTus);
        $where = "Status in ('{$lisStaTus}')  order by `CreateDate` DESC";
        return $TTKH->GetRowsByWhere($where);
    }

    public static function ListStatusToOption() {
        $listStatus = self::ListStatus();
        $options = [];
        foreach ($listStatus as $key => $value) {
            $option["id"] = $key;
            $option["name"] = $value;
            $options[] = $option;
        }
        return $options;
    }

    public static function ListStatus() {
        return [
            self::MoiTao => "Mới Tạo",
            self::DangXuLy => "Đang Xử Lý",
            self::DaXuLy => "Đã Xử Lý"
        ];
    }

    public function Status() {
        if (isset(self::ListStatus()[$this->Status]))
            return self::ListStatus()[$this->Status];
    }

    public static function GetByCode($code) {
        $TTKH = new YeuCauBaoHanh();
        $where = "`Code` = '{$code}' ";
        return $TTKH->GetRowByWhere($where);
    }

    public function UpdateStatus($id, $ModelUpdate) {
        $a = self::GetByCode($id);
        $a["Status"] = $ModelUpdate["Status"];
        $a["IdTrungTamBaoHanh"] = $ModelUpdate["IdTrungTamBaoHanh"];
        $this->UpdateRowTable($a, "`Code` = '{$id}'");
    }

}
?>

