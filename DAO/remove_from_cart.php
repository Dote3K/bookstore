<?php
require_once '../checker/kiemtra_login.php';

if (isset($_GET['ma_sach'])) {
    $ma_sach = (int)$_GET['ma_sach'];

    if (isset($_SESSION['cart'][$ma_sach])) {
        unset($_SESSION['cart'][$ma_sach]);
        $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
    } else {
        $_SESSION['error'] = "Sản phẩm không tồn tại trong giỏ hàng!";
    }
} else {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
}

header('Location: /view/cart.php');
exit;
?>
