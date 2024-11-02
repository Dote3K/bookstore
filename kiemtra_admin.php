<?php
session_start();

if (!isset($_SESSION['ma_khach_hang']) || $_SESSION['vai_tro'] !== 'admin') {
    echo "<h1>Bạn không có quyền truy cập trang này.</h1>";
    echo "<a href='../../index.php'>Trở về trang chủ</a>";
    exit();
}
