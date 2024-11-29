<?php
// cart.php
require_once '../checker/kiemtra_login.php';
require '../connect.php';

// lưu thông báo thành công hoặc lỗi
$thong_bao_thanh_cong = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$thong_bao_loi = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store - Giỏ hàng của bạn</title>
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

        .gio-hang-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table img {
            width: 50px;
            height: auto;
        }

        .btn-custom {
            background-color: #ff6b6b;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #ff4b4b;
            color: #ffffff;
        }

        .btn-secondary-custom {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-secondary-custom:hover {
            background-color: #5a6268;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #e60000 !important;
            border-color: #e60000 !important;
        }

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<div class="container my-5">
    <div class="gio-hang-container">
        <h1 class="text-center mb-4">Giỏ hàng của bạn</h1>
        <div class="mb-3">
            <a href="/index.php" class="btn btn-secondary-custom">
                <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
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

        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <form action="checkout.php" method="post" id="form-cart">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>Ảnh bìa</th>
                            <th>Tên sách</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
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
                                    <img src="/admin/ql_sach/sach/<?php echo htmlspecialchars($anh_bia); ?>" alt="<?php echo htmlspecialchars($ten_sach); ?>">
                                </td>
                                <td><?php echo htmlspecialchars($ten_sach); ?></td>
                                <td><?php echo number_format($gia_ban, 0, ',', '.'); ?> VND</td>
                                <td>
                                    <input type="number" name="so_luong[<?php echo htmlspecialchars($ma_sach); ?>]" value="<?php echo htmlspecialchars($so_luong); ?>" min="1" max="100" required class="form-control so-luong-input">
                                </td>
                                <td class="tong-tien-san-pham"><?php echo number_format($tong_tien_san_pham, 0, ',', '.'); ?> VND</td>
                                <td>
                                    <a href="../DAO/remove_from_cart.php?ma_sach=<?php echo htmlspecialchars($ma_sach); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td colspan="2" id="tong-tien"><strong><?php echo number_format($tong_tien, 0, ',', '.'); ?> VND</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Thanh toán
                    </button>
                </div>
            </form>
            <script>
                // định dạng số với dấu chấm phân cách hàng nghìn
                function formatNumber(num) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                // Hàm tính tổng đơn hàng
                function tinhTong() {
                    let tongTien = 0;
                    document.querySelectorAll('.so-luong-input').forEach(function(input) {
                        let soLuong = parseInt(input.value);
                        // Lấy giá bán
                        let giaBanText = input.parentElement.parentElement.querySelector('td:nth-child(3)').innerText;
                        let giaBan = parseInt(giaBanText.replace(/\./g, '').replace(' VND', ''));
                        let tongSanPham = soLuong * giaBan;
                        tongTien += tongSanPham;
                        // Cập nhật tổng tiền sản phẩm
                        input.parentElement.parentElement.querySelector('.tong-tien-san-pham').innerText = formatNumber(tongSanPham) + ' VND';
                    });
                    // Cập nhật tổng tiền đơn hàng
                    document.getElementById('tong-tien').innerHTML = '<strong>' + formatNumber(tongTien) + ' VND</strong>';
                }

                // tính tổng mo
                document.querySelectorAll('.so-luong-input').forEach(function(input) {
                    input.addEventListener('input', tinhTong);
                });
            </script>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                Giỏ hàng của bạn đang trống.
            </div>
        <?php endif; ?>
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
