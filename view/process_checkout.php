<?php
require_once '../checker/kiemtra_login.php';
require '../connect.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
    header('Location: cart.php');
    exit;
}

$ma_khach_hang = $_SESSION['ma_khach_hang'];

// Lấy thông tin khách hàng
$stmt = $conn->prepare("SELECT * FROM khachhang WHERE ma_khach_hang = ?");
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();
$khach_hang = $result->fetch_assoc();

if (!$khach_hang) {
    $_SESSION['error'] = "Không tìm thấy thông tin khách hàng!";
    header('Location: cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy phương thức thanh toán từ form
    $phuong_thuc_thanh_toan = isset($_POST['phuong_thuc_thanh_toan']) ? $_POST['phuong_thuc_thanh_toan'] : 'COD';
    $cac_phuong_thuc_thanh_toan = ['COD', 'Chuyển khoản ngân hàng'];
    if (!in_array($phuong_thuc_thanh_toan, $cac_phuong_thuc_thanh_toan)) {
        $phuong_thuc_thanh_toan = 'COD'; // Mặc định là COD nếu phương thức không hợp lệ
    }

    // Cập nhật thông tin khách hàng nếu có thay đổi
    $ho_va_ten = isset($_POST['ho_va_ten']) ? trim($_POST['ho_va_ten']) : $khach_hang['ho_va_ten'];
    $gioi_tinh = isset($_POST['gioi_tinh']) ? trim($_POST['gioi_tinh']) : $khach_hang['gioi_tinh'];
    $ngay_sinh = isset($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : $khach_hang['ngay_sinh'];
    $dia_chi_nhan_hang = isset($_POST['dia_chi_nhan_hang']) ? trim($_POST['dia_chi_nhan_hang']) : $khach_hang['dia_chi_nhan_hang'];
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : $khach_hang['so_dien_thoai'];
    $email = isset($_POST['email']) ? trim($_POST['email']) : $khach_hang['email'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // 1. Cập nhật thông tin khách hàng
        $stmt = $conn->prepare("UPDATE khachhang SET ho_va_ten = ?, gioi_tinh = ?, ngay_sinh = ?, dia_chi_nhan_hang = ?, so_dien_thoai = ?, email = ? WHERE ma_khach_hang = ?");
        $stmt->bind_param("ssssssi", $ho_va_ten, $gioi_tinh, $ngay_sinh, $dia_chi_nhan_hang, $so_dien_thoai, $email, $ma_khach_hang);
        $stmt->execute();

        // 2. Tạo đơn hàng mới
        $tong = 0;
        foreach ($_SESSION['cart'] as $item) {
            $tong += $item['gia_ban'] * $item['so_luong'];
        }
        $giam_gia = 0; // Chưa có mã giảm giá

        // Xác định trạng thái đơn hàng dựa trên phương thức thanh toán
        if ($phuong_thuc_thanh_toan == 'Chuyển khoản ngân hàng') {
            $trang_thai = 'CHO_THANH_TOAN';
        } else {
            $trang_thai = 'DANG_CHO';
        }

        $stmt = $conn->prepare("INSERT INTO donhang (ma_khach_hang, tong, trang_thai, dia_chi_nhan_hang, giam_gia, phuong_thuc_thanh_toan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idssis", $ma_khach_hang, $tong, $trang_thai, $dia_chi_nhan_hang, $giam_gia, $phuong_thuc_thanh_toan);
        $stmt->execute();
        $ma_don_hang = $stmt->insert_id;

        // Nếu phương thức thanh toán là COD, tiến hành trừ kho và lưu chi tiết đơn hàng
        if ($phuong_thuc_thanh_toan == 'COD') {
            // 3. Thêm chi tiết đơn hàng và cập nhật số lượng sách
            foreach ($_SESSION['cart'] as $ma_sach => $item) {
                // Thêm chi tiết đơn hàng
                $stmt = $conn->prepare("INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $ma_don_hang, $ma_sach, $item['so_luong']);
                $stmt->execute();

                // Cập nhật số lượng sách trong kho
                $stmt = $conn->prepare("UPDATE sach SET so_luong = so_luong - ? WHERE ma_sach = ?");
                $stmt->bind_param("ii", $item['so_luong'], $ma_sach);
                $stmt->execute();
            }

            // Commit giao dịch
            $conn->commit();

            unset($_SESSION['cart']);

            $_SESSION['success'] = "Đơn hàng của bạn đã được đặt thành công!";
            // Chuyển hướng về trang xác nhận hoặc trang chủ
            header('Location: cart.php');
            exit;
        } else {
            // Nếu phương thức thanh toán là Chuyển khoản ngân hàng
            // Gửi thông báo cho khách hàng
            $message = "Đơn hàng #$ma_don_hang của bạn đang chờ thanh toán qua chuyển khoản ngân hàng.";
            $stmt = $conn->prepare("INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status) VALUES (?, ?, ?, 'Chua doc')");
            $stmt->bind_param("iis", $ma_khach_hang, $ma_don_hang, $message);
            $stmt->execute();

            // Lưu thông tin giỏ hàng tạm thời vào bảng gio_hang_tam
            foreach ($_SESSION['cart'] as $ma_sach => $item) {
                $stmt = $conn->prepare("INSERT INTO gio_hang_tam (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $ma_don_hang, $ma_sach, $item['so_luong']);
                $stmt->execute();
            }

            // Commit giao dịch để lưu đơn hàng và thông báo
            $conn->commit();

            unset($_SESSION['cart']);

            $_SESSION['success'] = "Đơn hàng của bạn đã được tạo và đang chờ thanh toán.";

            // Chuyển hướng đến trang order.php?id=$ma_don_hang
            header("Location: order.php?id=$ma_don_hang");
            exit;
        }
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        $_SESSION['error'] = "Đã xảy ra lỗi trong quá trình xử lý đơn hàng: " . $e->getMessage();
        header('Location: cart.php');
        exit;
    }
} else {
    // Nếu không phải phương thức POST, chuyển hướng về trang giỏ hàng
    header('Location: cart.php');
    exit;
}
?>
