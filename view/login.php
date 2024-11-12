<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        .login-card h2 {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .login-card label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #ff4b4b;
        }
        .register-link {
            margin-top: 15px;
            text-align: center;
        }
        .register-link a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Login Section -->
<div class="login-container">
    <div class="login-card">
        <h2>Đăng Nhập</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="ten_dang_nhap" class="form-label">Tên đăng nhập:</label>
                <input type="text" name="ten_dang_nhap" id="ten_dang_nhap" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="mat_khau" class="form-label">Mật khẩu:</label>
                <input type="password" name="mat_khau" id="mat_khau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Đăng Nhập
            </button>
        </form>
        <div class="register-link">
            <p>Chưa có tài khoản? <a href="KhachHangRouter.php?action=register">Đăng ký ngay</a></p>
        </div>
    </div>
</div>

</body>
</html>
