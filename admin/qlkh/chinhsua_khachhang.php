<?php
require '../../connect.php';
require '../../checker/kiemtra_admin.php';

$id = $_GET['id'];
$sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $ho_va_ten = $_POST['ho_va_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    $dia_chi_nhan_hang = $_POST['dia_chi_nhan_hang'];
    $dang_ky_nhan_ban_tin = $_POST['dang_ky_nhan_ban_tin'];
    $vai_tro = $_POST['vai_tro'];

    // Kiểm tra trùng tên đăng nhập (ngoại trừ tài khoản hiện tại)
    $check_username = "SELECT * FROM khachhang WHERE ten_dang_nhap = ? AND ma_khach_hang != ?";
    $stmt_check = $conn->prepare($check_username);
    $stmt_check->bind_param("si", $ten_dang_nhap, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.');</script>";
    } else {
        // Cập nhật thông tin khách hàng
        $sql_update = "UPDATE khachhang SET ten_dang_nhap = ?, ho_va_ten = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, dia_chi_nhan_hang = ?, dang_ky_nhan_ban_tin = ?, vai_tro = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssssi", $ten_dang_nhap, $ho_va_ten, $email, $so_dien_thoai, $dia_chi, $dia_chi_nhan_hang, $dang_ky_nhan_ban_tin, $vai_tro, $id);
        if ($stmt_update->execute()) {
            echo "<script>alert('Cập nhật khách hàng thành công.'); window.location='quanlikhachhang.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa khách hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        /* Các style tùy chỉnh */

        .header {
            background-color: #e9ecef;
            padding: 10px;
        }
        .header .nav-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }
        .header .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <?php include '../sidebar.php'; ?>
        </nav>
        <!-- Nội dung chính -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header -->
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Chỉnh sửa khách hàng</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="POST">
                    <div class="mb-3">
                        <label for="ten_dang_nhap" class="form-label">Tên đăng nhập:</label>
                        <input type="text" name="ten_dang_nhap" id="ten_dang_nhap" class="form-control" value="<?php echo htmlspecialchars($row['ten_dang_nhap']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="ho_va_ten" class="form-label">Họ và tên:</label>
                        <input type="text" name="ho_va_ten" id="ho_va_ten" class="form-control" value="<?php echo htmlspecialchars($row['ho_va_ten']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_dien_thoai" class="form-label">Số điện thoại:</label>
                        <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-control" value="<?php echo htmlspecialchars($row['so_dien_thoai']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ:</label>
                        <input type="text" name="dia_chi" id="dia_chi" class="form-control" value="<?php echo htmlspecialchars($row['dia_chi']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="dia_chi_nhan_hang" class="form-label">Địa chỉ nhận hàng:</label>
                        <input type="text" name="dia_chi_nhan_hang" id="dia_chi_nhan_hang" class="form-control" value="<?php echo htmlspecialchars($row['dia_chi_nhan_hang']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="dang_ky_nhan_ban_tin" class="form-label">Đăng ký nhận bản tin:</label>
                        <select name="dang_ky_nhan_ban_tin" id="dang_ky_nhan_ban_tin" class="form-select">
                            <option value="1" <?php if ($row['dang_ky_nhan_ban_tin'] == 1) echo 'selected'; ?>>Có</option>
                            <option value="0" <?php if ($row['dang_ky_nhan_ban_tin'] == 0) echo 'selected'; ?>>Không</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="vai_tro" class="form-label">Vai trò:</label>
                        <select name="vai_tro" id="vai_tro" class="form-select">
                            <option value="khachhang" <?php if ($row['vai_tro'] == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
                            <option value="admin" <?php if ($row['vai_tro'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="quanlikhachhang.php" class="btn btn-secondary">Trở về trang quản lý khách hàng</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
