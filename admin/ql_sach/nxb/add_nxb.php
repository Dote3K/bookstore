<?php
require"db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$ten = $_POST['ten'];
$dia_chi = $_POST['dia_chi'];
$sdt= $_POST['sdt'];
$email= $_POST['email'];
$sql = "INSERT INTO nxb( ten, dia_chi, sdt, email) VALUES ( '$ten', '$dia_chi', '$sdt', '$email')";
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
    <title>Thêm nxb</title>
</head>
<body>
    <h1>Thêm Nhà Xuất Bản</h1>
    <form method="post">
        <label>Tên nhà xuất bản</label><br>
        <input type="text" name="ten" required><br>
        <label>Địa chỉ</label><br>
        <input type="text" name="dia_chi"><br>
        <label>Số Điện Thoại</label><br>
        <input type="number" name="sdt"><br>
        <label>Email</label><br>
        <input type="email" name="email"><br><br>
        <button type="submit">Thêm Nhà Xuất Bản</button><br><br>
    </form>
    <a href="show_nxb.php"><button>Trở về trang quản lý nxb</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>
</html>