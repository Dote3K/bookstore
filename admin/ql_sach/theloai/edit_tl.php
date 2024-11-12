<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$ma_the_loai = $_GET['ma_the_loai'];
$sql = "SELECT * FROM theloai WHERE ma_the_loai = $ma_the_loai";
$result = $conn->query($sql);
$theloai = $result->fetch_array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_the_loai = $_POST['ma_the_loai'];
    $the_loai = $_POST['the_loai'];
    $sql = "UPDATE theloai SET the_loai = '$the_loai' WHERE ma_the_loai='$ma_the_loai'";
    if ($conn->query($sql) === TRUE) {
        header("location: show_the_loai.php");
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin thể loại</title>

</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa thông tin thể loại</h1>
        <form method="post">
            <label>Mã thể loại</label><br>
            <input type="text" name="ma_the_loai" value="<?= $theloai['ma_the_loai'] ?>" readonly><br>
            <label>Tên thể loại</label><br>
            <input type="text" name="the_loai" value="<?= $theloai['the_loai'] ?>" required><br>
            <button type="submit">Cập Nhật</button>
        </form>
        <div class="button-container">
            <a href="show_the_loai.php" class="back-link">Trở về trang quản lý thể loại</a>

        </div>
    </div>
</body>
</html>
