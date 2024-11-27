<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Nhà Xuất Bản</title>
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
                <h1>Thông tin Nhà Xuất Bản</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container my-4">
                <a href="add_nxb.php" class="btn btn-success mb-3">Thêm Nhà Xuất Bản</a>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                        <tr>
                            <th>Mã Nhà Xuất Bản</th>
                            <th>Tên Nhà Xuất Bản</th>
                            <th>Địa Chỉ</th>
                            <th>Số Điện Thoại</th>
                            <th>Email</th>
                            <th>Chức Năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM nxb";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($count = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$count['ma_nxb']}</td>
                                        <td>{$count['ten']}</td>
                                        <td>{$count['dia_chi']}</td>
                                        <td>{$count['sdt']}</td>
                                        <td>{$count['email']}</td>
                                        <td class='action-buttons'>
                                            <a href='edit_nxb.php?ma_nxb={$count['ma_nxb']}' class='btn btn-warning btn-sm'>Chỉnh Sửa</a>
                                            <a href='xoa_nxb.php?ma_nxb={$count['ma_nxb']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa NXB này?\")' class='btn btn-danger btn-sm'>Xóa</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Không có nhà xuất bản nào trong cơ sở dữ liệu</td></tr>";
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
