<?php
session_start();

// Kiểm tra nếu có giỏ hàng
if (!isset($_POST['cart'])) {
    header("Location: cart.php");
    exit;
}

$cartItems = unserialize($_POST['cart']);
$totalCost = 0;

// Tính tổng giá trị đơn hàng
foreach ($cartItems as $item) {
    $totalCost += $item['gia'] * $item['so_luong'];
}

// Kết nối đến cơ sở dữ liệu
require_once '../backend/db.php';

// Lấy thông tin khách hàng (giả định đã đăng nhập)
$customerId = $_SESSION['customer_id']; // Giả sử bạn đã lưu ID khách hàng trong session

// Tạo đơn hàng mới
$query = 'INSERT INTO donhang (ma_khach_hang, tong, trang_thai) VALUES (:customerId, :totalCost, "Đang chờ")';
$stmt = $db->prepare($query);
$stmt->bindValue(':customerId', $customerId);
$stmt->bindValue(':totalCost', $totalCost);
$stmt->execute();

// Lấy ID đơn hàng vừa tạo
$orderId = $db->lastInsertId();

// Thêm chi tiết đơn hàng vào cơ sở dữ liệu
foreach ($cartItems as $item) {
    $query = 'INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong, gia) VALUES (:orderId, :bookId, :quantity, :price)';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':orderId', $orderId);
    $stmt->bindValue(':bookId', $item['ma_sach']);
    $stmt->bindValue(':quantity', $item['so_luong']);
    $stmt->bindValue(':price', $item['gia']);
    $stmt->execute();
}

// Sau khi thanh toán thành công, bạn có thể xóa giỏ hàng
unset($_SESSION['cart']);

// Hiển thị thông báo thanh toán thành công
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thanh Toán Thành Công</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <h1>Thanh Toán Thành Công!</h1>
    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
    <p>Mã đơn hàng của bạn: <strong><?php echo htmlspecialchars($orderId); ?></strong></p>
    <p>Tổng giá trị đơn hàng: <strong><?php echo number_format($totalCost, 2) . ' VND'; ?></strong></p>
    <a href="index.php">Quay về trang chủ</a>
</body>

</html>