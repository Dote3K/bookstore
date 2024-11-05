<?php
session_start();
require_once '../../connect.php';

if (!isset($_SESSION['ma_khach_hang'])) {
 echo "Vui lòng đăng nhập để xem giỏ hàng của bạn";
}

// Khởi tạo giỏ hàng trong session nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $maSach = $_POST['ma_sach'];
    $tenSach = $_POST['ten_sach'];
    $gia = $_POST['gia'];
    $soLuong = $_POST['so_luong'];

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($_SESSION['cart'][$maSach])) {
        $_SESSION['cart'][$maSach]['so_luong'] += $soLuong;
    } else {
        $_SESSION['cart'][$maSach] = [
            'ten_sach' => $tenSach,
            'gia' => $gia,
            'so_luong' => $soLuong
        ];
    }
}

// Hiển thị sản phẩm trong giỏ hàng
$cartItems = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="../../css/formgiohang.css">
</head>

<body>
    <h1>Giỏ hàng của bạn</h1>

    <?php if (empty($cartItems)): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $maSach => $item): ?>
                    <tr>
                        <td><?= $item['ten_sach'] ?></td>
                        <td><?= $item['gia'] ?> VND</td>
                        <td><?= $item['so_luong'] ?></td>
                        <td><?= $item['gia'] * $item['so_luong'] ?> VND</td>
                        <td>
                            <form action="xoa_khoi_gio_hang.php" method="post">
                                <input type="hidden" name="ma_sach" value="<?= $maSach ?>">
                                <button type="submit" name="remove_item">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="../thanhtoan/form_thanhtoan.php" method="post">
            <?php foreach ($cartItems as $maSach => $item): ?>
                <input type="hidden" name="cart[<?= $maSach ?>][ten_sach]" value="<?= $item['ten_sach'] ?>">
                <input type="hidden" name="cart[<?= $maSach ?>][gia]" value="<?= $item['gia'] ?>">
                <input type="hidden" name="cart[<?= $maSach ?>][so_luong]" value="<?= $item['so_luong'] ?>">
            <?php endforeach; ?>
            <button type="submit" name="proceed_to_payment">Mua Ngay</button>
        </form>
    <?php endif; ?>

    <a href="../trangchu/trang_chu.php">Quay về trang chủ</a>
</body>

</html>