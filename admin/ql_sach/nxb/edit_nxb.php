<?php
require "db.php";
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
    $sql = "UPDATE nxb SET  ten = '$ten', dia_chi = '$dia_chi', sdt = '$sdt', email = '$email' WHERE ma_nxb = $ma_nxb ";
    if ($conn->query($sql) === TRUE) {
  
 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      
        
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin NXB</title>
</head>

<body>
    <h1>Chỉnh sửa thông tin NXB</h1>
    <form method="post">
        <label>Mã nhà xuất bản</label><br>
        <input type="text" name="ma_nxb" value="<?= $nxb['ma_nxb'] ?>" readonly><br>
        <label>Tên nhà xuất bản</label><br>
        <input type="text" name="ten" value="<?= $nxb['ten'] ?>" required><br>
        <label>Địa chỉ:</label><br>
        <input type="text" name="dia_chi" value="<?= $nxb['dia_chi'] ?>"><br>
        <label>Số Điện Thoại</label><br>
        <input type="number" name="sdt" value="<?= $nxb['sdt'] ?>"><br>
        <label>Email</label><br>
        <input type="email" name="email" value="<?= $nxb['email'] ?>"><br><br>
        <button type="submit">Cập Nhật</button>
    </form>
    <a href="show_nxb.php"><button>Trở về trang quản lý nxb</button></a><br><br>
    <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
</body>

</html>