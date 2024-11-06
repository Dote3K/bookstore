<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$ma_sach = $_GET['ma_sach'];
$sql = "SELECT * FROM sach WHERE ma_sach = $ma_sach";
$result = $conn->query($sql);
$sach = $result->fetch_array();

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
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


        $check = getimagesize($_FILES["anh_bia"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File không phải là ảnh.";
            $uploadOk = 0;
        }


        if (file_exists($target_file)) {
            echo "File ảnh đã tồn tại.";
            $uploadOk = 0;
        }


        if ($_FILES["anh_bia"]["size"] > 5000000) {
            echo "File ảnh quá lớn.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Chỉ chấp nhận file ảnh định dạng JPG, JPEG & PNG.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["anh_bia"]["tmp_name"], $target_file)) {
                $anh_bia = $target_file;
            } else {
                echo "Looxi";
            }
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
        header("location: show_sach.php");
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin sách</title>
</head>

<body>
    <h1>Chỉnh sửa thông tin tác giả</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Tên Sách </label><br>
        <input type="text" name="ten_sach" value="<?= $sach['ten_sach'] ?>"required><br>
        <label>Mã tác giả</label><br>
        <select name = "ma_tac_gia">
            <option value="<?= $sach['ma_tac_gia'] ?>">Chọn tác giả</option>
                <?php
                $sql = "SELECT ma_tac_gia, ten from tacgia";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()) {
                        echo '<option value="' . $row["ma_tac_gia"] . '">' . $row["ten"] . '</option>';
                    }
                } else {
                    echo '<option value="">Không có tác giả</option>';
                }
                ?>
        </select><br><br>
        <label>Mã Nhà Xuất Bản</label><br>
        <select name = "ma_nxb">
            <option value="<?= $sach['ma_nxb'] ?>">Chọn nxb</option>
                <?php
                $sql = "SELECT ma_nxb, ten from nxb";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()) {
                        echo '<option value="' . $row["ma_nxb"] . '">' . $row["ten"] . '</option>';
                    }
                } else {
                    echo '<option value="">Không có nxb</option>';
                }
                ?>
        </select><br><br>
        <label>Mã thể loại</label><br>
        <select name = "ma_the_loai">
            <option value="<?= $sach['ma_the_loai'] ?>">Chọn Thể Loại</option>
                <?php
                $sql = "SELECT ma_the_loai, the_loai from theloai";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_array()) {
                        echo '<option value="' . $row["ma_the_loai"] . '">' . $row["the_loai"] . '</option>';
                    }
                } else {
                    echo '<option value="">Không có thể loại</option>';
                }
                ?>
        </select><br><br>
        <label>Giá mua</label><br>
        <input type="number" name="gia_mua" value="<?= $sach['gia_mua'] ?>" required><br><br>
        <label>Giá bán</label><br>
        <input type="number" name="gia_ban" value="<?= $sach['gia_ban'] ?>" required><br><br>
        <label>Số lượng</label><br>
        <input type="number" name="so_luong" value="<?= $sach['so_luong'] ?>"required><br><br>
        <label>Năm xuất bản</label><br>
        <input type="number" name="nam_xuat_ban" value="<?= $sach['nam_xuat_ban'] ?>" required><br><br>    
        <label>Mô tả</label><br>
        <input type="text" name="mo_ta" value="<?= $sach['mo_ta'] ?>" required><br><br>
        <label>Ảnh bìa hiện tại</label><br>
        <img src="<?= $sach['anh_bia'] ?>" style="width: 100px; height: auto;"><br><br>
        <label>Ảnh bìa mới</label>
        <input type="file" name="anh_bia"><br><br>
        <button>Cập nhật</button><br><br>
    </form>
    <a href="show_sach.php"><button>Trở về trang quản lý sách</button></a><br><br>
    <a href = "../../admin_page.php"><button type="button">Trang chủ</button></a>
</body>

</html>