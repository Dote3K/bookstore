<?php
require '../connect.php';
require '../checker/kiemtra_login.php';

// Khởi tạo biến để lưu thông báo lỗi hoặc thành công
$message = '';
$message_type = ''; // 'success' hoặc 'danger'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matKhauHienTai = $_POST['matKhauHienTai'];
    $matKhauMoi = $_POST['matKhauMoi'];
    $xacNhanMatKhauMoi = $_POST['xacNhanMatKhauMoi'];
    $ma_khach_hang = $_SESSION['ma_khach_hang'];

    if ($matKhauMoi !== $xacNhanMatKhauMoi) {
        $message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
        $message_type = "danger";
    } else {
        $stmt = $conn->prepare("SELECT mat_khau FROM khachhang WHERE ma_khach_hang = ?");
        $stmt->bind_param("i", $ma_khach_hang);
        $stmt->execute();
        $result = $stmt->get_result();
        $khachhang = $result->fetch_assoc();

        if ($khachhang && password_verify($matKhauHienTai, $khachhang['mat_khau'])) {
            $maHoaMatKhauMoi = password_hash($matKhauMoi, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE khachhang SET mat_khau = ? WHERE ma_khach_hang = ?");
            $stmt->bind_param("si", $maHoaMatKhauMoi, $ma_khach_hang);
            if ($stmt->execute()) {
                $message = "Đổi mật khẩu thành công!";
                $message_type = "success";
            } else {
                $message = "Lỗi: " . $conn->error;
                $message_type = "danger";
            }
        } else {
            $message = "Mật khẩu hiện tại không đúng.";
            $message_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store - Đổi Mật Khẩu</title>
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

        .container {
            max-width: 600px;
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

        .alert-custom {
            max-width: 600px;
            margin: 20px auto;
        }

        .card-header {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
            color: #ffffff;
            font-weight: bold;
            font-size: 1.25rem;
        }
    </style>
</head>
<body>
<?php include '../view/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center text-primary mb-4">Đổi Mật Khẩu</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show alert-custom" role="alert">
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card p-4">
        <form method="POST" action="">
            <!-- Mật khẩu hiện tại -->
            <div class="mb-3">
                <label for="matKhauHienTai" class="form-label"><strong>Mật khẩu hiện tại:</strong></label>
                <input type="password" class="form-control" id="matKhauHienTai" name="matKhauHienTai" required>
            </div>

            <!-- Mật khẩu mới -->
            <div class="mb-3">
                <label for="matKhauMoi" class="form-label"><strong>Mật khẩu mới:</strong></label>
                <input type="password" class="form-control" id="matKhauMoi" name="matKhauMoi" required>
            </div>

            <!-- Xác nhận mật khẩu mới -->
            <div class="mb-3">
                <label for="xacNhanMatKhauMoi" class="form-label"><strong>Xác nhận mật khẩu mới:</strong></label>
                <input type="password" class="form-control" id="xacNhanMatKhauMoi" name="xacNhanMatKhauMoi" required>
            </div>

            <!-- Nút Submit và Hủy -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-key"></i> Đổi Mật Khẩu
                </button>
                <a href="hienThi.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay Lại
                </a>
            </div>
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
