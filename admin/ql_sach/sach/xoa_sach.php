<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if (isset($_GET['ma_sach'])) {
    $ma_sach = (int)$_GET['ma_sach'];

    $stmt = $conn->prepare("SELECT anh_bia FROM sach WHERE ma_sach = ?");
    $stmt->bind_param("i", $ma_sach);
    $stmt->execute();
    $result = $stmt->get_result();
    $sach = $result->fetch_assoc();

    if ($sach) {
        $anh_bia = $sach['anh_bia'];

        if (file_exists($anh_bia)) {
            unlink($anh_bia);
        }


        $stmt = $conn->prepare("DELETE FROM sach WHERE ma_sach = ?");
        $stmt->bind_param("i", $ma_sach);
        if ($stmt->execute()) {
            echo "Xóa sách thành công";
            header("Location: show_sach.php");
            exit();
        } else {
            echo "Lỗi khi xóa sách: " . $conn->error;
        }
    } else {
        echo "Không tìm thấy sách với mã sách này.";
    }
} else {
    echo "Mã sách không hợp lệ.";
}
?>
