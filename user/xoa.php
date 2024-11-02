<?php
require '../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM khachhang WHERE ma_khach_hang='$id'";
    $conn->query($sql);
    if($conn->query($sql)  === TRUE ){
        header('Location: hienThi.php');
    }
    else{
        echo "Lỗi: ". $conn->error;
    }
}


$conn->close();
?>