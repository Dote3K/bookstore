<?php
// checkout.php
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
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store - Thanh toán</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom Styles -->
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

        <form action="process_checkout.php" method="post">
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
                            Nam</option>
                        <option value="Nữ" <?php echo ($khach_hang['gioi_tinh'] == 'Nữ') ? 'selected' : ''; ?>>
                            Nữ</option>
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
                            $ten_sach = isset($item['ten_sach']) ? $item['ten_sach'] : 'N/A';
                            $gia_ban = isset($item['gia_ban']) ? $item['gia_ban'] : 0;
                            $anh_bia = isset($item['anh_bia']) ? $item['anh_bia'] : 'default.jpg';
                            $so_luong = isset($item['so_luong']) ? $item['so_luong'] : 1;
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
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-check-circle"></i> Đặt hàng
            </button>
        </form>
    </div>
</div>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2023 BookStore. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </div>
</footer>
</body>

</html>
