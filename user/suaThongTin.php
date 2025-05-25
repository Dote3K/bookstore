<?php
require '../connect.php';
require '../checker/kiemtra_login.php';

// Khởi tạo biến để lưu thông báo lỗi hoặc thành công
$message = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM khachhang WHERE ma_khach_hang=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $khachhang = $result->fetch_assoc();
    if (!$khachhang) {
        // Nếu không tìm thấy khách hàng, chuyển hướng về trang hiển thị
        header('Location: hienThi.php');
        exit();
    }
} else {
    // Nếu không có id, chuyển hướng về trang hiển thị
    header('Location: hienThi.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form và kiểm tra
    $ma_khach_hang = $_POST['ma_khach_hang'];
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $ho_va_ten = $_POST['ho_va_ten'];
    $gioi_tinh = $_POST['gioi_tinh'];
    $ngay_sinh = $_POST['ngay_sinh'];
    $dia_chi = $_POST['dia_chi'];
    $dia_chi_nhan_hang = $_POST['dia_chi_nhan_hang'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $email = $_POST['email'];

    // Kiểm tra và xử lý các trường bắt buộc
    if (!empty($ho_va_ten) && !empty($gioi_tinh) && !empty($ngay_sinh) && !empty($so_dien_thoai) && !empty($email)) {
        // Sử dụng prepared statement để cập nhật thông tin
        $sql = "UPDATE khachhang SET ho_va_ten=?, gioi_tinh=?, ngay_sinh=?, dia_chi=?, dia_chi_nhan_hang=?, so_dien_thoai=?, email=? WHERE ma_khach_hang=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $ho_va_ten, $gioi_tinh, $ngay_sinh, $dia_chi, $dia_chi_nhan_hang, $so_dien_thoai, $email, $ma_khach_hang);

        if ($stmt->execute()) {
            // Cập nhật thành công, chuyển hướng về trang hiển thị với thông báo thành công
            header('Location: hienThi.php?success=1');
            exit();
        } else {
            $message = "Lỗi: " . $conn->error;
        }
    } else {
        $message = "Vui lòng điền đầy đủ các trường bắt buộc.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin</title>
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

        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e60000 !important;
            border-color: #e60000 !important;
        }

        .alert-custom {
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <?php include '../view/header.php'; ?>

    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Sửa Thông Tin</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-danger alert-custom" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST" action="">
                <!-- ID khách hàng (ẩn) -->
                <input type="hidden" name="ma_khach_hang" value="<?= htmlspecialchars($khachhang['ma_khach_hang']) ?>">

                <!-- Tên đăng nhập (readonly) -->
                <div class="mb-3">
                    <label for="ten_dang_nhap" class="form-label"><strong>Tên đăng nhập:</strong></label>
                    <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" value="<?= htmlspecialchars($khachhang['ten_dang_nhap']) ?>" readonly>
                </div>

                <!-- Họ và tên -->
                <div class="mb-3">
                    <label for="ho_va_ten" class="form-label"><strong>Họ và tên:</strong></label>
                    <input type="text" class="form-control" id="ho_va_ten" name="ho_va_ten" value="<?= htmlspecialchars($khachhang['ho_va_ten']) ?>" required>
                </div>

                <!-- Giới tính -->
                <div class="mb-3">
                    <label for="gioi_tinh" class="form-label"><strong>Giới tính:</strong></label>
                    <select class="form-select" id="gioi_tinh" name="gioi_tinh" required>
                        <option value="Nam" <?= $khachhang['gioi_tinh'] === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?= $khachhang['gioi_tinh'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                        <option value="Khác" <?= $khachhang['gioi_tinh'] === 'Khác' ? 'selected' : ''; ?>>Khác</option>
                    </select>
                </div>

                <!-- Ngày sinh -->
                <div class="mb-3">
                    <label for="ngay_sinh" class="form-label"><strong>Ngày sinh:</strong></label>
                    <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" value="<?= htmlspecialchars($khachhang['ngay_sinh']) ?>" required>
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3">
                    <label for="dia_chi" class="form-label"><strong>Địa chỉ:</strong></label>
                    <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="<?= htmlspecialchars($khachhang['dia_chi']) ?>">
                </div>

                <!-- Địa chỉ nhận hàng -->
                <div class="mb-3">
                    <label for="dia_chi_nhan_hang" class="form-label"><strong>Địa chỉ nhận hàng:</strong></label>
                    <input type="text" class="form-control" id="dia_chi_nhan_hang" name="dia_chi_nhan_hang" value="<?= htmlspecialchars($khachhang['dia_chi_nhan_hang']) ?>" required>
                </div>

                <!-- Số điện thoại -->
                <div class="mb-3">
                    <label for="so_dien_thoai" class="form-label"><strong>Số điện thoại:</strong></label>
                    <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="<?= htmlspecialchars($khachhang['so_dien_thoai']) ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label"><strong>Email:</strong></label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($khachhang['email']) ?>" required>
                </div>

                <!-- Nút Submit và Hủy -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="hienThi.php" class="btn btn-secondary">Hủy</a>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
</body>

</html>