<?php
session_start();

if (!isset($_SESSION['ma_khach_hang'])) {
    echo "Vui lòng đăng nhập để thanh toán.";
    exit();
}

// Kết nối đến cơ sở dữ liệu
require_once '../../connect.php';

// Kiểm tra nếu có giỏ hàng
if (!isset($_POST['cart'])) {
    header("Location: ../giohang/form_giohang.php");
    exit();
}


// Lấy ID khách hàng từ session
$maKhachHang = $_SESSION['ma_khach_hang'];

// Tìm địa chỉ nhận hàng mặc định từ bảng khachhang
$sql = "SELECT dia_chi_nhan_hang FROM khachhang WHERE ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maKhachHang);
$stmt->execute();
$stmt->bind_result($diaChiNhanHang);
$stmt->fetch();
$stmt->close();

// Nếu có địa chỉ mới được gửi từ form, sử dụng địa chỉ mới
$diaChiNhanHangMoi = $_POST['dia_chi_nhan_hang'] ?? $diaChiNhanHang;

// Tính tổng giá trị đơn hàng
$cartItems = unserialize($_POST['cart']);
$totalCost = 0;

foreach ($cartItems as $item) {
    $totalCost += $item['gia'] * $item['so_luong'];
}

// Tạo đơn hàng mới
$query = 'INSERT INTO donhang (ma_khach_hang, tong, trang_thai, dia_chi_nhan_hang) VALUES (?, ?, "Đang chờ", ?)';
$stmt = $conn->prepare($query);
$stmt->bind_param("ids", $maKhachHang, $totalCost, $diaChiNhanHangMoi);
$stmt->execute();

// Lấy ID đơn hàng vừa tạo
$orderId = $conn->insert_id;

// Thêm chi tiết đơn hàng vào cơ sở dữ liệu
foreach ($cartItems as $item) {
    $query = 'INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong, gia) VALUES (?, ?, ?, ?)';
    $stmt = $db->prepare($query);
    $stmt->bind_param("iiid", $orderId, $item['ma_sach'], $item['so_luong'], $item['gia']);
    $stmt->execute();
}

// Sau khi thanh toán thành công, bạn có thể xóa giỏ hàng
unset($_SESSION['cart']);

// Hiển thị thông báo thanh toán thành công
header("Location: ../donhang/form_donhang.php");
exit();
