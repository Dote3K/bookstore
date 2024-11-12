<?php
require '../connect.php';
include '../checker/kiemtra_login.php';

$ma_khach_hang = $_SESSION['ma_khach_hang'];
$sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store - Thông Tin Tài Khoản</title>
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

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
            color: #ffffff;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
        }

        .list-group-item strong {
            width: 200px;
            display: inline-block;
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

        @media (max-width: 576px) {
            .list-group-item strong {
                width: 100px;
            }
        }
    </style>
    <script>
        function xacNhanXoa(id) {
            var kq = confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tài khoản này không?');
            if (kq) {
                window.location.href = 'xoa.php?id=' + id;
            }
        }
    </script>
</head>

<body>
<?php include '../view/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center text-primary mb-4">THÔNG TIN TÀI KHOẢN</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="card mb-4">
                <div class="card-header">
                    Thông Tin Cá Nhân
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Tên đăng nhập:</strong> <?php echo htmlspecialchars($row['ten_dang_nhap'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Họ và tên:</strong> <?php echo htmlspecialchars($row['ho_va_ten'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Giới tính:</strong> <?php echo htmlspecialchars($row["gioi_tinh"] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Ngày sinh:</strong> <?php echo htmlspecialchars($row['ngay_sinh'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($row["dia_chi"] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Địa chỉ nhận hàng:</strong> <?php echo htmlspecialchars($row['dia_chi_nhan_hang'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($row['so_dien_thoai'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($row['email'] ?? ''); ?></li>
                    <li class="list-group-item"><strong>Đăng ký nhận bản tin:</strong>
                        <?php
                        // Kiểm tra và hiển thị "Có" hoặc "Không"
                        if (isset($row['dang_ky_nhan_ban_tin'])) {
                            echo htmlspecialchars($row['dang_ky_nhan_ban_tin']) ? 'Có' : 'Không';
                        } else {
                            echo 'Không';
                        }
                        ?>
                    </li>
                </ul>
            </div>

            <div class="text-center mb-4">
                <a href="suaThongTin.php?id=<?php echo htmlspecialchars($row['ma_khach_hang']); ?>" class="btn btn-custom mb-2">
                    <i class="fas fa-edit"></i> Sửa Thông Tin
                </a>
                <a href="doiMatKhau.php" class="btn btn-custom mb-2">
                    <i class="fas fa-key"></i> Đổi Mật Khẩu
                </a>
                <a href="javascript:void(0);" onclick="xacNhanXoa(<?php echo htmlspecialchars($row['ma_khach_hang']); ?>);" class="btn btn-danger mb-2">
                    <i class="fas fa-trash-alt"></i> Xóa Tài Khoản
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            Không tìm thấy kết quả.<br>
            Vui lòng <a href="../view/login.php" class="alert-link">đăng nhập</a>.
        </div>
    <?php endif; ?>

    <?php $stmt->close(); ?>
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
