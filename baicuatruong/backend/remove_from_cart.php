<?php
session_start();

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_item'])) {
    $maSach = $_POST['ma_sach'];
    if (isset($_SESSION['cart'][$maSach])) {
        unset($_SESSION['cart'][$maSach]);
    }
}

header('Location: ../frontend/cart.php');
exit();
