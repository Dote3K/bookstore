<?php
require_once 'db.php'; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_don_hang = $_POST['ma_don_hang'];

    // Cập nhật trạng thái đơn hàng thành 'DA_HUY'
    $sql = "UPDATE donhang SET trang_thai = 'DA_HUY' WHERE ma_don_hang = :ma_don_hang";

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':ma_don_hang', $ma_don_hang);
        $stmt->execute();

        echo "Đơn hàng đã được hủy thành công!";
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>
<a href="../frontend/order.php">Quay về danh sách đơn hàng</a>