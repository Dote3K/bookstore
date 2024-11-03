<?php
require "../nxb/db.php";
$ma_the_loai = $_GET['ma_the_loai'];
$sql = "DELETE FROM theloai WHERE ma_the_loai = '$ma_the_loai' ";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_the_loai.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>