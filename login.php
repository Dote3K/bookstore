<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE ten_dang_nhap = ?");
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($mat_khau, $user['mat_khau'])) {
        $_SESSION['ma_khach_hang'] = $user['ma_khach_hang'];
        $_SESSION['vai_tro'] = $user['vai_tro'];

        header("Location: khachhang/trangchu/trang_chu.php");
        exit();
    } else {
        echo "<p class='error-msg'>Tên đăng nhập hoặc mật khẩu không đúng!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
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

        .login-container {
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

        .login-button {
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

        .login-button:hover {
            background-color: #c2185b;
        }

        .register-link {
            display: block;
            margin-top: 15px;
            color: #d81b60;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link:hover {
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
    <div class="login-container">
        <h1>Đăng nhập</h1>
        <form method="POST" action="login.php">
            <label>Username:</label>
            <input type="text" name="ten_dang_nhap" required>

            <label>Password:</label>
            <input type="password" name="mat_khau" required>

            <button type="submit" class="login-button">Đăng nhập</button>
            <a href="register.php" class="register-link">Chưa có tài khoản? Đăng ký</a>
        </form>
    </div>
</body>
</html>
