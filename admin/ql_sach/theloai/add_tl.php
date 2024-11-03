<?php
require "../nxb/db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$the_loai = $_POST['the_loai'];
$sql = "INSERT INTO theloai( the_loai) VALUES ( '$the_loai')";
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
    <title>Thêm Thể Loại</title>
</head>
<body>
    <h1>Thêm Thể Loại</h1>
    <form method="post">
       
        <label>Tên thể loại </label><br>
        <input type="text" name="the_loai" required><br><br>
        <button type="submit">Thêm thể loại</button><br><br>
    </form>
    <a href="show_the_loai.php"><button>Trở về trang quản lý thể loại</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>
</html>