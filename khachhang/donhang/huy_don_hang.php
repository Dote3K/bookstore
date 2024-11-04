<?php
require_once '../../connect.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_don_hang = $_POST['ma_don_hang'];

    // Xóa chi tiết đơn hàng
    $sql = "DELETE FROM chitietdonhang WHERE ma_don_hang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_don_hang);
    $stmt->execute();
    $stmt->close();

    // Cập nhật trạng thái đơn hàng thành 'Đã hủy'
    $sql = "UPDATE donhang SET trang_thai = 'DA_HUY' WHERE ma_don_hang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_don_hang);

    if ($stmt->execute()) {
        echo "Đơn hàng đã được hủy thành công!";
    } else {
        echo "Lỗi khi hủy đơn hàng: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
<a href="form_donhang.php">Quay về danh sách đơn hàng</a>