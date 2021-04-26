<?php

namespace Module\user\Model;

class TaiKhoan extends TaiKhoanTable {

    public $id;
    public $idUer;
    public $idKhachHang;
    public $Code;

    const CodeKhachHang = "KH";
    const CodeTrungTamBaoHanh = "TTBH";

    public function __construct($taiKhoan = null) {
        if ($taiKhoan) {
            if (!is_array($taiKhoan)) {

            }
            $this->id = !empty($taiKhoan["id"]) ? $taiKhoan["id"] : 0;
            $this->idUer = !empty($taiKhoan["idUer"]) ? $taiKhoan["idUer"] : 0;
            $this->idKhachHang = !empty($taiKhoan["idKhachHang"]) ? $taiKhoan["idKhachHang"] : 0;
            $this->idTrungTamBaoHanh = !empty($taiKhoan["idTrungTamBaoHanh"]) ? $taiKhoan["idTrungTamBaoHanh"] : self::CodeKhachHang;
        }
        parent::__construct();
    }

    public function GetByIdUser($idUser, $code) {
        $where = "`idUser` = '{$idUser}' and `Code` ='{$code}'";
        $res = $this->ToRow($this->Select($where));
        if ($res == null) {
            $this->TaiKhoanKhachHang($idUser, $code);
        }
        return $res;
    }

    public function TaiKhoanKhachHang($idUser, $code) {
        $Model["idUser"] = $idUser;
        $Model["idKhachHang"] = 0;
        $Model["Code"] = $code;
        $this->Post($Model);
        return $this->GetByIdUser($idUser, $code);
    }

    public function Post($Model) {
        return $this->InsertSubmit($Model);
    }

    public function Put($TaiKhoanModel) {
        return $this->UpdateSubmit($TaiKhoanModel);
    }

}
