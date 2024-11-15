<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten'];
    $dia_chi = $_POST['dia_chi'];
    $sdt= $_POST['sdt'];
    $email= $_POST['email'];
    $sql = "INSERT INTO nxb(ten, dia_chi, sdt, email) VALUES ('$ten', '$dia_chi', '$sdt', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>Thêm nhà xuất bản thành công</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhà Xuất Bản</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        /* Các style tùy chỉnh */
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
            <?php include '../../sidebar.php'; ?>
        </nav>
        <!-- Nội dung chính -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header -->
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Thêm Nhà Xuất Bản</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên Nhà Xuất Bản</label>
                        <input type="text" name="ten" id="ten" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa Chỉ</label>
                        <input type="text" name="dia_chi" id="dia_chi" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="sdt" class="form-label">Số Điện Thoại</label>
                        <input type="number" name="sdt" id="sdt" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm Nhà Xuất Bản</button>
                    <a href="show_nxb.php" class="btn btn-secondary">Trở về trang quản lý NXB</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
