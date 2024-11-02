<?php
session_start();

if (!isset($_SESSION['ma_khach_hang']) || $_SESSION['vai_tro'] !== 'admin') {
    header("Location: home.php");
    exit();
}

echo "Chào mừng Admin đến với trang quản trị.";
?>

<a href="home.php">Trở về trang chủ</a>