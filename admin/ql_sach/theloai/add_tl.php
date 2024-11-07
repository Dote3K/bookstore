<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $the_loai = $_POST['the_loai'];
    $sql = "INSERT INTO theloai(the_loai) VALUES ('$the_loai')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'>Thêm thành công</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi do: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Thể Loại</title>
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
        <h1>Thêm Thể Loại</h1>
        <form method="post">
            <label>Tên Thể Loại</label><br>
            <input type="text" name="the_loai" required><br>
            <button type="submit">Thêm Thể Loại</button>
        </form>
        <div class="button-container">
            <a href="show_the_loai.php" class="back-link">Trở về trang quản lý thể loại</a>

        </div>
    </div>
</body>
</html>
