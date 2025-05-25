<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";
require_once __DIR__ . '/DAO/JDBC.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
