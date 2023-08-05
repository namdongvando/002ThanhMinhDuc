<?php

namespace Module\trungtambaohanh\Model;

use Module\option\Model\Option;
use Module\user\Model\Admin;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class YeuCauBaoHanhLogData extends \datatable\ZendData
{

    public $IdLog;
    public $Id;
    public $Code;
    public $MaTem;
    public $Name;
    public $KhachHangTieuDung;
    public $SDT;
    public $TinhThanh;
    public $QuanHuyen;
    public $DiaChi;
    public $NgayBaoHanh;
    public $NoiDung;
    public $NoiDungKhac;
    public $Status;
    public $IdTrungTamBaoHanh;
    public $CreateDate;
    public $idNhanVien;
    public $UpdateDate;
    public $HinhAnh;
    public $Note;


    private static $tableNews;
    private $TableName;

    public function __construct($v = null)
    {
        $this->TableName = table_prefix . "yeucaubaohanh_log";
        $this->setTableGateway($this->TableName);
        parent::__construct($this->TableName);
        if (!self::$tableNews) {
            self::$tableNews = new TableGateway($this->TableName, $this->Connect($this->TableName));
        }

        $this->IdLog = $v["IdLog"] ?? null;
        $this->Id = $v["Id"] ?? null;
        $this->Code = $v["Code"] ?? null;
        $this->MaTem = $v["MaTem"] ?? null;
        $this->Name = $v["Name"] ?? null;
        $this->KhachHangTieuDung = $v["KhachHangTieuDung"] ?? null;
        $this->SDT = $v["SDT"] ?? null;
        $this->TinhThanh = $v["TinhThanh"] ?? null;
        $this->QuanHuyen = $v["QuanHuyen"] ?? null;
        $this->DiaChi = $v["DiaChi"] ?? null;
        $this->NgayBaoHanh = $v["NgayBaoHanh"] ?? null;
        $this->NoiDung = $v["NoiDung"] ?? null;
        $this->NoiDungKhac = $v["NoiDungKhac"] ?? null;
        $this->Status = $v["Status"] ?? null;
        $this->IdTrungTamBaoHanh = $v["IdTrungTamBaoHanh"] ?? null;
        $this->CreateDate = $v["CreateDate"] ?? null;
        $this->idNhanVien = $v["idNhanVien"] ?? null;
        $this->UpdateDate = $v["UpdateDate"] ?? null;
        $this->HinhAnh = $v["HinhAnh"] ?? null;
        $this->Note = $v["Note"] ?? null;

    }
    public function GetAll()
    {
        return $this->GetRows();
    }
    public function GetAllByCode($code)
    {
        return $this->GetRowsByWhere("`Code` = '{$code}' Order by `UpdateDate` desc");
    }
    public function GetById($id)
    {
        return $this->GetRowByWhere("`Id` = '{$id}'");
    }

    public function InsertSubmit($model)
    {
        return $this->InsertRowsTable($model);
    }

    function idNhanVien()
    {
        return new Admin($this->idNhanVien);
    }
    function NoiDungBaoHanh()
    {

        if ($this->NoiDung == "Khac") {
            return new Option(["Name" => $this->NoiDungKhac]);
        }
        return new \Module\option\Model\Option(
            \Module\option\Model\Option::GetOptionByGroupsCode(
                \Module\option\Model\Option::SuCoMacPhai, $this->NoiDung
            )
        );
    }

}