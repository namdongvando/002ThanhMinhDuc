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
    $idTinh = $_GET['idTinh'];
    $sql = mysqli_query($conn, 'select * from thanhminhduc_tinhthanh');
    echo '<option>Chọn Quận/Huyện</option>';
    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {
            if ($idTinh == $row['IdP']) {
                echo '<option value="' . $row['Id'] . '">' . $row['Name'] . '</option>';
            }
        }
    }
?>