<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
        crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(45deg, #ff6f91, #8e44ad);
            color: #333;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        h2 {
            color: #fff;
            margin-bottom: 20px;
        }
        form {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        button {
            margin-top: 20px;
            background-color: #8e44ad;
            color: white;
        }
        button:hover {
            background-color: #732d91;
        }
        .register-link {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h2 class="text-center">Đăng Nhập</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="ten_dang_nhap">Tên đăng nhập:</label>
                <input type="text" name="ten_dang_nhap" id="ten_dang_nhap" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mat_khau">Mật khẩu:</label>
                <input type="password" name="mat_khau" id="mat_khau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
        </form>
        <div class="register-link">
            <p>Chưa có tài khoản? <a href="/KhachHangRouter.php?action=register">Đăng ký ngay</a></p>
        </div>
    </div>
</body>
</html>
