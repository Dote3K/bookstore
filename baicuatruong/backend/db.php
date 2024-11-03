<?php
// Kết nối cơ sở dữ liệu
$dsn = 'mysql:host=localhost;dbname=bookstore';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Lỗi kết nối CSDL: " . $e->getMessage();
    exit();
}
