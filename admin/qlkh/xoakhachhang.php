<?php
require '../../connect.php';
require '../../checker/kiemtra_login.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM khachhang WHERE ma_khach_hang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Xóa khách hàng thành công";
    } else {
        echo "Lỗi khi xóa: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Không có ID khách hàng được cung cấp.";
}
$conn->close();
// Chuyển hướng về trang quản lý khách hàng sau khi xóa
header("Location: quanlikhachhang.php");
exit();
?>