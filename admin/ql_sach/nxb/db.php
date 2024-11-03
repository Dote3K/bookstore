<?php
$servername = "localhost";
$db = "bookstore";
$username = "root";
$pw = "";
$conn = new mysqli($servername, $username, $pw, $db);

if($conn->connect_error){
    die("Kết nối thất bại : " . $conn->connect_error);
}

?>