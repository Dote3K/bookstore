<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$ma_the_loai = $_GET['ma_the_loai'];
$sql = "SELECT * FROM theloai WHERE ma_the_loai = $ma_the_loai";
$result = $conn->query($sql);
$theloai = $result->fetch_array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_the_loai = $_POST['ma_the_loai'];
    $the_loai = $_POST['the_loai'];
    $sql = "UPDATE theloai SET the_loai = '$the_loai' WHERE ma_the_loai='$ma_the_loai'";
    if ($conn->query($sql) === TRUE) {
        header("location: show_the_loai.php");
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin thể loại</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 500px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            margin-top: 30px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button, .back-link {
            background-color: #d81b60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        button:hover, .back-link:hover {
            background-color: #c2185b;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa thông tin thể loại</h1>
        <form method="post">
            <label>Mã thể loại</label><br>
            <input type="text" name="ma_the_loai" value="<?= $theloai['ma_the_loai'] ?>" readonly><br>
            <label>Tên thể loại</label><br>
            <input type="text" name="the_loai" value="<?= $theloai['the_loai'] ?>" required><br>
            <button type="submit">Cập Nhật</button>
        </form>
        <div class="button-container">
            <a href="show_the_loai.php" class="back-link">Trở về trang quản lý thể loại</a>
            <a href="../../admin_page.php" class="back-link">Trang chủ</a>
        </div>
    </div>
</body>
</html>
