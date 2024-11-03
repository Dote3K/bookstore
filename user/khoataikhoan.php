<?php
    require '../connect.php';
    require '../checker/kiemtra_login.php';
// Lấy ID và hành động từ URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Kiểm tra hành động và thiết lập trạng thái tương ứng
    if ($action == 'suspend') {
        $trang_thai_moi = 'suspended';
    } elseif ($action == 'activate') {
        $trang_thai_moi = 'active';
    } else {
        echo "Hành động không hợp lệ.";
        exit();
    }

    // Cập nhật trạng thái tài khoản
    $sql = "UPDATE khachhang SET trang_thai = ? WHERE ma_khach_hang = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $trang_thai_moi, $id);

    if ($stmt->execute()) {
        echo "Cập nhật trạng thái tài khoản thành công.";
        // Chuyển hướng về trang quản lý khách hàng sau khi cập nhật
        header("Location: quanlikhachhang.php");
        exit();
    } else {
        echo "Lỗi khi cập nhật trạng thái tài khoản: " . $conn->error;
    }
} else {
    echo "ID hoặc hành động không được cung cấp.";
}

$conn->close();
?>
