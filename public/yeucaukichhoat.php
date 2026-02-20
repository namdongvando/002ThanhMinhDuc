<?php
    $serve = "localhost";
    $user = "thanh962_demo";
    $pass = "zaq@123Abc456";
    $data = "thanh962_demo";
    $conn = mysqli_connect($serve, $user, $pass, $data);
    mysqli_set_charset($conn, 'utf8');
    if (!$conn) {
        echo '<script>alert("Lỗi kết nối CSDL !");</script>';
    }
    $code = strtoupper(substr(md5(date("ym", time()) . rand(1, time())), 0, 19));
    $hoTenKH = $_POST['hoTen'];
    $sdtKH = $_POST['sdt'];
    $tinhKH = $_POST['tinh'];
    $huyenKH = $_POST['huyen'];
    $diaChiKH = $_POST['diaChi'];
    $maTemKH = $_POST['maTem'];
    $sql = "insert into thanhminhduc_tembaohanh_yeucau(Code, HoTen, SDT, MaTem, TinhThanh, QuanHuyen, DiaChi, TinhTrang) values('$code', '$hoTenKH', '$sdtKH', '$maTemKH', '$tinhKH', '$huyenKH', '$diaChiKH', 'MoiTao')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Chúng tôi đã ghi nhận yêu cầu tiếp nhận");window.history.back();</script>';
    } else {
        echo 'Thêm dữ liệu không thành công: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
?>