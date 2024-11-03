<?php
require "../nxb/db.php";
$ma_tac_gia = $_GET['ma_tac_gia'];
$sql = "DELETE FROM tacgia WHERE ma_tac_gia = '$ma_tac_gia' ";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_tacgia.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>