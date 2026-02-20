<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Module\trungtambaohanh\Model;

/**
 * Description of IYeuCauBaoHanh
 *
 * @author MSI
 */
interface IFormYeuCauBaoHanh
{
    public function Id($val=null,$prop=[]);
     public function Code($val=null,$prop=[]);
     public function MaTem($val=null,$prop=[]);
     public function Name($val=null,$prop=[]);
     public function KhachHangTieuDung($val=null,$prop=[]);
     public function SDT($val=null,$prop=[]);
     public function TinhThanh($val=null,$prop=[]);
     public function QuanHuyen($val=null,$prop=[]);
     public function DiaChi($val=null,$prop=[]);
     public function NgayBaoHanh($val=null,$prop=[]);
     public function NoiDung($val=null,$prop=[]);
     public function Status($val=null,$prop=[]);
     public function IdTrungTamBaoHanh($val=null,$prop=[]);
     public function CreateDate($val=null,$prop=[]);
     public function idNhanVien($val=null,$prop=[]);
     public function UpdateDate($val=null,$prop=[]);
     public function HinhAnh($val=null,$prop=[]);
     public function Note($val=null,$prop=[]);

 
}