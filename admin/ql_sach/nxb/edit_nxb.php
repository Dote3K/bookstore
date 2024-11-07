<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$ma_nxb = $_GET['ma_nxb'];
$sql = "SELECT * FROM nxb WHERE ma_nxb = $ma_nxb";
$result = $conn->query($sql);
$nxb = $result->fetch_array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_nxb = $_POST['ma_nxb'];
    $ten = $_POST['ten'];
    $dia_chi = $_POST['dia_chi'];
    $sdt = $_POST['sdt'];
    $email = $_POST['email'];
    $sql = "UPDATE nxb SET ten = '$ten', dia_chi = '$dia_chi', sdt = '$sdt', email = '$email' WHERE ma_nxb = $ma_nxb";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Cập nhật thành công</p>";
    } else {
        echo "<p class='error-msg'>Lỗi: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin NXB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4); /* Nền gradient hồng nhẹ */
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
            text-align: center;
            margin-top: 30px;
        }

        h1 {
            font-size: 28px;
            color: #d81b60; /* Màu hồng đậm cho tiêu đề */
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
            text-align: left;
        }

        input[type="text"], input[type="number"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background-color: #d81b60; /* Màu hồng cho nút */
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2185b; /* Màu hồng đậm hơn khi hover */
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            background-color: #d81b60;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #c2185b;
        }

        .success-msg {
            color: #4CAF50;
            font-weight: bold;
        }

        .error-msg {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Chỉnh sửa thông tin NXB</h1>
    <form method="post">
        <label for="ma_nxb">Mã nhà xuất bản</label>
        <input type="text" name="ma_nxb" id="ma_nxb" value="<?= $nxb['ma_nxb'] ?>" readonly>

        <label for="ten">Tên nhà xuất bản</label>
        <input type="text" name="ten" id="ten" value="<?= $nxb['ten'] ?>" required>

        <label for="dia_chi">Địa chỉ</label>
        <input type="text" name="dia_chi" id="dia_chi" value="<?= $nxb['dia_chi'] ?>">

        <label for="sdt">Số Điện Thoại</label>
        <input type="number" name="sdt" id="sdt" value="<?= $nxb['sdt'] ?>">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= $nxb['email'] ?>">

        <button type="submit">Cập Nhật</button>
    </form>
    <a href="show_nxb.php" class="back-link">Trở về trang quản lý NXB</a><br>

</div>
</body>
</html>
