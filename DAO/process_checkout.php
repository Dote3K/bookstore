<?php
require_once '../checker/kiemtra_login.php';
require '../connect.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
    header('Location: /view/cart.php');
    exit;
}

$ma_khach_hang = $_SESSION['ma_khach_hang'];

// lấy thông tin khách hàng
$stmt = $conn->prepare("SELECT * FROM khachhang WHERE ma_khach_hang = ?");
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();
$khach_hang = $result->fetch_assoc();

if (!$khach_hang) {
    $_SESSION['error'] = "Không tìm thấy thông tin khách hàng!";
    header('Location: /view/cart.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // lấy phương thức thanh toán từ form
    $phuong_thuc_thanh_toan = isset($_POST['phuong_thuc_thanh_toan']) ? $_POST['phuong_thuc_thanh_toan'] : 'COD';
    $cac_phuong_thuc_thanh_toan = ['COD', 'Chuyển khoản ngân hàng'];
    if (!in_array($phuong_thuc_thanh_toan, $cac_phuong_thuc_thanh_toan)) {
        $phuong_thuc_thanh_toan = 'COD'; // mặc định là COD nếu phương thức không hợp lệ
    }

    // lấy mã giảm giá từ form
    $ma_giam_gia_code = isset($_POST['ma_giam_gia']) ? trim($_POST['ma_giam_gia']) : '';

    // cập nhật thông tin khách hàng nếu có thay đổi
    $ho_va_ten = isset($_POST['ho_va_ten']) ? trim($_POST['ho_va_ten']) : $khach_hang['ho_va_ten'];
    $gioi_tinh = isset($_POST['gioi_tinh']) ? trim($_POST['gioi_tinh']) : $khach_hang['gioi_tinh'];
    $ngay_sinh = isset($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : $khach_hang['ngay_sinh'];
    $dia_chi_nhan_hang = isset($_POST['dia_chi_nhan_hang']) ? trim($_POST['dia_chi_nhan_hang']) : $khach_hang['dia_chi_nhan_hang'];
    $so_dien_thoai = isset($_POST['so_dien_thoai']) ? trim($_POST['so_dien_thoai']) : $khach_hang['so_dien_thoai'];
    $email = isset($_POST['email']) ? trim($_POST['email']) : $khach_hang['email'];

    //bắt đầu xử lý đơn
    $conn->begin_transaction();

    try {
        // b1. cập nhật tt khách hàng
        $stmt = $conn->prepare("UPDATE khachhang SET ho_va_ten = ?, gioi_tinh = ?, ngay_sinh = ?, dia_chi_nhan_hang = ?, so_dien_thoai = ?, email = ? WHERE ma_khach_hang = ?");
        $stmt->bind_param("ssssssi", $ho_va_ten, $gioi_tinh, $ngay_sinh, $dia_chi_nhan_hang, $so_dien_thoai, $email, $ma_khach_hang);
        $stmt->execute();

        // b2. tính tổng tiền
        $tong = 0;
        foreach ($_SESSION['cart'] as $item) {
            $tong += $item['gia_ban'] * $item['so_luong'];
        }

        // b3. kiểm tra mã giảm gias
        $giam_gia = 0;
        $ma_giam_gia_id = null;

        if (!empty($ma_giam_gia_code)) {
            $stmt = $conn->prepare("SELECT * FROM ma_giam_gia WHERE ma_giam = ? AND trang_thai = 'kich_hoat' AND (ngay_bat_dau IS NULL OR ngay_bat_dau <= NOW()) AND (ngay_ket_thuc IS NULL OR ngay_ket_thuc >= NOW()) AND (so_lan_su_dung_toi_da IS NULL OR so_lan_da_su_dung < so_lan_su_dung_toi_da)");
            $stmt->bind_param("s", $ma_giam_gia_code);
            $stmt->execute();
            $result = $stmt->get_result();
            $ma_giam_gia = $result->fetch_assoc();

            if ($ma_giam_gia) {
                // kiểm tra đơn hàng có đạt giá trị tối thiểu hay không
                if ($ma_giam_gia['tong_don_hang_toi_thieu'] === null || $tong >= $ma_giam_gia['tong_don_hang_toi_thieu']) {
                    if ($ma_giam_gia['loai_giam_gia'] == 'phan_tram') {
                        $giam_gia = $tong * ($ma_giam_gia['gia_tri_giam'] / 100);
                    } else {
                        $giam_gia = $ma_giam_gia['gia_tri_giam'];
                    }
                    $ma_giam_gia_id = $ma_giam_gia['ma'];
                } else {
                    $_SESSION['error'] = "Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã giảm giá.";
                    header('Location: /view/checkout.php');
                    exit;
                }
            } else {
                $_SESSION['error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn.";
                header('Location: /view/checkout.php');
                exit;
            }
        }

        // cập nhật tổng tiền sau khi áp dụng giảm giá
        $tong_sau_giam = $tong - $giam_gia;
        if ($tong_sau_giam < 0) {
            $tong_sau_giam = 0;
        }

        // set trạng thái dựa vào phương thức thanh toán
        if ($phuong_thuc_thanh_toan == 'Chuyển khoản ngân hàng') {
            $trang_thai = 'CHO_THANH_TOAN';
        } else {
            $trang_thai = 'DANG_CHO';
        }

        // b4. tạo đơn hàng mới
        $stmt = $conn->prepare("INSERT INTO donhang (ma_khach_hang, tong, trang_thai, dia_chi_nhan_hang, giam_gia, phuong_thuc_thanh_toan, ma_giam_gia_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idssdsi", $ma_khach_hang, $tong_sau_giam, $trang_thai, $dia_chi_nhan_hang, $giam_gia, $phuong_thuc_thanh_toan, $ma_giam_gia_id);
        $stmt->execute();
        $ma_don_hang = $stmt->insert_id;

        foreach ($_SESSION['cart'] as $ma_sach => $item) {
            // Thêm chi tiết đơn hàng
            $stmt = $conn->prepare("INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $ma_don_hang, $ma_sach, $item['so_luong']);
            $stmt->execute();

            // cập nhật số lượng sách trong kho
            $stmt = $conn->prepare("UPDATE sach SET so_luong = so_luong - ? WHERE ma_sach = ?");
            $stmt->bind_param("ii", $item['so_luong'], $ma_sach);
            $stmt->execute();
        }

        // b6. cập nhật số lần sử dụng mã giảm giá
        if ($ma_giam_gia_id !== null) {
            $stmt = $conn->prepare("UPDATE ma_giam_gia SET so_lan_da_su_dung = so_lan_da_su_dung + 1 WHERE ma = ?");
            $stmt->bind_param("i", $ma_giam_gia_id);
            $stmt->execute();
        }
        if ($phuong_thuc_thanh_toan == 'COD') {
            $thong_bao = "Đơn hàng #$ma_don_hang của bạn đã được đặt hàng thành công và đang chờ xử lý.";
            $stmt = $conn->prepare("INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status) VALUES (?, ?, ?, 'Chua doc')");
            $stmt->bind_param("iis", $ma_khach_hang, $ma_don_hang, $thong_bao);
            $stmt->execute();
            $conn->commit();
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Đơn hàng của bạn đã được đặt thành công!";
            header('Location: /view/cart.php');
            exit;
        } else {
            $thong_bao = "Đơn hàng #$ma_don_hang của bạn đang chờ thanh toán qua chuyển khoản ngân hàng.";
            $stmt = $conn->prepare("INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status) VALUES (?, ?, ?, 'Chua doc')");
            $stmt->bind_param("iis", $ma_khach_hang, $ma_don_hang, $thong_bao);
            $stmt->execute();
            $conn->commit();
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Đơn hàng của bạn đã được tạo và đang chờ thanh toán.";
            header("Location: /view/order.php?id=$ma_don_hang");
            exit;
        }
    } catch (Exception $e) {
        // rollback và báo lỗi nếu có lỗi
        $conn->rollback();
        $_SESSION['error'] = "Đã xảy ra lỗi trong quá trình xử lý đơn hàng: " . $e->getMessage();
        header('Location: /view/cart.php');
        exit;
    }
} else {
    header('Location: /view/cart.php');
    exit;
}
?>
