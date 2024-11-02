<?php
session_start();


if (!isset($_SESSION['ma_khach_hang'])) {
    header("Location: login.php");
    exit();
}


echo "Vai trò: " . ($_SESSION['vai_tro'] === 'admin' ? "Admin " : "Người dùng ");
if ($_SESSION['vai_tro'] === 'admin') {
    echo '<br><a href="admin/doanhthu/index.php">Quản lý doanh thu</a>';
} else {
    echo '<br>Ko em.';
}
echo '<a href="user/hienThi.php">Thông tin tài khoản</a>'
?>

<a href="logout.php">Đăng xuất</a>
