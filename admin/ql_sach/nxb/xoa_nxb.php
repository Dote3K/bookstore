<?php
require "db.php";
$ma_nxb = $_GET['ma_nxb'];
$sql = "DELETE FROM nxb WHERE ma_nxb = '$ma_nxb' ";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_nxb.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>