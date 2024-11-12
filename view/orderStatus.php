<?php
session_start();
require_once '../model/donhang.php'; 
require_once '../DAO/donhangDAO.php';
require_once '../DAO/sachDAO.php';
require_once '../DAO/khachhangDAO.php';



// Kiểm tra đăng nhập
if (!isset($_SESSION['ma_khach_hang'])) {
    header('Location: login.php');
    exit;
}

// Kiểm tra xem có dữ liệu selected_books trong session hoặc form gửi lên không
if (isset($_SESSION['selected_books'])) {
    $selected_books = $_SESSION['selected_books'];
} elseif (isset($_POST['selected_books'])) {
    $selected_books = $_POST['selected_books'];
    $_SESSION['selected_books'] = $selected_books;  // Lưu lại vào session để sử dụng sau này
} else {
    echo "Không có sản phẩm nào được chọn.";
    exit;
}



// Lấy thông tin đơn hàng từ session
$order_id = $_SESSION['order_id'] ?? null;
$total_cost = $_SESSION['total_cost'] ?? null;
$ma_khach_hang = $_SESSION['ma_khach_hang'];

// Khởi tạo đối tượng DAO
$sachDAO = new sachDAO();
$donHangDAO = new donHangDAO();
$khachHangDAO = new khachHangDAO();

try {
    // Hiển thị thông tin các sản phẩm đã chọn
    // echo "<h2>Sản phẩm đã chọn</h2>";
    // foreach ($selected_books as $book_id) {
    //     $book_info = $sachDAO->getBookById($book_id); 
    //     if ($book_info) {
    //         echo "<p>Tên sách: " . htmlspecialchars($book_info['ten_sach']) . "</p>";
    //         echo "<p>Giá: " . htmlspecialchars($book_info['gia_ban']). "</p>";
    //     } else {
    //         echo "<p>Không tìm thấy thông tin sách với mã: $book_id</p>";
    //     }
    // }

    // Lấy danh sách đơn hàng theo mã khách hàng
    $donHangs = $donHangDAO->selectByMaKhachHang($ma_khach_hang);

} catch (Exception $e) {
    echo "<p>Đã xảy ra lỗi: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái đơn hàng</title>
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
    }

    .navbar {
        background: linear-gradient(45deg, #ff6b6b, #ffcc33);
    }

    .navbar-brand,
    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-weight: bold;
    }

    .carousel-item img {
        height: 450px;
        object-fit: cover;
        filter: brightness(85%);
    }

    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 1rem;
        border-radius: 8px;
    }

    .card {
        background-color: #ffffff;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .card-title {
        color: #ff6b6b;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #ff6b6b;
        border: none;
        transition: background-color 0.3s;
    }

    .footer {
        background-color: #333333;
        color: #ffffff;
        padding: 1.5rem 0;
    }

    .footer a {
        color: #ffcc33;
        text-decoration: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .text-center {
        text-align: center;
    }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">TRẠNG THÁI ĐƠN HÀNG</h1>

        <?php if (empty($donHangs)): ?>
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
        <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donHangs as $donHang): 
                    $tenKhachHang = $khachHangDAO->getCustomerNameById($donHang->getMaKhachHang());
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($donHang->getMaDonHang(), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($tenKhachHang, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($donHang->getNgayDatHang())); ?></td>
                    <td><?php echo htmlspecialchars($donHang->getDiaChiNhanHang(), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($donHang->getTrangThai(), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo number_format($donHang->getTong(), 0, ',', '.') . " VND"; ?></td>
                    <td>
                        <a
                            href="orderDetails.php?ma_don_hang=<?php echo htmlspecialchars($donHang->getMaDonHang(), ENT_QUOTES, 'UTF-8'); ?>">Xem
                            chi tiết</a> |
                        <a
                            href="cancelOrder.php?ma_don_hang=<?php echo htmlspecialchars($donHang->getMaDonHang(), ENT_QUOTES, 'UTF-8'); ?>">Hủy
                            đơn hàng</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2023 BookStore. All Rights Reserved.</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

</body>

</html>