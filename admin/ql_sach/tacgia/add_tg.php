<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tieu_su = $_POST['tieu_su'];
    $ten = $_POST['ten'];
    $sql = "INSERT INTO tacgia(ten, tieu_su) VALUES ('$ten', '$tieu_su')";
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success text-center'>Thêm tác giả thành công</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tác Giả</title>
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
                <h1>Thêm Tác Giả</h1>
                <div class="nav-links">
                    <a href="../../../home.php" class="btn btn-secondary">👤 Tài khoản</a>
                </div>
            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên Tác Giả</label>
                        <input type="text" name="ten" id="ten" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tieu_su" class="form-label">Tiểu Sử</label>
                        <textarea name="tieu_su" id="tieu_su" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm Tác Giả</button>
                    <a href="show_tacgia.php" class="btn btn-secondary">Trở về trang quản lý tác giả</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
