<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tieu_su = $_POST['tieu_su'];
    $ten = $_POST['ten'];
    $sql = "INSERT INTO tacgia(ten, tieu_su) VALUES ('$ten', '$tieu_su')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'>Thêm tác giả thành công</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi: " . $sql . "<br>" . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tác Giả</title>
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

        label {
            font-size: 16px;
            color: #333;
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #d81b60;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2185b;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #d81b60;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin: 5px;
        }

        .back-link:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thêm Tác Giả</h1>
        <form method="post">
            <label for="ten">Tên Tác Giả</label>
            <input type="text" name="ten" id="ten" required>

            <label for="tieu_su">Tiểu Sử</label>
            <input type="text" name="tieu_su" id="tieu_su" required>

            <button type="submit">Thêm Tác Giả</button>
        </form>
        <a href="show_tacgia.php" class="back-link">Trở về trang quản lý tác giả</a>

    </div>
</body>
</html>
