<?php
require '../connect.php';
require '../checker/kiemtra_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matKhauHienTai = $_POST['matKhauHienTai'];
    $matKhauMoi = $_POST['matKhauMoi'];
    $xacNhanMatKhauMoi = $_POST['xacNhanMatKhauMoi'];
    $ma_khach_hang = $_SESSION['ma_khach_hang'];

    if ($matKhauMoi !== $xacNhanMatKhauMoi) {
        echo "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } else {
        $stmt = $conn->prepare("SELECT mat_khau FROM khachhang WHERE ma_khach_hang = ?");
        $stmt->bind_param("i", $ma_khach_hang);
        $stmt->execute();
        $result = $stmt->get_result();
        $khachhang = $result->fetch_assoc();

        if ($khachhang && password_verify($matKhauHienTai, $khachhang['mat_khau'])) {

            $maHoaMatKhauMoi = password_hash($matKhauMoi, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE khachhang SET mat_khau = ? WHERE ma_khach_hang = ?");
            $stmt->bind_param("si", $maHoaMatKhauMoi, $ma_khach_hang);
            $stmt->execute();

            echo "Đổi mật khẩu thành công!";
        } else {
            echo "Mật khẩu hiện tại không đúng.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
</head>
<body>
<h2>Đổi mật khẩu</h2>
<form method="POST" action="">
    <label>Mật khẩu hiện tại: <input type="password" name="matKhauHienTai" required></label><br>
    <label>Mật khẩu mới: <input type="password" name="matKhauMoi" required></label><br>
    <label>Xác nhận mật khẩu mới: <input type="password" name="xacNhanMatKhauMoi" required></label><br>
    <button type="submit">Đổi mật khẩu</button>
</form>
<a href="../home.php">Quay lại trang chủ</a>
</body>
</html>