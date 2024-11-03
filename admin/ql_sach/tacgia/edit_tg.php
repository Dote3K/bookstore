<?php
require "../nxb/db.php";
$ma_tac_gia = $_GET['ma_tac_gia'];
$sql = "SELECT * FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
$result = $conn->query($sql);
$tacgia = $result->fetch_array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ten = $_POST['ten'];
    $tieu_su = $_POST['tieu_su'];
    $sql = "UPDATE tacgia SET  ten = '$ten', tieu_su = '$tieu_su' WHERE ma_tac_gia='$ma_tac_gia'";
    if ($conn->query($sql) === TRUE) {
        header("location: show_tacgia.php");
 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      
        
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin tác giả</title>
</head>

<body>
    <h1>Chỉnh sửa thông tin tác giả</h1>
    <form method="post">
        <label>Mã tác giả</label><br>
        <input type="text" name="ma_tac_gia" value="<?= $tacgia['ma_tac_gia'] ?>" readonly><br>
        <label>Tên tác giả</label><br>
        <input type="text" name="ten" value="<?= $tacgia['ten'] ?>" required><br>
        <label>Tiểu sử</label><br>
        <input type="text" name="tieu_su" value="<?= $tacgia['tieu_su'] ?>"><br><br>
        <button type="submit">Cập Nhật</button><br></br>

    </form>
    <a href="show_tacgia.php"><button type="button">Trở về trang quản lý tác giả</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>

</html>