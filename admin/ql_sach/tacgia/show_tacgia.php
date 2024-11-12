<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Tác Giả</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        /* Các style tùy chỉnh */
        .sidebar {
            background-color: #f8f9fa;
        }
        .table thead {
            background-color: #4da6ff; /* Màu xanh lam nhạt */
            color: white;
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
        .table tbody tr:hover {
            background-color: #f2f2f2;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <?php include '../../sidebar.php'; ?>
        </nav>
        <!-- Nội dung chính -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header -->
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Thông tin Tác Giả</h1>
                <div class="nav-links">
                    <a href="../../../home.php" class="btn btn-secondary">👤 Tài khoản</a>
                </div>
            </header>

            <!-- Nội dung trang -->
            <div class="container my-4">
                <a href="add_tg.php" class="btn btn-success mb-3">Thêm Tác Giả</a>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                        <tr>
                            <th>Mã Tác Giả</th>
                            <th>Tên</th>
                            <th>Tiểu Sử</th>
                            <th>Chức Năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM tacgia";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($count = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$count['ma_tac_gia']}</td>
                                        <td>{$count['ten']}</td>
                                        <td>{$count['tieu_su']}</td>
                                        <td class='action-buttons'>
                                            <a href='edit_tg.php?ma_tac_gia={$count['ma_tac_gia']}' class='btn btn-warning btn-sm'>Chỉnh Sửa</a>
                                            <a href='xoa_tg.php?ma_tac_gia={$count['ma_tac_gia']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa tác giả này?\")' class='btn btn-danger btn-sm'>Xóa</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Không có tác giả nào trong cơ sở dữ liệu</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
