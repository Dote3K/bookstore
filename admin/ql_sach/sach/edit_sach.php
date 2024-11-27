<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

$ma_sach = $_GET['ma_sach'];
$sql = "SELECT * FROM sach WHERE ma_sach = $ma_sach";
$result = $conn->query($sql);
$sach = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_sach = $_POST['ten_sach'];
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ma_nxb = $_POST['ma_nxb'];
    $ma_the_loai = $_POST['ma_the_loai'];
    $gia_mua = $_POST['gia_mua'];
    $gia_ban = $_POST['gia_ban'];
    $so_luong = $_POST['so_luong'];
    $nam_xuat_ban = $_POST['nam_xuat_ban'];
    $mo_ta = $_POST['mo_ta'];

    if (!empty($_FILES['anh_bia']['name'])) {
        $target_dir = "anhbia/";
        $target_file = $target_dir . basename($_FILES["anh_bia"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $allowed_types) && $_FILES["anh_bia"]["size"] <= 5000000) {
            if (move_uploaded_file($_FILES["anh_bia"]["tmp_name"], $target_file)) {
                $anh_bia = $target_file;
            } else {
                echo "<div class='alert alert-danger'>Lỗi khi tải ảnh.</div>";
            }
        } else {
            $anh_bia = $sach['anh_bia'];
        }
    } else {
        $anh_bia = $sach['anh_bia'];
    }

    $sql = "UPDATE sach SET 
                ten_sach = '$ten_sach', 
                ma_tac_gia = '$ma_tac_gia', 
                ma_nxb = '$ma_nxb', 
                ma_the_loai = '$ma_the_loai', 
                gia_mua = '$gia_mua', 
                gia_ban = '$gia_ban', 
                so_luong = '$so_luong', 
                nam_xuat_ban = '$nam_xuat_ban', 
                mo_ta = '$mo_ta', 
                anh_bia = '$anh_bia' 
            WHERE ma_sach='$ma_sach'";

    if ($conn->query($sql) === TRUE) {
        header("Location: show_sach.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Lỗi: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin sách</title>
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
        .img-thumbnail {
            width: 150px;
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
                <h1>Chỉnh sửa thông tin sách</h1>

            </header>

            <!-- Nội dung trang -->
            <div class="container mt-4">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ten_sach" class="form-label">Tên Sách</label>
                        <input type="text" name="ten_sach" id="ten_sach" class="form-control" value="<?= htmlspecialchars($sach['ten_sach']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="ma_tac_gia" class="form-label">Tác Giả</label>
                        <select name="ma_tac_gia" id="ma_tac_gia" class="form-select" required>
                            <?php
                            $sql = "SELECT ma_tac_gia, ten FROM tacgia";
                            $result_tacgia = $conn->query($sql);
                            if ($result_tacgia->num_rows > 0) {
                                while ($row = $result_tacgia->fetch_assoc()) {
                                    $selected = ($row['ma_tac_gia'] == $sach['ma_tac_gia']) ? 'selected' : '';
                                    echo '<option value="' . $row["ma_tac_gia"] . '" ' . $selected . '>' . $row["ten"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Không có tác giả</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ma_nxb" class="form-label">Nhà Xuất Bản</label>
                        <select name="ma_nxb" id="ma_nxb" class="form-select" required>
                            <?php
                            $sql = "SELECT ma_nxb, ten FROM nxb";
                            $result_nxb = $conn->query($sql);
                            if ($result_nxb->num_rows > 0) {
                                while ($row = $result_nxb->fetch_assoc()) {
                                    $selected = ($row['ma_nxb'] == $sach['ma_nxb']) ? 'selected' : '';
                                    echo '<option value="' . $row["ma_nxb"] . '" ' . $selected . '>' . $row["ten"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Không có NXB</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ma_the_loai" class="form-label">Thể Loại</label>
                        <select name="ma_the_loai" id="ma_the_loai" class="form-select" required>
                            <?php
                            $sql = "SELECT ma_the_loai, the_loai FROM theloai";
                            $result_theloai = $conn->query($sql);
                            if ($result_theloai->num_rows > 0) {
                                while ($row = $result_theloai->fetch_assoc()) {
                                    $selected = ($row['ma_the_loai'] == $sach['ma_the_loai']) ? 'selected' : '';
                                    echo '<option value="' . $row["ma_the_loai"] . '" ' . $selected . '>' . $row["the_loai"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Không có thể loại</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gia_mua" class="form-label">Giá Mua</label>
                        <input type="number" name="gia_mua" id="gia_mua" class="form-control" value="<?= htmlspecialchars($sach['gia_mua']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="gia_ban" class="form-label">Giá Bán</label>
                        <input type="number" name="gia_ban" id="gia_ban" class="form-control" value="<?= htmlspecialchars($sach['gia_ban']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="so_luong" class="form-label">Số Lượng</label>
                        <input type="number" name="so_luong" id="so_luong" class="form-control" value="<?= htmlspecialchars($sach['so_luong']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nam_xuat_ban" class="form-label">Năm Xuất Bản</label>
                        <input type="number" name="nam_xuat_ban" id="nam_xuat_ban" class="form-control" value="<?= htmlspecialchars($sach['nam_xuat_ban']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="mo_ta" class="form-label">Mô Tả</label>
                        <textarea name="mo_ta" id="mo_ta" class="form-control" rows="3" required><?= htmlspecialchars($sach['mo_ta']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh Bìa Hiện Tại</label><br>
                        <img src="<?= htmlspecialchars($sach['anh_bia']); ?>" alt="Ảnh bìa" class="img-thumbnail">
                    </div>

                    <div class="mb-3">
                        <label for="anh_bia" class="form-label">Ảnh Bìa Mới</label>
                        <input type="file" name="anh_bia" id="anh_bia" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="show_sach.php" class="btn btn-secondary">Trở về trang quản lý sách</a>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>
