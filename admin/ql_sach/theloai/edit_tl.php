<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

$ma_the_loai = $_GET['ma_the_loai'];
$sql = "SELECT * FROM theloai WHERE ma_the_loai = $ma_the_loai";
$result = $conn->query($sql);
$theloai = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_the_loai = $_POST['ma_the_loai'];
    $the_loai = $_POST['the_loai'];
    $sql = "UPDATE theloai SET the_loai = '$the_loai' WHERE ma_the_loai='$ma_the_loai'";
    if ($conn->query($sql) === TRUE) {
        header("location: show_the_loai.php");
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin thể loại</title>
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
                <h1>Chỉnh sửa thông tin thể loại</h1>
                <div class="nav-links">
                    <a href="../../../home.php" class="btn btn-secondary">👤 Tài khoản</a>
                </div>
            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="ma_the_loai" class="form-label">Mã Thể Loại</label>
                        <input type="text" name="ma_the_loai" id="ma_the_loai" class="form-control" value="<?= htmlspecialchars($theloai['ma_the_loai']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="the_loai" class="form-label">Tên Thể Loại</label>
                        <input type="text" name="the_loai" id="the_loai" class="form-control" value="<?= htmlspecialchars($theloai['the_loai']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="show_the_loai.php" class="btn btn-secondary">Trở về trang quản lý thể loại</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
