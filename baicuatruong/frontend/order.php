<?php
require_once '../backend/db.php'; // Kết nối đến cơ sở dữ liệu

// Lấy thông tin khách hàng từ session
session_start();
$ma_khach_hang = $_SESSION['ma_khach_hang'] ?? null;

if (!$ma_khach_hang) {
    echo "Bạn cần đăng nhập để xem đơn hàng.";
    exit;
}

// Truy vấn để lấy thông tin đơn hàng
$sql = "SELECT * FROM donhang WHERE ma_khach_hang = :ma_khach_hang";
$stmt = $db->prepare($sql);
$stmt->bindParam(':ma_khach_hang', $ma_khach_hang, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông Tin Đơn Hàng</title>
</head>

<body>
    <h1>Danh Sách Đơn Hàng</h1>
    <a href="index.php">Quay về trang chủ</a>

    <?php if (count($orders) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Mã Khách Hàng</th>
                    <th>Tổng Chi Phí</th>
                    <th>Ngày Đặt Hàng</th>
                    <th>Trạng Thái</th>
                    <th>Địa Chỉ Nhận Hàng</th>
                    <th>Giảm Giá</th>
                    <th>Hủy Đơn Hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['ma_don_hang']); ?></td>
                        <td><?php echo htmlspecialchars($order['ma_khach_hang']); ?></td>
                        <td><?php echo number_format($order['tong'], 2) . ' VND'; ?></td>
                        <td><?php echo htmlspecialchars($order['ngay_dat_hang']); ?></td>
                        <td><?php echo htmlspecialchars($order['trang_thai']); ?></td>
                        <td><?php echo htmlspecialchars($order['dia_chi_nhan_hang']); ?></td>
                        <td><?php echo number_format($order['giam_gia'], 2) . ' VND'; ?></td>
                        <td>
                            <?php if (in_array($order['trang_thai'], ['DANG_CHO', 'DA_XAC_NHAN'])): ?>
                                <form action="../backend/cancel_order.php" method="post" style="display:inline;">
                                    <input type="hidden" name="ma_don_hang"
                                        value="<?php echo htmlspecialchars($order['ma_don_hang']); ?>">
                                    <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy
                                        Đơn Hàng</button>
                                </form>
                            <?php else: ?>
                                Đơn hàng không thể hủy
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có đơn hàng nào.</p>
    <?php endif; ?>
</body>

</html>