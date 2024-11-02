<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro = 'khachhang';

    $stmt = $conn->prepare("INSERT INTO khachhang (ten_dang_nhap, mat_khau, vai_tro) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ten_dang_nhap, $mat_khau, $vai_tro);
    $stmt->execute();

    echo "Đăng ký thành công!";
    header("location:login.php");
}
?>

<form method="POST" action="register.php">
    <label>Username: <input type="text" name="ten_dang_nhap" required></label><br>
    <label>Password: <input type="password" name="mat_khau" required></label><br>
    <button type="submit">Đăng ký</button>
</form>
