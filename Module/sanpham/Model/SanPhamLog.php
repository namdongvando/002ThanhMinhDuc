<?php

namespace Module\sanpham\Model;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class SanPhamLog extends \datatable\ZendData implements \Model\IModel {

    private static $tableNews;
    private $TableName;
    public $Id, $Name, $Code, $ChungLoaiSP, $Mota, $Gia, $HinhAnh, $DanhMuc, $TinhTrang, $MaDaiLy;
    public $idKhachHang;
    public $isLook;
    public $Wfstatus;
    public $NgayTao;
    public $NgaySua;

    public function __construct($dv = null) {
        $this->TableName = table_prefix . "sanpham_log";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews)
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
        if ($dv) {
            $this->Id = !empty($dv["Id"]) ? $dv["Id"] : null;
            $this->Name = !empty($dv["Name"]) ? $dv["Name"] : null;
            $this->idKhachHang = !empty($dv["idKhachHang"]) ? $dv["idKhachHang"] : null;
            $this->Code = !empty($dv["Code"]) ? $dv["Code"] : null;
            $this->ChungLoaiSP = !empty($dv["ChungLoaiSP"]) ? $dv["ChungLoaiSP"] : null;
            $this->Mota = !empty($dv["Mota"]) ? $dv["Mota"] : null;
            $this->Gia = !empty($dv["Gia"]) ? $dv["Gia"] : 0;
            $this->HinhAnh = !empty($dv["HinhAnh"]) ? $dv["HinhAnh"] : null;
            $this->DanhMuc = !empty($dv["DanhMuc"]) ? $dv["DanhMuc"] : null;
            $this->TinhTrang = !empty($dv["TinhTrang"]) ? $dv["TinhTrang"] : 0;
            $this->Wfstatus = !empty($dv["Wfstatus"]) ? $dv["Wfstatus"] : 0;
            $this->MaDaiLy = !empty($dv["MaDaiLy"]) ? $dv["MaDaiLy"] : "";
            $this->isLook = !empty($dv["isLook"]) ? $dv["isLook"] : "";
            $this->NgayTao = !empty($dv["NgayTao"]) ? $dv["NgayTao"] : "";
            $this->NgaySua = !empty($dv["NgaySua"]) ? $dv["NgaySua"] : "";
        }
    }

    function SanPham() {
        $sanPhan = new SanPham();
        $sanPhan->Id = $this->Id;
        $sanPhan->Name = $this->Name;
        $sanPhan->idKhachHang = $this->idKhachHang;
        $sanPhan->Code = $this->Code;
        $sanPhan->ChungLoaiSP = $this->ChungLoaiSP;
        $sanPhan->Mota = $this->Mota;
        $sanPhan->Gia = $this->Gia;
        $sanPhan->HinhAnh = $this->HinhAnh;
        $sanPhan->DanhMuc = $this->DanhMuc;
        $sanPhan->TinhTrang = $this->TinhTrang;
        $sanPhan->Wfstatus = $this->Wfstatus;
        $sanPhan->MaDaiLy = $this->MaDaiLy;
        $sanPhan->isLook = $this->isLook;
        return $sanPhan;
    }

    public function DeleteSubmit($id) {

    }

    public function GetAll() {

    }

    public function GetById($id) {

    }

    public function GetByName($name) {

    }

    public function InsertSubmit($model) {
        $mSanPham["idKhachHang"] = !empty($mSanPham["idKhachHang"]) ? $mSanPham["idKhachHang"] : 0;
        $this->InsertRowsTable($model);
    }

    public function UpdateSubmit($model) {

    }

    public function GetByIdSP($param0) {
        return $this->GetRows("`Id` = '{$param0}' ORDER BY `NgayTao` DESC");
    }

}
?>

