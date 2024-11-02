<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($mat_khau, $user['mat_khau'])) {
        $_SESSION['ma_khach_hang'] = $user['ma_khach_hang'];
        $_SESSION['vai_tro'] = $user['vai_tro'];

        echo "Đăng nhập thành công!";
        header("Location: home.php");
        exit();
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<form method="POST" action="login.php">
    <label>Username: <input type="text" name="ten_dang_nhap" required></label><br>
    <label>Password: <input type="password" name="mat_khau" required></label><br>
    <button type="submit">Đăng nhập</button>
</form>
