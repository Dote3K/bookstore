<?php
require '../../connect.php';
require '../../checker/kiemtra_admin.php';

// Xử lý tìm kiếm và lọc theo vai trò
$search_query = '';
$role_filter = '';
if (isset($_GET['search']) || isset($_GET['role'])) {
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';
    $role_filter = isset($_GET['role']) ? $_GET['role'] : '';

    $sql = "SELECT * FROM khachhang WHERE (ten_dang_nhap LIKE ? OR ho_va_ten LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?)";

    if (!empty($role_filter)) {
        $sql .= " AND vai_tro = ?";
    }

    $stmt = $conn->prepare($sql);
    $search_keyword = "%$search_query%";

    if (!empty($role_filter)) {
        $stmt->bind_param("sssss", $search_keyword, $search_keyword, $search_keyword, $search_keyword, $role_filter);
    } else {
        $stmt->bind_param("ssss", $search_keyword, $search_keyword, $search_keyword, $search_keyword);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM khachhang";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        /* Các style tùy chỉnh */
        .table thead {
            background-color: #4da6ff; /* Màu xanh lam nhạt */
            color: white;
        }
        .sidebar {
            background-color: #f8f9fa;
        }
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
                <h1>Quản lý khách hàng</h1>

            </header>

            <!-- Form tìm kiếm và lọc -->
            <form class="row g-3 mt-3 mb-3" method="GET" action="quanlikhachhang.php">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm khách hàng..." value="<?php echo htmlspecialchars($search_query); ?>">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Tất cả vai trò</option>
                        <option value="admin" <?php if ($role_filter == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="khachhang" <?php if ($role_filter == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary">Tìm kiếm & Lọc</button>
                    <a href="quanlikhachhang.php" class="btn btn-outline-secondary">Hiển thị tất cả</a>
                </div>
            </form>

            <!-- Bảng hiển thị khách hàng -->
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Địa chỉ nhận hàng</th>
                        <th>Đăng ký nhận bản tin</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                            <td>{$row['ma_khach_hang']}</td>
                                            <td>{$row['ten_dang_nhap']}</td>
                                            <td>{$row['ho_va_ten']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['so_dien_thoai']}</td>
                                            <td>{$row['dia_chi']}</td>
                                            <td>{$row['dia_chi_nhan_hang']}</td>
                                            <td>".($row['dang_ky_nhan_ban_tin'] ? 'Có' : 'Không')."</td>
                                            <td>{$row['vai_tro']}</td>
                                            <td>
                                                <a href='chinhsua_khachhang.php?id={$row['ma_khach_hang']}' class='btn btn-warning btn-sm'>Chỉnh sửa</a>
                                                <a href='xoakhachhang.php?id={$row['ma_khach_hang']}' class='btn btn-danger btn-sm' onclick='return confirmDelete()'>Xóa</a>
                                            </td>
                                          </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Không có khách hàng nào được tìm thấy</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <script>
                function confirmDelete() {
                    return confirm("Bạn có chắc muốn xóa khách hàng này?");
                }
            </script>
        </main>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
