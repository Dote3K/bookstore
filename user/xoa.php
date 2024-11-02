<?php
require '../connect.php';
require 'checker/kiemtra_login.php';

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