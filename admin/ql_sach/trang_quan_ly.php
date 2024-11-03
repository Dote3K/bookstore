<?php
require 'nxb/db.php';
$sql = "SELECT * FROM sach";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boss Interface</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #b0b0b0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            background-color: #707070;
            height: 100vh;
            padding: 0;
        }

        .sidebar {
            width: 20%;
            background-color: #505050;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar button{
            background-color: #D3D3D3;
            width: 100px;
            height: 50px;
            margin-bottom: 20px;
            margin-top: auto;
            border-radius: 25px;
        }

        .content {
            width: 80%;
            background: linear-gradient(90deg, #D3D3D3 0%, #F0F0F0 100%);
            display: flex;
            align-items: flex-start; /* Căn lên trên */
            justify-content: flex-start; /* Căn sang trái */
            padding: 20px; /* Khoảng cách từ góc trên */
        }
        .content h1 {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
          <a href="nxb/show_nxb.php"><button>Nhà xuất bản</button></a>
          <a href="tacgia/show_tacgia.php"><button>Tác Giả</button></a>
          <a href="theloai/show_the_loai.php"><button>Thể loại</button></a>
          <a href="sach/show_sach.php"><button>Sách</button></a>
        </div>
        <div class="content" >
            <h1>Hello, BOSS</h1>
        </div>
    </div>
</body>
</html>
