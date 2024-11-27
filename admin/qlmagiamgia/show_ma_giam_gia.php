<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Mã Giảm Giá</title>
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
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
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
                <h1>Quản Lý Mã Giảm Giá</h1>
            </header>

            <!-- Nội dung trang -->
            <div class="container my-4">
                <a href="add_ma_giam_gia.php" class="btn btn-success mb-3">Thêm Mã Giảm Giá</a>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Mã Giảm Giá</th>
                            <th>Loại Giảm Giá</th>
                            <th>Giá Trị Giảm</th>
                            <th>Số Lần Sử Dụng Tối Đa</th>
                            <th>Số Lần Đã Sử Dụng</th>
                            <th>Ngày Bắt Đầu</th>
                            <th>Ngày Kết Thúc</th>
                            <th>Trạng Thái</th>
                            <th>Tổng Đơn Hàng Tối Thiểu</th>
                            <th>Chức Năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM ma_giam_gia";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($ma_giam_gia = $result->fetch_assoc()) {
                                $trang_thai = $ma_giam_gia['trang_thai'] == 'kich_hoat' ? '<span class="status-active">Kích hoạt</span>' : '<span class="status-inactive">Không kích hoạt</span>';
                                echo "<tr>
                                        <td>{$ma_giam_gia['ma']}</td>
                                        <td>{$ma_giam_gia['ma_giam']}</td>
                                        <td>{$ma_giam_gia['loai_giam_gia']}</td>
                                        <td>{$ma_giam_gia['gia_tri_giam']}</td>
                                        <td>{$ma_giam_gia['so_lan_su_dung_toi_da']}</td>
                                        <td>{$ma_giam_gia['so_lan_da_su_dung']}</td>
                                        <td>{$ma_giam_gia['ngay_bat_dau']}</td>
                                        <td>{$ma_giam_gia['ngay_ket_thuc']}</td>
                                        <td>{$trang_thai}</td>
                                        <td>{$ma_giam_gia['tong_don_hang_toi_thieu']}</td>
                                        <td class='action-buttons'>
                                            <a href='edit_ma_giam_gia.php?ma={$ma_giam_gia['ma']}' class='btn btn-warning btn-sm'>Chỉnh Sửa</a>
                                            <a href='xoa_ma_giam_gia.php?ma={$ma_giam_gia['ma']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa mã giảm giá này?\")' class='btn btn-danger btn-sm'>Xóa</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>Không có mã giảm giá nào trong cơ sở dữ liệu</td></tr>";
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
