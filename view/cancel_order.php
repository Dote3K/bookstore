<?php
require_once '../connect.php';

$ma_don_hang = isset($_POST['ma_don_hang']) ? intval($_POST['ma_don_hang']) : 0;

if ($ma_don_hang > 0) {
    $stmt = $conn->prepare("UPDATE donhang SET trang_thai = 'DA_HUY' WHERE ma_don_hang = ?");
    $stmt->bind_param("i", $ma_don_hang);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Đơn hàng đã bị hủy thành công."]);
    } else {
        echo json_encode(["message" => "Không thể hủy đơn hàng. Vui lòng thử lại."]);
    }
} else {
    echo json_encode(["message" => "Mã đơn hàng không hợp lệ."]);
}
?>