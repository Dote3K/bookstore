<?php
require_once '../../connect.php'; // Kết nối đến cơ sở dữ liệu
require '../../checker/kiemtra_login.php';

// Lấy mã khách hàng từ session
$ma_khach_hang = $_SESSION['ma_khach_hang'] ?? null;
if (!$ma_khach_hang) {
    header("Location: ../../login.php");
    exit();
}

// Truy vấn để lấy thông tin đơn hàng của khách hàng
$sql = "SELECT * FROM donhang WHERE ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Đơn Hàng</title>
    <link rel="stylesheet" href="../../css/formdonhang.css">
</head>
<body>
    <h1>Danh Sách Đơn Hàng</h1>
    <a href="../trangchu/trang_chu.php" class="back-link">Quay về trang chủ</a>

    <?php if (count($orders) > 0): ?>
        <table>
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
                        <td><?php echo number_format($order['tong'], 0, ',', '.') . ' VND'; ?></td>
                        <td><?php echo htmlspecialchars($order['ngay_dat_hang']); ?></td>
                        <td><?php echo htmlspecialchars($order['trang_thai']); ?></td>
                        <td><?php echo htmlspecialchars($order['dia_chi_nhan_hang']); ?></td>
                        <td><?php echo number_format($order['giam_gia'] * $order['tong'], 0, ',', '.') . ' VND'; ?></td>
                        <td>
                            <?php if (in_array($order['trang_thai'], ['DANG_CHO', 'DA_XAC_NHAN'])): ?>
                                <form action="huy_don_hang.php" method="post" style="display:inline;">
                                    <input type="hidden" name="ma_don_hang" value="<?php echo htmlspecialchars($order['ma_don_hang']); ?>">
                                    <button type="submit" class="cancel-button" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy Đơn Hàng</button>
                                </form>
                            <?php else: ?>
                                <span class="not-cancelable">Đơn hàng không thể hủy</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-orders">Không có đơn hàng nào.</p>
    <?php endif; ?>
</body>
</html>
