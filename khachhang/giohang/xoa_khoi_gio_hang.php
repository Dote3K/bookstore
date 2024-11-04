<?php
session_start();

if (!isset($_SESSION['ma_khach_hang'])) {
    header("Location: ../../login.php");
    exit();
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_item'])) {
    $maSach = $_POST['ma_sach'];
    if (isset($_SESSION['cart'][$maSach])) {
        unset($_SESSION['cart'][$maSach]);
    }
}

header('Location: form_giohang.php');
exit();
