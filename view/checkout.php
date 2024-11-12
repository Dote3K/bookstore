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

// cập nhật giỏ hàng với số lượng mới từ form giỏ hàng
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
    <title>Thanh toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .checkout-container {
            width: 60%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        h2 {
            margin-top: 0;
            color: #007bff;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: green;
            font-weight: bold;
        }
        .error {
            text-align: center;
            margin-bottom: 20px;
            color: red;
            font-weight: bold;
        }
        .order-summary {
            margin-top: 20px;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-summary th, .order-summary td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .order-summary th {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="checkout-container">
    <h1>Thanh toán</h1>
    <a href="cart.php">🛒 Quay lại giỏ hàng</a>

    <?php if ($thong_bao_thanh_cong): ?>
        <p class="message"><?php echo htmlspecialchars($thong_bao_thanh_cong); ?></p>
    <?php endif; ?>

    <?php if ($thong_bao_loi): ?>
        <p class="error"><?php echo htmlspecialchars($thong_bao_loi); ?></p>
    <?php endif; ?>

    <form action="process_checkout.php" method="post">
        <h2>Thông tin giao hàng</h2>
        <label for="ho_va_ten">Họ và Tên:</label>
        <input type="text" id="ho_va_ten" name="ho_va_ten" value="<?php echo htmlspecialchars($khach_hang['ho_va_ten']); ?>" required>

        <label for="gioi_tinh">Giới tính:</label>
        <select id="gioi_tinh" name="gioi_tinh">
            <option value="Nam" <?php echo ($khach_hang['gioi_tinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
            <option value="Nữ" <?php echo ($khach_hang['gioi_tinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
        </select>

        <label for="ngay_sinh">Ngày sinh:</label>
        <input type="date" id="ngay_sinh" name="ngay_sinh" value="<?php echo $khach_hang['ngay_sinh']; ?>">

        <label for="dia_chi_nhan_hang">Địa chỉ nhận hàng:</label>
        <textarea id="dia_chi_nhan_hang" name="dia_chi_nhan_hang" rows="3" required><?php echo htmlspecialchars($khach_hang['dia_chi_nhan_hang']); ?></textarea>

        <label for="so_dien_thoai">Số điện thoại:</label>
        <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo htmlspecialchars($khach_hang['so_dien_thoai']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($khach_hang['email']); ?>" required>

        <h2>Thông tin đơn hàng</h2>
        <div class="order-summary">
            <table>
                <tr>
                    <th>Ảnh bìa</th>
                    <th>Tên sách</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>
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
                            <img src="assets/images/<?php echo htmlspecialchars($anh_bia); ?>" alt="<?php echo htmlspecialchars($ten_sach); ?>" width="50">
                        </td>
                        <td><?php echo htmlspecialchars($ten_sach); ?></td>
                        <td><?php echo number_format($gia_ban, 0, ',', '.'); ?> VND</td>
                        <td><?php echo $so_luong; ?></td>
                        <td><?php echo number_format($tong_tien_san_pham, 0, ',', '.'); ?> VND</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                    <td><strong><?php echo number_format($tong_tien, 0, ',', '.'); ?> VND</strong></td>
                </tr>
            </table>
        </div>


        <button type="submit">Đặt hàng</button>
    </form>
</div>
</body>
</html>
