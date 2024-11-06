<?php
    require '../../connect.php';
    require '../../checker/kiemtra_admin.php';
    include '../sidebar.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link rel="stylesheet" href="../../css/qlkhcss.css">
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

    <h1>Quản lý khách hàng</h1>

    <!-- Form tìm kiếm và lọc theo vai trò -->
    <form class="search-filter" method="GET" action="quanlikhachhang.php">
        <input type="text" name="search" placeholder="Tìm kiếm khách hàng..." value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Tìm kiếm</button>
        <select name="role">
            <option value="">Tất cả vai trò</option>
            <option value="admin" <?php if ($role_filter == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="khachhang" <?php if ($role_filter == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
        </select>
        <button type="submit">Lọc</button>
        <a href="quanlikhachhang.php">Hiển thị tất cả</a>
    </form>

    <table>
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
                            <td>{$row['dang_ky_nhan_ban_tin']}</td>
                            <td>{$row['vai_tro']}</td>
                            <td>
                                <a href='chinhsua_khachhang.php?id={$row['ma_khach_hang']}' class='action-link'>Chỉnh sửa</a> | 
                                <a href='xoakhachhang.php?id={$row['ma_khach_hang']}' class='action-link delete' onclick='return confirmDelete()'>Xóa</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10'>Không có khách hàng nào được tìm thấy</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa khách hàng này?");
    }
    </script>
</body>
</html>

<?php
$conn->close();
?> 
