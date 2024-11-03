<?php
require"../nxb/db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$ten_sach = $_POST['ten_sach'];
$ma_tac_gia = $_POST['ma_tac_gia'];
$ma_nxb	= $_POST['ma_nxb'];
$ma_the_loai = $_POST['ma_the_loai'];	
$gia_mua = $_POST['gia_mua'];	
$gia_ban = $_POST['gia_ban'];	
$so_luong = $_POST['so_luong'];	
$nam_xuat_ban = $_POST['nam_xuat_ban'];	
$mo_ta = $_POST['mo_ta'];	
$anh_bia = $_POST['anh_bia'];
$sql = "INSERT INTO sach( ten_sach,	ma_tac_gia,	ma_nxb,	ma_the_loai, gia_mua, gia_ban, so_luong, nam_xuat_ban,	mo_ta,	anh_bia) VALUES ( '$ten_sach', '$ma_tac_gia', '$ma_nxb', '$ma_the_loai', '$gia_mua', '$gia_ban', '$so_luong', '$nam_xuat_ban', '$mo_ta', '$anh_bia')";
if ($conn->query($sql) === TRUE) {
    echo "Thêm thành công";
} else {
    echo "Lỗi do : " . $sql . "<br>" . $conn->error;
   
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sách</title>
</head>
<body>
    <h1>Thêm Sách Mới</h1>
    <form method="post">
        <label>Tên Sách </label><br>
        <input type="text" name="ten_sach" required><br>
        <label>Mã tác giả</label><br>
        <select name = "ma_tac_gia">
            <option value="">Chọn tác giả</option>
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
            <option value="">Chọn nxb</option>
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
            <option value="">Chọn Thể Loại</option>
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
        <input type="number" name="gia_mua" required><br><br>
        <label>Giá bán</label><br>
        <input type="number" name="gia_ban" required><br><br>
        <label>Số lượng</label><br>
        <input type="number" name="so_luong" required><br><br>
        <label>Năm xuất bản</label><br>
        <input type="number" name="nam_xuat_ban" required><br><br>    
        <label>Mô tả</label><br>
        <input type="text" name="mo_ta" required><br><br>
        <label>Ảnh bìa</label>
        <input type="file" name="anh_bia" required><br><br>
        <button>Thêm Sách</button><br><br>
    </form>
    <a href="show_sach.php"><button>Trở về trang quản lý sách</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>
</html>