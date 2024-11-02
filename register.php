<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro = 'khachhang';

    // Kiem tra ten dang nhap co ton tai khong
    $stmt = $conn->prepare("SELECT COUNT(*) FROM khachhang WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "Tên tài khoản đã tồn tại. Vui lòng chọn tên khác.";
    } else {
        $sql = "INSERT INTO khachhang (ten_dang_nhap, mat_khau, vai_tro) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $ten_dang_nhap, $mat_khau, $vai_tro);
        $stmt->execute();
        $stmt->close();

        echo "Đăng ký thành công!";
        header("location:login.php");
        exit();
    }
}
?>

<form method="POST" action="register.php">
    <label>Username: <input type="text" name="ten_dang_nhap" required></label><br>
    <label>Password: <input type="password" name="mat_khau" required></label><br>
    <button type="submit">Đăng ký</button>
</form>
