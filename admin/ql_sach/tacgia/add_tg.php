<?php
require "../nxb/db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$tieu_su = $_POST['tieu_su'];
$ten = $_POST['ten'];
$ma_tac_gia= $_POST['tieu_su'];
$sql = "INSERT INTO tacgia( ten, tieu_su) VALUES ( '$ten', '$tieu_su')";
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
    <title>Thêm Tác Giả</title>
</head>
<body>
    <h1>Thêm Tác Giả</h1>
    <form method="post">
        <label>Tên tác giả </label><br>
        <input type="text" name="ten" required><br>
        <label>Tiểu sử</label><br>
        <input type="text" name="tieu_su" required><br><br>
        <button type="submit">Thêm Tác Giả</button><br><br>
    </form>
    <a href="show_tacgia.php"><button type="button">Trở về trang quản lý tác giả</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>
</html>