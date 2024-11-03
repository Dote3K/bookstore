<?php
require "../nxb/db.php";
$ma_the_loai = $_GET['ma_the_loai'];
$sql = "SELECT * FROM theloai WHERE ma_the_loai = $ma_the_loai";
$result = $conn->query($sql);
$theloai = $result->fetch_array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_the_loai = $_POST['ma_the_loai'];
    $the_loai = $_POST['the_loai'];
    $sql = "UPDATE theloai SET  the_loai = '$the_loai' WHERE ma_the_loai='$ma_the_loai'";
    if ($conn->query($sql) === TRUE) {
        header("location: show_the_loai.php");
 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      
        
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin thể loại</title>
</head>

<body>
    <h1>Chỉnh sửa thông tin thể loại</h1>
    <form method="post">
        <label>Mã thể loại</label><br>
        <input type="text" name="ma_the_loai" value="<?= $theloai['ma_the_loai'] ?>" readonly><br>
        <label>Tên thể loại</label><br>
        <input type="text" name="the_loai" value="<?= $theloai['the_loai'] ?>" required><br><br>
        <button type="submit">Cập Nhật</button><br><br>

    </form>
    <a href="show_the_loai.php"><button>Trở về trang quản lý thể loại</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>

</html>