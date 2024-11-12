<?php
require_once '../checker/kiemtra_login.php';
require '../connect.php';


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
    header('Location: cart.php');
    exit;
}

$ma_khach_hang = $_SESSION['ma_khach_hang'];

$stmt = $conn->prepare("SELECT ho_va_ten, gioi_tinh, ngay_sinh, dia_chi_nhan_hang, so_dien_thoai, email FROM khachhang WHERE ma_khach_hang = ?");
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
    if (isset($_POST['so_luong']) && is_array($_POST['so_luong'])) {
        foreach ($_POST['so_luong'] as $ma_sach => $so_luong) {
            $ma_sach = (int)$ma_sach;
            $so_luong = (int)$so_luong;
            if ($ma_sach > 0 && $so_luong > 0) {
                // Kiểm tra số lượng tồn kho
                $stmt = $conn->prepare("SELECT so_luong FROM sach WHERE ma_sach = ?");
                $stmt->bind_param("i", $ma_sach);
                $stmt->execute();
                $result = $stmt->get_result();
                $sach = $result->fetch_assoc();

                if ($sach && $sach['so_luong'] >= $so_luong) {
                    $_SESSION['cart'][$ma_sach]['so_luong'] = $so_luong;
                } else {
                    $_SESSION['error'] = "Số lượng yêu cầu cho sản phẩm ID $ma_sach vượt quá số lượng có sẵn!";
                    header('Location: cart.php');
                    exit;
                }
                $stmt->close();
            }
        }
    }
}

$thong_bao_thanh_cong = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$thong_bao_loi = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success'], $_SESSION['error']);

if ($thong_bao_loi) {
    header('Location: cart.php');
    exit;
}

// Bắt đầu giao dịch
$conn->begin_transaction();

try {
    // nếu người dufng điền lại thông tinở đây thì sửa lại trong db
    $ho_va_ten = isset($_POST['ho_va_ten']) ? trim($_POST['ho_va_ten']) : $khach_hang['ho_va_ten'];
    $gioi_tinh = isset($_POST['gioi_tinh']) ? trim($_POST['gioi_tinh']) : $khach_hang['gioi_tinh'];
    $ngay_sinh = isset($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : $khach_hang['ngay_sinh'];
    $dia_chi_nhan_hang = isset($_POST['dia_chi_nhan_hang']) ? trim($_POST['dia_chi_nhan_hang']) : $khach_hang['dia_chi_nhan_hang'];
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : $khach_hang['so_dien_thoai'];
    $email = isset($_POST['email']) ? trim($_POST['email']) : $khach_hang['email'];

    $stmt = $conn->prepare("UPDATE khachhang SET ho_va_ten = ?, gioi_tinh = ?, ngay_sinh = ?, dia_chi_nhan_hang = ?, so_dien_thoai = ?, email = ? WHERE ma_khach_hang = ?");
    $stmt->bind_param("ssssssi", $ho_va_ten, $gioi_tinh, $ngay_sinh, $dia_chi_nhan_hang, $so_dien_thoai, $email, $ma_khach_hang);
    $stmt->execute();

    // 2. Tạo đơn hàng mới
    $tong = 0;
    foreach ($_SESSION['cart'] as $item) {
        $tong += $item['gia_ban'] * $item['so_luong'];
    }
    $giam_gia = 0; // Cchưa có mã giảm giá để tạm ở đây đã
    $tong -= $giam_gia;

    $stmt = $conn->prepare("INSERT INTO donhang (ma_khach_hang, tong, trang_thai, dia_chi_nhan_hang, giam_gia) VALUES (?, ?, 'DANG_CHO', ?, ?)");
    $stmt->bind_param("idsi", $ma_khach_hang, $tong, $dia_chi_nhan_hang, $giam_gia);
    $stmt->execute();
    $ma_don_hang = $stmt->insert_id;


    foreach ($_SESSION['cart'] as $ma_sach => $item) {
        // thêm chi tiết đơn hàng
        $stmt = $conn->prepare("INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $ma_don_hang, $ma_sach, $item['so_luong']);
        $stmt->execute();

        // cập nhật số lượng sách trong kho
        $stmt = $conn->prepare("UPDATE sach SET so_luong = so_luong - ? WHERE ma_sach = ?");
        $stmt->bind_param("ii", $item['so_luong'], $ma_sach);
        $stmt->execute();
    }

    // 4. gửi thông báo cho khách
    $message = "Đơn hàng #$ma_don_hang của bạn đã được đặt thành công!";
    $stmt = $conn->prepare("INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status) VALUES (?, ?, ?, 'Chua doc')");
    $stmt->bind_param("iis", $ma_khach_hang, $ma_don_hang, $message);
    $stmt->execute();

    // Commit giao dịch
    $conn->commit();

    unset($_SESSION['cart']);

    $_SESSION['success'] = "Đơn hàng của bạn đã được đặt thành công!";
} catch (Exception $e) {
    // rollback db nếu lõi
    $conn->rollback();
    $_SESSION['error'] = "Đã xảy ra lỗi trong quá trình xử lý đơn hàng: " . $e->getMessage();
}

header('Location: cart.php');
exit;
?>
