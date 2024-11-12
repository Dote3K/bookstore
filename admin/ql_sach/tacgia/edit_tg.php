<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

$ma_tac_gia = $_GET['ma_tac_gia'];
$sql = "SELECT * FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
$result = $conn->query($sql);
$tacgia = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ten = $_POST['ten'];
    $tieu_su = $_POST['tieu_su'];
    $sql = "UPDATE tacgia SET ten = '$ten', tieu_su = '$tieu_su' WHERE ma_tac_gia = '$ma_tac_gia'";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_tacgia.php");
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
    <title>Chỉnh sửa thông tin tác giả</title>
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
                <h1>Chỉnh sửa thông tin tác giả</h1>
                <div class="nav-links">
                    <a href="../../../home.php" class="btn btn-secondary">👤 Tài khoản</a>
                </div>
            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="ma_tac_gia" class="form-label">Mã Tác Giả</label>
                        <input type="text" name="ma_tac_gia" id="ma_tac_gia" class="form-control" value="<?= htmlspecialchars($tacgia['ma_tac_gia']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên Tác Giả</label>
                        <input type="text" name="ten" id="ten" class="form-control" value="<?= htmlspecialchars($tacgia['ten']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tieu_su" class="form-label">Tiểu Sử</label>
                        <textarea name="tieu_su" id="tieu_su" class="form-control" rows="4" required><?= htmlspecialchars($tacgia['tieu_su']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="show_tacgia.php" class="btn btn-secondary">Trở về trang quản lý tác giả</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
