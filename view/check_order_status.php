<?php
require '../connect.php';

// Chỉ cho phép POST và có order_id
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['order_id'])) {
    die('Yêu cầu không hợp lệ');
}

$ma_don_hang = intval($_POST['order_id']);

$stmt = $conn->prepare("SELECT trang_thai FROM donhang WHERE ma_don_hang = ?");
$stmt->bind_param("i", $ma_don_hang);
$stmt->execute();
$result = $stmt->get_result();
$don_hang = $result->fetch_assoc();

if ($don_hang) {
    echo json_encode(['trang_thai' => $don_hang['trang_thai']]);
} else {
    echo json_encode(['trang_thai' => 'order_not_found']);
}
?>
