<?php
    $serve = "localhost";
    $user = "thanh962_demo";
    $pass = "zaq@123Abc456";
    $data = "thanh962_demo";
    $conn = mysqli_connect($serve, $user, $pass, $data);
    mysqli_set_charset($conn, 'utf8');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if (!$conn) {
        echo '<script>alert("Lỗi kết nối CSDL !");</script>';
    }
    
    $code = strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    $suCoMacPhai = $_POST['suCoMacPhai'];
    $sdtBH = $_POST['sdtBH'];
    $tinhBH = $_POST['tinhBH'];
    $huyenBH = $_POST['huyenBH'];
    $diaChiBH = $_POST['diaChiBH'];
    $maTemBH = $_POST['maTemBH'];
    $ngayBaoHanh = $_POST['ngayBaoHanh'];
    $khachHangTieuDung = $_POST['khachHangTieuDung'];
    $ngayTao = date("Y-m-d h:i:sa");
    $ngaySua = date("Y-m-d h:i:sa");
    $sql = "insert into thanhminhduc_yeucaubaohanh(Code, MaTem, Name, KhachHangTieuDung, SDT, TinhThanh, QuanHuyen, DiaChi, NgayBaoHanh, Status, CreateDate, UpdateDate) values('$code', '$maTemBH', '$suCoMacPhai', '$khachHangTieuDung', '$sdtBH', '$tinhBH', '$huyenBH', '$diaChiBH', '$ngayBaoHanh', 'MoiTao', '$ngayTao', '$ngaySua')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Chúng tôi đã ghi nhận yêu cầu bảo hành");window.history.back();</script>';
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
?>