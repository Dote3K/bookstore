<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';

$ma = $_GET['ma'];

$sql = "DELETE FROM ma_giam_gia WHERE ma = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma);

if ($stmt->execute()) {
    header("Location: show_ma_giam_gia.php");
    exit();
} else {
    echo "Lỗi: " . $conn->error;
}
?>
