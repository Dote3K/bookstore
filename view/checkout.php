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

// Cập nhật giỏ hàng với số lượng mới từ form giỏ hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['check_discount_code'])) {
    if (isset($_POST['so_luong']) && is_array($_POST['so_luong'])) {
        foreach ($_POST['so_luong'] as $ma_sach => $so_luong) {
            $ma_sach = (int)$ma_sach;
            $so_luong = (int)$so_luong;
            if ($ma_sach > 0 && $so_luong > 0) {
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

// xử lý mã giảm giá nếu ấn kiểm tra
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check_discount_code'])) {
    $ma_giam_gia_code = isset($_POST['ma_giam_gia']) ? trim($_POST['ma_giam_gia']) : '';
    if (!empty($ma_giam_gia_code)) {
        // kiểm tra mã trong cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM ma_giam_gia WHERE ma_giam = ? AND trang_thai = 'kich_hoat' AND (ngay_bat_dau IS NULL OR ngay_bat_dau <= NOW()) AND (ngay_ket_thuc IS NULL OR ngay_ket_thuc >= NOW()) AND (so_lan_su_dung_toi_da IS NULL OR so_lan_da_su_dung < so_lan_su_dung_toi_da)");
        $stmt->bind_param("s", $ma_giam_gia_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $ma_giam_gia = $result->fetch_assoc();

        if ($ma_giam_gia) {
            // tính lại giá tiền giỏ hàng khi mã hợp lệ
            $tong = 0;
            foreach ($_SESSION['cart'] as $item) {
                $tong += $item['gia_ban'] * $item['so_luong'];
            }
            // kiểm tra giá trị tối thiểu và tính giá trị giảm
            if ($ma_giam_gia['tong_don_hang_toi_thieu'] === null || $tong >= $ma_giam_gia['tong_don_hang_toi_thieu']) {
                if ($ma_giam_gia['loai_giam_gia'] == 'phan_tram') {
                    $giam_gia = $tong * ($ma_giam_gia['gia_tri_giam'] / 100);
                } else {
                    $giam_gia = $ma_giam_gia['gia_tri_giam'];
                }
                // lưu thông tin giảm giá
                $_SESSION['discount'] = [
                    'ma_giam_gia_id' => $ma_giam_gia['ma'],
                    'ma_giam_gia_code' => $ma_giam_gia['ma_giam'],
                    'giam_gia' => $giam_gia
                ];
                $_SESSION['success'] = "Mã giảm giá đã được áp dụng.";
            } else {
                $_SESSION['error'] = "Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã giảm giá.";
                unset($_SESSION['discount']);
            }
        } else {
            // mã giảm giá không hợp lệ
            $_SESSION['error'] = "Mã giảm giá không hợp lệ hoặc đã hết hạn.";
            unset($_SESSION['discount']);
        }
    } else {
        $_SESSION['error'] = "Vui lòng nhập mã giảm giá.";
        unset($_SESSION['discount']);
    }
    header('Location: checkout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Book Store - Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer a {
            color: #ffcc33;
            text-decoration: none;
        }

        .checkout-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .order-summary table img {
            width: 50px;
            height: auto;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="checkout-container">
        <h1 class="text-center mb-4">Thanh toán</h1>
        <div class="mb-3">
            <a href="cart.php" class="btn btn-secondary">
                <i class="fas fa-shopping-cart"></i> 🛒 Quay lại giỏ hàng
            </a>
        </div>

        <?php if ($thong_bao_thanh_cong): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($thong_bao_thanh_cong); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($thong_bao_loi): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($thong_bao_loi); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <!-- thông tin giao hàng -->
            <div class="form-section">
                <h2 class="mb-3">Thông tin giao hàng</h2>
                <div class="mb-3">
                    <label for="ho_va_ten" class="form-label"><strong>Họ và Tên:</strong></label>
                    <input type="text" class="form-control" id="ho_va_ten" name="ho_va_ten"
                           value="<?php echo htmlspecialchars($khach_hang['ho_va_ten']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="gioi_tinh" class="form-label"><strong>Giới tính:</strong></label>
                    <select class="form-select" id="gioi_tinh" name="gioi_tinh" required>
                        <option value="Nam" <?php echo ($khach_hang['gioi_tinh'] == 'Nam') ? 'selected' : ''; ?>>
                            Nam
                        </option>
                        <option value="Nữ" <?php echo ($khach_hang['gioi_tinh'] == 'Nữ') ? 'selected' : ''; ?>>
                            Nữ
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ngay_sinh" class="form-label"><strong>Ngày sinh:</strong></label>
                    <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh"
                           value="<?php echo htmlspecialchars($khach_hang['ngay_sinh']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="dia_chi_nhan_hang" class="form-label"><strong>Địa chỉ nhận hàng:</strong></label>
                    <textarea class="form-control" id="dia_chi_nhan_hang" name="dia_chi_nhan_hang" rows="3"
                              required><?php echo htmlspecialchars($khach_hang['dia_chi_nhan_hang']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="so_dien_thoai" class="form-label"><strong>Số điện thoại:</strong></label>
                    <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                           value="<?php echo htmlspecialchars($khach_hang['so_dien_thoai']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><strong>Email:</strong></label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?php echo htmlspecialchars($khach_hang['email']); ?>" required>
                </div>
            </div>

            <!-- thông tin đơn hàng -->
            <div class="form-section">
                <h2 class="mb-3">Thông tin đơn hàng</h2>
                <div class="table-responsive order-summary">
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Ảnh bìa</th>
                            <th>Tên sách</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tong_tien = 0;
                        foreach ($_SESSION['cart'] as $ma_sach => $item):
                            $ten_sach = $item['ten_sach'] ?? 'Không tìm thấy tên sách';
                            $gia_ban = $item['gia_ban'] ?? 0;
                            $anh_bia = $item['anh_bia'] ?? '';
                            $so_luong = $item['so_luong'] ?? 1;
                            $tong_tien_san_pham = $gia_ban * $so_luong;
                            $tong_tien += $tong_tien_san_pham;
                            ?>
                            <tr>
                                <td>
                                    <img src="/admin/ql_sach/sach/<?php echo htmlspecialchars($anh_bia); ?>"
                                         alt="<?php echo htmlspecialchars($ten_sach); ?>" width="50">
                                </td>
                                <td><?php echo htmlspecialchars($ten_sach); ?></td>
                                <td><?php echo number_format($gia_ban, 0, ',', '.'); ?> VND</td>
                                <td><?php echo htmlspecialchars($so_luong); ?></td>
                                <td><?php echo number_format($tong_tien_san_pham, 0, ',', '.'); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong><?php echo number_format($tong_tien, 0, ',', '.'); ?> VND</strong></td>
                        </tr>
                        <?php
                        if (isset($_SESSION['discount'])) {
                            $giam_gia = $_SESSION['discount']['giam_gia'];
                            $tong_tien_sau_giam = $tong_tien - $giam_gia;
                            if ($tong_tien_sau_giam < 0) {
                                $tong_tien_sau_giam = 0;
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Giảm giá (<?php echo htmlspecialchars($_SESSION['discount']['ma_giam_gia_code']); ?>):</strong></td>
                                <td><strong>- <?php echo number_format($giam_gia, 0, ',', '.'); ?> VND</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Tổng thanh toán:</strong></td>
                                <td><strong><?php echo number_format($tong_tien_sau_giam, 0, ',', '.'); ?> VND</strong></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!-- form nhập mã giảm giá -->
                <div class="mb-3">
                    <label for="ma_giam_gia" class="form-label"><strong>Mã giảm giá:</strong></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="ma_giam_gia" name="ma_giam_gia"
                               placeholder="Nhập mã giảm giá nếu có"
                               value="<?php echo isset($_SESSION['discount']['ma_giam_gia_code']) ? htmlspecialchars($_SESSION['discount']['ma_giam_gia_code']) : ''; ?>">
                        <button type="submit" name="check_discount_code" class="btn btn-primary">Kiểm tra</button>
                    </div>
                </div>
            </div>

            <!-- phương thức thanh toán -->
            <div class="form-section">
                <h2 class="mb-3">Phương thức thanh toán</h2>
                <div class="mb-3">
                    <label for="phuong_thuc_thanh_toan" class="form-label"><strong>Chọn phương thức thanh toán:</strong></label>
                    <select class="form-select" id="phuong_thuc_thanh_toan" name="phuong_thuc_thanh_toan" required>
                        <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                        <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100" formaction="/DAO/process_checkout.php">
                <i class="fas fa-check-circle"></i> Đặt hàng
            </button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2024 BookStore. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </div>
</footer>
</body>
</html>
