<?php
session_start();
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    // Chuẩn bị câu truy vấn để lấy thông tin người dùng dựa trên tên đăng nhập
    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Kiểm tra trạng thái tài khoản
        if ($user['trang_thai'] === 'suspended') {
            echo "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên để biết thêm chi tiết.";
        } else {
            // Kiểm tra mật khẩu
            if (password_verify($mat_khau, $user['mat_khau'])) {
                // Đăng nhập thành công, lưu thông tin vào session
                $_SESSION['ma_khach_hang'] = $user['ma_khach_hang'];
                $_SESSION['vai_tro'] = $user['vai_tro'];

                echo "Đăng nhập thành công!";
                header("Location: home.php");
                exit();
            } else {
                echo "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!-- Form đăng nhập -->
<form method="POST" action="login.php">
    <label>Username: <input type="text" name="ten_dang_nhap" required></label><br>
    <label>Password: <input type="password" name="mat_khau" required></label><br>
    <button type="submit">Đăng nhập</button><br>
    Chưa có tài khoản? <a href="register.php">Đăng ký</a>
</form>
