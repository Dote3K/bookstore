<?php
require "../nxb/db.php";
$ma_sach = $_GET['ma_sach'];
$sql = "DELETE FROM sach WHERE ma_sach = '$ma_sach' ";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_sach.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>