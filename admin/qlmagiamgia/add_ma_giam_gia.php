<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_giam = $_POST['ma_giam'];
    $loai_giam_gia = $_POST['loai_giam_gia'];
    $gia_tri_giam = $_POST['gia_tri_giam'];
    $so_lan_su_dung_toi_da = !empty($_POST['so_lan_su_dung_toi_da']) ? $_POST['so_lan_su_dung_toi_da'] : null;
    $tong_don_hang_toi_thieu = !empty($_POST['tong_don_hang_toi_thieu']) ? $_POST['tong_don_hang_toi_thieu'] : null;
    $trang_thai = $_POST['trang_thai'];

    // Chuyển đổi định dạng ngày giờ
    $ngay_bat_dau = !empty($_POST['ngay_bat_dau']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_bat_dau'])) : null;
    $ngay_ket_thuc = !empty($_POST['ngay_ket_thuc']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_ket_thuc'])) : null;

    $sql = "INSERT INTO ma_giam_gia (ma_giam, loai_giam_gia, gia_tri_giam, so_lan_su_dung_toi_da, ngay_bat_dau, ngay_ket_thuc, trang_thai, tong_don_hang_toi_thieu)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiissd", $ma_giam, $loai_giam_gia, $gia_tri_giam, $so_lan_su_dung_toi_da, $ngay_bat_dau, $ngay_ket_thuc, $trang_thai, $tong_don_hang_toi_thieu);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Thêm mã giảm giá thành công</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Mã Giảm Giá</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        /* Các style tùy chỉnh */

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
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
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
                <h1>Thêm Mã Giảm Giá</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <div class="mb-3">
                        <label for="ma_giam" class="form-label">Mã Giảm Giá</label>
                        <input type="text" name="ma_giam" id="ma_giam" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="loai_giam_gia" class="form-label">Loại Giảm Giá</label>
                        <select name="loai_giam_gia" id="loai_giam_gia" class="form-select" required>
                            <option value="phan_tram">Phần trăm</option>
                            <option value="gia_co_dinh">Giá cố định</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gia_tri_giam" class="form-label">Giá Trị Giảm</label>
                        <input type="number" step="0.01" name="gia_tri_giam" id="gia_tri_giam" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_lan_su_dung_toi_da" class="form-label">Số Lần Sử Dụng Tối Đa</label>
                        <input type="number" name="so_lan_su_dung_toi_da" id="so_lan_su_dung_toi_da" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="tong_don_hang_toi_thieu" class="form-label">Tổng Đơn Hàng Tối Thiểu</label>
                        <input type="number" step="0.01" name="tong_don_hang_toi_thieu" id="tong_don_hang_toi_thieu" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="ngay_bat_dau" class="form-label">Ngày Bắt Đầu</label>
                        <input type="datetime-local" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="ngay_ket_thuc" class="form-label">Ngày Kết Thúc</label>
                        <input type="datetime-local" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="trang_thai" class="form-label">Trạng Thái</label>
                        <select name="trang_thai" id="trang_thai" class="form-select" required>
                            <option value="kich_hoat">Kích hoạt</option>
                            <option value="khong_kich_hoat">Không kích hoạt</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Thêm Mã Giảm Giá</button>
                    <a href="show_ma_giam_gia.php" class="btn btn-secondary">Trở về trang quản lý mã giảm giá</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
