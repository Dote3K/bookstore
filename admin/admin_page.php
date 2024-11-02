<?php
session_start();

if (!isset($_SESSION['ma_khach_hang']) || $_SESSION['vai_tro'] !== 'admin') {
    header("Location: home.php");
    exit();
}

echo "Admin";
?>
<a href="../admin/doanhthu/doanhthu.php">Quản lý doanh thu</a>


<a href="../home.php">Trở về trang chủ</a>