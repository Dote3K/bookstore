<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten'];
    $dia_chi = $_POST['dia_chi'];
    $sdt= $_POST['sdt'];
    $email= $_POST['email'];
    $sql = "INSERT INTO nxb(ten, dia_chi, sdt, email) VALUES ('$ten', '$dia_chi', '$sdt', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Thêm thành công</p>";
    } else {
        echo "<p class='error-msg'>Lỗi do: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhà Xuất Bản</title>

</head>
<body>

<div class="container">
    <h1>Thêm Nhà Xuất Bản</h1>
    <form method="post">
        <label for="ten">Tên nhà xuất bản</label>
        <input type="text" name="ten" id="ten" required>

        <label for="dia_chi">Địa chỉ</label>
        <input type="text" name="dia_chi" id="dia_chi">

        <label for="sdt">Số Điện Thoại</label>
        <input type="number" name="sdt" id="sdt">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <button type="submit">Thêm Nhà Xuất Bản</button>
    </form>
    <a href="show_nxb.php" class="back-link">Trở về trang quản lý NXB</a><br>

</div>

</body>
</html>
