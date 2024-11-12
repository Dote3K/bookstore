<?php
// cart.php
require_once '../checker/kiemtra_login.php';
require '../connect.php';


$thong_bao_thanh_cong = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$thong_bao_loi = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .gio-hang-container {
            width: 90%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        .actions {
            text-align: right;
        }
        .actions button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions button:hover {
            background-color: #0069d9;
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
        .empty {
            text-align: center;
            font-size: 1.2em;
            color: #555;
        }
    </style>
</head>
<body>
<div class="gio-hang-container">
    <h1>Giỏ hàng của bạn</h1>
    <a href="/index.php">🔙 Tiếp tục mua sắm</a>

    <?php if ($thong_bao_thanh_cong): ?>
        <p class="message"><?php echo htmlspecialchars($thong_bao_thanh_cong); ?></p>
    <?php endif; ?>

    <?php if ($thong_bao_loi): ?>
        <p class="error"><?php echo htmlspecialchars($thong_bao_loi); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <form action="checkout.php" method="post" id="form-cart">
            <table>
                <tr>
                    <th>Ảnh bìa</th>
                    <th>Tên sách</th>
                    <th>Giá bán</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
                <?php
                $tong_tien = 0;
                foreach ($_SESSION['cart'] as $ma_sach => $item):
                    // Kiểm tra xem các khóa cần thiết có tồn tại không
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
                        <td>
                            <!-- Input số lượng với dữ liệu được gửi qua form -->
                            <input type="number" name="so_luong[<?php echo $ma_sach; ?>]" value="<?php echo $so_luong; ?>" min="1" max="100" required class="so-luong-input">
                        </td>
                        <td class="tong-tien-san-pham"><?php echo number_format($tong_tien_san_pham, 0, ',', '.'); ?> VND</td>
                        <td>
                            <a href="remove_from_cart.php?ma_sach=<?php echo $ma_sach; ?>" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">🗑️ Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                    <td colspan="2" id="tong-tien"><?php echo number_format($tong_tien, 0, ',', '.'); ?> VND</td>
                </tr>
            </table>
            <div class="actions">
                <button type="submit">🛒 Thanh toán</button>
            </div>
        </form>
        <script>
            // Hàm định dạng số với dấu chấm phân cách hàng nghìn
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Hàm tính tổng đơn hàng
            function tinhTong() {
                let tongTien = 0;
                document.querySelectorAll('.so-luong-input').forEach(function(input) {
                    let soLuong = parseInt(input.value);
                    // Lấy giá bán từ cột thứ 3 (giá bán)
                    let giaBanText = input.parentElement.parentElement.querySelector('td:nth-child(3)').innerText;
                    let giaBan = parseInt(giaBanText.replace(/\./g, '').replace(' VND', ''));
                    let tongSanPham = soLuong * giaBan;
                    tongTien += tongSanPham;
                    // Cập nhật tổng tiền sản phẩm
                    input.parentElement.parentElement.querySelector('.tong-tien-san-pham').innerText = formatNumber(tongSanPham) + ' VND';
                });
                // Cập nhật tổng tiền đơn hàng
                document.getElementById('tong-tien').innerText = formatNumber(tongTien) + ' VND';
            }

            // Thêm sự kiện 'input' cho tất cả các trường số lượng
            document.querySelectorAll('.so-luong-input').forEach(function(input) {
                input.addEventListener('input', tinhTong);
            });
        </script>
    <?php else: ?>
        <p class="empty">Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
</div>
</body>
</html>
