<?php
    require '../../connect.php';
    require '../../checker/kiemtra_admin.php';
    include '../sidebar.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa khách hàng</title>
    <link rel="stylesheet" href="../../css/csuakhang.css">
</head>
<body>
<header class="header">
        <div class="logo">
            <img src="path/to/logo.png" alt="Logo">
        </div>
        
        <div class="nav-links">
            <a href="../../home.php">👤 Tài khoản</a>
        </div>
    </header>
    <h1>Chỉnh sửa khách hàng</h1>

    <form method="POST" action="">
        <label for="ten_dang_nhap">Tên đăng nhập:</label>
        <input type="text" name="ten_dang_nhap" value="<?php echo htmlspecialchars($row['ten_dang_nhap']); ?>" required><br>

        <label for="ho_va_ten">Họ và tên:</label>
        <input type="text" name="ho_va_ten" value="<?php echo htmlspecialchars($row['ho_va_ten']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br>

        <label for="so_dien_thoai">Số điện thoại:</label>
        <input type="text" name="so_dien_thoai" value="<?php echo htmlspecialchars($row['so_dien_thoai']); ?>" required><br>

        <label for="dia_chi">Địa chỉ:</label>
        <input type="text" name="dia_chi" value="<?php echo htmlspecialchars($row['dia_chi']); ?>"><br>

        <label for="dia_chi_nhan_hang">Địa chỉ nhận hàng:</label>
        <input type="text" name="dia_chi_nhan_hang" value="<?php echo htmlspecialchars($row['dia_chi_nhan_hang']); ?>"><br>

        <label for="dang_ky_nhan_ban_tin">Đăng ký nhận bản tin:</label>
        <select name="dang_ky_nhan_ban_tin">
            <option value="1" <?php if ($row['dang_ky_nhan_ban_tin'] == 1) echo 'selected'; ?>>Có</option>
            <option value="0" <?php if ($row['dang_ky_nhan_ban_tin'] == 0) echo 'selected'; ?>>Không</option>
        </select><br>

        <label for="vai_tro">Vai trò:</label>
        <select name="vai_tro">
            <option value="khachhang" <?php if ($row['vai_tro'] == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
            <option value="admin" <?php if ($row['vai_tro'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br>

        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>

