<?php

namespace Model;

use Module\khachhang\Model\KhachHangTieuDung;
use Module\sanpham\Model\SanPham;
use Module\sanpham\Model\TemSanPham;
use Module\trungtambaohanh\Model\YeuCauBaoHanh;

class Obj2Html
{


    static function ThongTinSanPhamTheoMaTem($maTem)
    {
        $temSanPham = new TemSanPham($maTem);
        ?>

        <p><b>Mã tem:</b>
            <?php echo $temSanPham->Code; ?>
            <?php
            if()
            ?>
            <a >xem</a>
        </p>
        <p><b>Mã sản phẩm:</b>
            <?php echo $temSanPham->SanPham()->Code; ?>
        </p>
        <p><b>Tên sản phẩm:</b>
            <?php echo $temSanPham->SanPham()->Name; ?>
        </p>
        <p><b>Mô tả:</b>
            <?php echo $temSanPham->SanPham()->Mota; ?>
        </p>
        <p><b>Chủng loại SP:</b>
            <?php echo $temSanPham->SanPham()->ChungLoaiSP()->Name; ?>
        </p>
        <p><b>Chủng loại SP:</b>
            <?php echo $temSanPham->SanPham()->DanhMuc()->Name; ?>
        </p>
        <p><b>Nhân Viên:</b>
            <?php
            echo $temSanPham->UserId()->Name ?? "";
            ?>
        </p>
        <p><b>Nhân Viên Kiểm Hàng:</b>
            <?php
            echo $temSanPham->ThongTinKiemHang()->UserId()->Username ?? "";
            ?> |
            <?php
            echo $temSanPham->ThongTinKiemHang()->UserId()->Name ?? "";
            ?>
        </p>
        <p>
            <b>
                Tình Trạng Hàng Hóa:
            </b>
            <?php
            echo $temSanPham->ThongTinKiemHang()->Status()->Name ?? "";
            ?>
        </p>
        <?php
    }

    static function ThongTinSanPham($maSanPham)
    {
        $sanPham = new SanPham($maSanPham);
        ?>

        <p><b>Id:</b>
            <?php echo $sanPham->Id; ?>
        </p>
        <p><b>Mã sản phẩm:</b>
            <?php echo $sanPham->Code; ?>
        </p>
        <p><b>Tên sản phẩm:</b>
            <?php echo $sanPham->Name; ?>
        </p>
        <p><b>Mô tả:</b>
            <?php echo $sanPham->Mota; ?>
        </p>
        <p><b>Chủng loại SP:</b>
            <?php echo $sanPham->ChungLoaiSP()->Name; ?>
        </p>
        <p><b>Chủng loại SP:</b>
            <?php echo $sanPham->DanhMuc()->Name; ?>
        </p>
        <?php
    }

    public static function ThongTinYeuCau($yc)
    {
        $yeuCauBaoHanh = new YeuCauBaoHanh($yc);
        ?>
        <p><b>Mã yêu cầu: </b>
            <?php echo $yeuCauBaoHanh->Code; ?>
        </p>
        <p><b>Ngày bảo hành: </b>
            <?php echo $yeuCauBaoHanh->NgayBaoHanh; ?>
        </p>
        <p><b>Trạng thái: </b>
            <?php echo $yeuCauBaoHanh->Status(); ?>
        </p>
        <p><b>Khách hàng: </b>
            <?php echo $yeuCauBaoHanh->KhachHangTieuDung()->Name; ?>
        </p>
        <p><b>SĐT: </b>
            <?php echo $yeuCauBaoHanh->SDT; ?>
        </p>
        <p><b>Nội dung bảo hành: </b>
            <?php echo $yeuCauBaoHanh->NoiDungBaoHanh()->Name; ?>
        </p>
        <?php
    }

    public static function ThongTinKhachHangTieuDung($kh)
    {
        $khTieuDung = new KhachHangTieuDung($kh);

        ?>
        <p><b>Mã KH:</b>
            <?php echo $khTieuDung->Code; ?>
        </p>
        <p><b>Họ & Tên:</b>
            <?php echo $khTieuDung->Name; ?>
        </p>
        <p><b>SĐT:</b>
            <?php echo $khTieuDung->Phone; ?>
        </p>
        <p><b>Địa chỉ:</b>
            <?php echo $khTieuDung->DiaChi(); ?>
        </p>
        <?php
    }

}