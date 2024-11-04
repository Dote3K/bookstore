<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if (isset($_GET['ma_sach'])) {
    // Ép kiểu biến $ma_sach để tránh lỗi cú pháp SQL
    $ma_sach = (int)$_GET['ma_sach'];

    // Truy vấn đường dẫn ảnh bìa của sách từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT anh_bia FROM sach WHERE ma_sach = ?");
    $stmt->bind_param("i", $ma_sach);
    $stmt->execute();
    $result = $stmt->get_result();
    $sach = $result->fetch_assoc();

    if ($sach) {
        // Đường dẫn ảnh bìa
        $anh_bia = $sach['anh_bia'];

        // Kiểm tra và xóa ảnh bìa nếu tồn tại
        if (file_exists($anh_bia)) {
            unlink($anh_bia); // Xóa file ảnh khỏi máy chủ
        }

        // Xóa sách khỏi cơ sở dữ liệu
        $stmt = $conn->prepare("DELETE FROM sach WHERE ma_sach = ?");
        $stmt->bind_param("i", $ma_sach);
        if ($stmt->execute()) {
            echo "Xóa sách thành công";
            header("Location: show_sach.php"); // Điều hướng về trang hiển thị sách sau khi xóa
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
