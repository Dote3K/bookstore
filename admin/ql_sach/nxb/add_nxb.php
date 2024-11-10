<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten = $_POST['ten'];
    $dia_chi = $_POST['dia_chi'];
    $sdt= $_POST['sdt'];
    $email= $_POST['email'];
    $sql = "INSERT INTO nxb(ten, dia_chi, sdt, email) VALUES ('$ten', '$dia_chi', '$sdt', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Thêm thành công</p>";
    } else {
        echo "<p class='error-msg'>Lỗi do: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhà Xuất Bản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
            color: #3E7C6F;
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
            background-color: #4A90E2;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
            background-color: #5D4037;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #3E7C6F;
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
    <h1>Thêm Nhà Xuất Bản</h1>
    <form method="post">
        <label for="ten">Tên nhà xuất bản</label>
        <input type="text" name="ten" id="ten" required>

        <label for="dia_chi">Địa chỉ</label>
        <input type="text" name="dia_chi" id="dia_chi">

        <label for="sdt">Số Điện Thoại</label>
        <input type="number" name="sdt" id="sdt">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <button type="submit">Thêm Nhà Xuất Bản</button>
    </form>
    <a href="show_nxb.php" class="back-link">Trở về trang quản lý NXB</a><br>

</div>

</body>
</html>
