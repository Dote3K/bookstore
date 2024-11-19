<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';

$ma = $_GET['ma'];
$sql = "SELECT * FROM ma_giam_gia WHERE ma = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma);
$stmt->execute();
$result = $stmt->get_result();
$ma_giam_gia = $result->fetch_assoc();

if (!$ma_giam_gia) {
    echo "<div class='alert alert-danger text-center'>Mã giảm giá không tồn tại</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma = $_POST['ma'];
    $ma_giam = $_POST['ma_giam'];
    $loai_giam_gia = $_POST['loai_giam_gia'];
    $gia_tri_giam = $_POST['gia_tri_giam'];
    $so_lan_su_dung_toi_da = !empty($_POST['so_lan_su_dung_toi_da']) ? $_POST['so_lan_su_dung_toi_da'] : null;
    $so_lan_da_su_dung = $_POST['so_lan_da_su_dung'];
    $tong_don_hang_toi_thieu = !empty($_POST['tong_don_hang_toi_thieu']) ? $_POST['tong_don_hang_toi_thieu'] : null;
    $trang_thai = $_POST['trang_thai'];

    // Chuyển đổi định dạng ngày giờ
    $ngay_bat_dau = !empty($_POST['ngay_bat_dau']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_bat_dau'])) : null;
    $ngay_ket_thuc = !empty($_POST['ngay_ket_thuc']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_ket_thuc'])) : null;

    $sql = "UPDATE ma_giam_gia SET ma_giam = ?, loai_giam_gia = ?, gia_tri_giam = ?, so_lan_su_dung_toi_da = ?, so_lan_da_su_dung = ?, ngay_bat_dau = ?, ngay_ket_thuc = ?, trang_thai = ?, tong_don_hang_toi_thieu = ? WHERE ma = ?";
    $stmt = $conn->prepare($sql);

    // Xử lý các biến có thể là NULL
    $so_lan_su_dung_toi_da = !empty($so_lan_su_dung_toi_da) ? $so_lan_su_dung_toi_da : null;
    $tong_don_hang_toi_thieu = !empty($tong_don_hang_toi_thieu) ? $tong_don_hang_toi_thieu : null;
    $ngay_bat_dau = !empty($ngay_bat_dau) ? $ngay_bat_dau : null;
    $ngay_ket_thuc = !empty($ngay_ket_thuc) ? $ngay_ket_thuc : null;

    // Sửa lại loại dữ liệu trong bind_param
    $stmt->bind_param("ssdiiissdi", $ma_giam, $loai_giam_gia, $gia_tri_giam, $so_lan_su_dung_toi_da, $so_lan_da_su_dung, $ngay_bat_dau, $ngay_ket_thuc, $trang_thai, $tong_don_hang_toi_thieu, $ma);

    if ($stmt->execute()) {
        header("Location: show_ma_giam_gia.php");
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
    <title>Chỉnh Sửa Mã Giảm Giá</title>
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
                <h1>Chỉnh Sửa Mã Giảm Giá</h1>
                
            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post">
                    <input type="hidden" name="ma" value="<?= htmlspecialchars($ma_giam_gia['ma']); ?>">

                    <div class="mb-3">
                        <label for="ma_giam" class="form-label">Mã Giảm Giá</label>
                        <input type="text" name="ma_giam" id="ma_giam" class="form-control" value="<?= htmlspecialchars($ma_giam_gia['ma_giam']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="loai_giam_gia" class="form-label">Loại Giảm Giá</label>
                        <select name="loai_giam_gia" id="loai_giam_gia" class="form-select" required>
                            <option value="phan_tram" <?= $ma_giam_gia['loai_giam_gia'] == 'phan_tram' ? 'selected' : ''; ?>>Phần trăm</option>
                            <option value="gia_co_dinh" <?= $ma_giam_gia['loai_giam_gia'] == 'gia_co_dinh' ? 'selected' : ''; ?>>Giá cố định</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gia_tri_giam" class="form-label">Giá Trị Giảm</label>
                        <input type="number" step="0.01" name="gia_tri_giam" id="gia_tri_giam" class="form-control" value="<?= htmlspecialchars($ma_giam_gia['gia_tri_giam']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_lan_su_dung_toi_da" class="form-label">Số Lần Sử Dụng Tối Đa</label>
                        <input type="number" name="so_lan_su_dung_toi_da" id="so_lan_su_dung_toi_da" class="form-control" value="<?= htmlspecialchars($ma_giam_gia['so_lan_su_dung_toi_da']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="so_lan_da_su_dung" class="form-label">Số Lần Đã Sử Dụng</label>
                        <input type="number" name="so_lan_da_su_dung" id="so_lan_da_su_dung" class="form-control" value="<?= htmlspecialchars($ma_giam_gia['so_lan_da_su_dung']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tong_don_hang_toi_thieu" class="form-label">Tổng Đơn Hàng Tối Thiểu</label>
                        <input type="number" step="0.01" name="tong_don_hang_toi_thieu" id="tong_don_hang_toi_thieu" class="form-control" value="<?= htmlspecialchars($ma_giam_gia['tong_don_hang_toi_thieu']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="ngay_bat_dau" class="form-label">Ngày Bắt Đầu</label>
                        <input type="datetime-local" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" value="<?= !empty($ma_giam_gia['ngay_bat_dau']) ? date('Y-m-d\TH:i', strtotime($ma_giam_gia['ngay_bat_dau'])) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="ngay_ket_thuc" class="form-label">Ngày Kết Thúc</label>
                        <input type="datetime-local" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" value="<?= !empty($ma_giam_gia['ngay_ket_thuc']) ? date('Y-m-d\TH:i', strtotime($ma_giam_gia['ngay_ket_thuc'])) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="trang_thai" class="form-label">Trạng Thái</label>
                        <select name="trang_thai" id="trang_thai" class="form-select" required>
                            <option value="kich_hoat" <?= $ma_giam_gia['trang_thai'] == 'kich_hoat' ? 'selected' : ''; ?>>Kích hoạt</option>
                            <option value="khong_kich_hoat" <?= $ma_giam_gia['trang_thai'] == 'khong_kich_hoat' ? 'selected' : ''; ?>>Không kích hoạt</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập Nhật Mã Giảm Giá</button>
                    <a href="show_ma_giam_gia.php" class="btn btn-secondary">Trở về trang quản lý mã giảm giá</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
