<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin Sách</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- Font Awesome cho biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .img-thumbnail {
            width: 80px;
            height: auto;
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
                <h1>Thông tin Sách</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container my-4">
                <a href="add_book.php" class="btn btn-success mb-3">Thêm sách</a>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                        <tr>
                            <th>Mã Sách</th>
                            <th>Tên Sách</th>
                            <th>Tác giả</th>
                            <th>Nhà xuất bản</th>
                            <th>Thể loại</th>
                            <th>Giá mua</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Năm xuất bản</th>
                            <th>Mô tả</th>
                            <th>Ảnh bìa</th>
                            <th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM sach";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($count = $result->fetch_assoc()) {
                                $ma_tac_gia = $count['ma_tac_gia'];
                                $sql1 = "SELECT ten FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
                                $ten_tac_gia = $conn->query($sql1)->fetch_assoc()['ten'] ?? 'N/A';

                                $ma_nxb = $count['ma_nxb'];
                                $sql2 = "SELECT ten FROM nxb WHERE ma_nxb = $ma_nxb";
                                $ten_nxb = $conn->query($sql2)->fetch_assoc()['ten'] ?? 'N/A';

                                $ma_the_loai = $count['ma_the_loai'];
                                $sql3 = "SELECT the_loai FROM theloai WHERE ma_the_loai = $ma_the_loai";
                                $the_loai = $conn->query($sql3)->fetch_assoc()['the_loai'] ?? 'N/A';

                                echo "<tr>
                                            <td>{$count['ma_sach']}</td>
                                            <td>{$count['ten_sach']}</td>
                                            <td>{$ten_tac_gia}</td>
                                            <td>{$ten_nxb}</td>
                                            <td>{$the_loai}</td>
                                            <td>" . number_format($count['gia_mua'], 0, ',', '.') . "₫</td>
                                            <td>" . number_format($count['gia_ban'], 0, ',', '.') . "₫</td>
                                            <td>{$count['so_luong']}</td>
                                            <td>{$count['nam_xuat_ban']}</td>
                                            <td>{$count['mo_ta']}</td>
                                            <td><img src='{$count['anh_bia']}' alt='Ảnh bìa' class='img-thumbnail'></td>
                                            <td class='action-buttons'>
                                                <a href='edit_sach.php?ma_sach={$count['ma_sach']}' class='btn btn-warning btn-sm'>Chỉnh Sửa</a>
                                                <a href='xoa_sach.php?ma_sach={$count['ma_sach']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sách này?')\" class='btn btn-danger btn-sm'>Xóa</a>
                                            </td>
                                          </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
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
