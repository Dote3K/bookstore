<?php
require '../connect.php';
require '../checker/kiemtra_login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matKhauHienTai = $_POST['matKhauHienTai'];
    $matKhauMoi = $_POST['matKhauMoi'];
    $xacNhanMatKhauMoi = $_POST['xacNhanMatKhauMoi'];
    $ma_khach_hang = $_SESSION['ma_khach_hang'];

    if ($matKhauMoi !== $xacNhanMatKhauMoi) {
        echo "<p style='color: red; text-align: center;'>Mật khẩu mới và xác nhận mật khẩu không khớp.</p>";
    } else {
        $stmt = $conn->prepare("SELECT mat_khau FROM khachhang WHERE ma_khach_hang = ?");
        $stmt->bind_param("i", $ma_khach_hang);
        $stmt->execute();
        $result = $stmt->get_result();
        $khachhang = $result->fetch_assoc();

        if ($khachhang && password_verify($matKhauHienTai, $khachhang['mat_khau'])) {
            $maHoaMatKhauMoi = password_hash($matKhauMoi, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE khachhang SET mat_khau = ? WHERE ma_khach_hang = ?");
            $stmt->bind_param("si", $maHoaMatKhauMoi, $ma_khach_hang);
            $stmt->execute();

            echo "<p style='color: green; text-align: center;'>Đổi mật khẩu thành công!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Mật khẩu hiện tại không đúng.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #f2f4f8, #d1e8e2); /* Nền trang chuyển từ xanh nhạt sang trắng */
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
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 30px;
        }

        h2 {
            font-size: 24px;
            color: #00796b; /* Màu xanh đậm cho tiêu đề */
            margin-bottom: 20px;
        }

        form label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbb;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        button {
            background-color: #00796b; /* Màu xanh lá đậm */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004d40; /* Xanh đậm hơn khi hover */
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #00796b;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Đổi mật khẩu</h2>
        <form method="POST" action="">
            <label for="matKhauHienTai">Mật khẩu hiện tại:</label>
            <input type="password" name="matKhauHienTai" required>

            <label for="matKhauMoi">Mật khẩu mới:</label>
            <input type="password" name="matKhauMoi" required>

            <label for="xacNhanMatKhauMoi">Xác nhận mật khẩu mới:</label>
            <input type="password" name="xacNhanMatKhauMoi" required>

            <button type="submit">Đổi mật khẩu</button>
        </form>
        <a href="../home.php" class="back-link">Quay lại trang chủ</a>
    </div>
</body>
</html>
