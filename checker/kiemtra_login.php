<?php
session_start();
if (!isset($_SESSION['ma_khach_hang'])) {
    header("Location: view/login.php");
    exit();
}