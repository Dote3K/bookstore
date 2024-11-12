<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$ma_nxb = $_GET['ma_nxb'];
$sql = "SELECT * FROM nxb WHERE ma_nxb = $ma_nxb";
$result = $conn->query($sql);
$nxb = $result->fetch_array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_nxb = $_POST['ma_nxb'];
    $ten = $_POST['ten'];
    $dia_chi = $_POST['dia_chi'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $sql = "UPDATE nxb SET ten = '$ten', dia_chi = '$dia_chi', sdt = '$sdt', email = '$email' WHERE ma_nxb = $ma_nxb";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Cập nhật thành công</p>";
    } else {
        echo "<p class='error-msg'>Lỗi: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin NXB</title>

</head>

<body>
<div class="container">
    <h1>Chỉnh sửa thông tin NXB</h1>
    <form method="post">
        <label for="ma_nxb">Mã nhà xuất bản</label>
        <input type="text" name="ma_nxb" id="ma_nxb" value="<?= $nxb['ma_nxb'] ?>" readonly>

        <label for="ten">Tên nhà xuất bản</label>
        <input type="text" name="ten" id="ten" value="<?= $nxb['ten'] ?>" required>

        <label for="dia_chi">Địa chỉ</label>
        <input type="text" name="dia_chi" id="dia_chi" value="<?= $nxb['dia_chi'] ?>">

        <label for="sdt">Số Điện Thoại</label>
        <input type="number" name="sdt" id="sdt" value="<?= $nxb['sdt'] ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= $nxb['email'] ?>">

        <button type="submit">Cập Nhật</button>
    </form>
    <a href="show_nxb.php" class="back-link">Trở về trang quản lý NXB</a><br>

</div>
</body>
</html>
