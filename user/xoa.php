<?php
require '../connect.php';
require '../checker/kiemtra_login.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM khachhang WHERE ma_khach_hang='$id'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($stmt->execute()  === TRUE ){
        header('Location: hienThi.php');
    }
    else{
        echo "Lỗi: ". $conn->error;
    }
}
$conn->close();
?>