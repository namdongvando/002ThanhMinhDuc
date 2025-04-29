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
    $idTinh = $_POST['idTinh'];
    $sql = mysqli_query($conn, 'select * from thanhminhduc_tinhthanh where IdP = "$idTinh"');
    while($row = mysqli_fetch_assoc($sql)) {?>
        <option><?php echo $row['Name'];?></option>
        <?php
    }
?>