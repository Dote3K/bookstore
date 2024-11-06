<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro = 'khachhang';

    // Kiểm tra tên đăng nhập có tồn tại không
    $stmt = $conn->prepare("SELECT COUNT(*) FROM khachhang WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<p class='error-msg'>Tên tài khoản đã tồn tại. Vui lòng chọn tên khác.</p>";
    } else {
        $sql = "INSERT INTO khachhang (ten_dang_nhap, mat_khau, vai_tro) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $ten_dang_nhap, $mat_khau, $vai_tro);
        $stmt->execute();
        $stmt->close();

        header("location:login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
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

        .register-container {
            width: 90%;
            max-width: 400px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            display: block;
            margin-top: 15px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .register-button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #d81b60;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .register-button:hover {
            background-color: #c2185b;
        }

        .login-link {
            display: block;
            margin-top: 15px;
            color: #d81b60;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link:hover {
            color: #c2185b;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Đăng ký</h1>
        <form method="POST" action="register.php">
            <label>Username:</label>
            <input type="text" name="ten_dang_nhap" required>

            <label>Password:</label>
            <input type="password" name="mat_khau" required>

            <button type="submit" class="register-button">Đăng ký</button>
            <a href="login.php" class="login-link">Đã có tài khoản? Đăng nhập</a>
        </form>
    </div>
</body>
</html>
