<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
            crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
            crossorigin="anonymous"></script>
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
        .register-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .register-card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            padding: 30px;
            max-width: 800px;
            width: 100%;
        }
        .register-card h2 {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .register-card .form-label {
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
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
        .password-container {
            position: relative;
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
        @media (max-width: 768px) {
            .register-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Register Section -->
<div class="register-container">
    <div class="register-card">
        <h2>Đăng Ký</h2>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger text-center'>" . htmlspecialchars($_SESSION['error']) . "</div>";
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success text-center'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']);
        }
        ?>
        <form method="POST" action="" id="registerForm" class="needs-validation" novalidate>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ten_dang_nhap" class="form-label">Tên Đăng Nhập</label>
                    <input type="text" class="form-control" name="ten_dang_nhap" id="ten_dang_nhap"
                           pattern="[a-zA-Z0-9_]{5,20}" required
                           title="Tên đăng nhập phải từ 5-20 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới">
                    <div class="invalid-feedback">
                        Vui lòng nhập tên đăng nhập hợp lệ (5-20 ký tự, chữ, số, dấu gạch dưới).
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mat_khau" class="form-label">Mật Khẩu</label>
                    <div class="password-container">
                        <input type="password" class="form-control" name="mat_khau" id="mat_khau"
                               pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" required
                               title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số">
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                        <div class="invalid-feedback">
                            Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ho_va_ten" class="form-label">Họ và Tên</label>
                    <input type="text" class="form-control" name="ho_va_ten" id="ho_va_ten" required
                           pattern="^[a-zA-ZÀ-ỹ\s]{2,50}$"
                           title="Họ tên chỉ được chứa chữ cái và khoảng trắng">
                    <div class="invalid-feedback">
                        Vui lòng nhập họ tên hợp lệ (chỉ chữ và khoảng trắng).
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="gioi_tinh" class="form-label">Giới Tính</label>
                    <select name="gioi_tinh" id="gioi_tinh" class="form-select" required>
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                        <option value="Khác">Khác</option>
                    </select>
                    <div class="invalid-feedback">
                        Vui lòng chọn giới tính.
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ngay_sinh" class="form-label">Ngày Sinh</label>
                    <input type="date" class="form-control" name="ngay_sinh" id="ngay_sinh" required
                           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"
                           title="Bạn phải đủ 18 tuổi">
                    <div class="invalid-feedback">
                        Bạn phải đủ 18 tuổi.
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                    <input type="tel" class="form-control" name="so_dien_thoai" id="so_dien_thoai"
                           pattern="^(0)[0-9]{9}$" required
                           title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số">
                    <div class="invalid-feedback">
                        Vui lòng nhập số điện thoại hợp lệ (bắt đầu bằng 0 và có 10 chữ số).
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dia_chi" class="form-label">Địa Chỉ</label>
                    <input type="text" class="form-control" name="dia_chi" id="dia_chi" required minlength="5"
                           title="Vui lòng nhập địa chỉ hợp lệ">
                    <div class="invalid-feedback">
                        Vui lòng nhập địa chỉ hợp lệ.
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required
                           title="Vui lòng nhập email hợp lệ">
                    <div class="invalid-feedback">
                        Vui lòng nhập email hợp lệ.
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="dia_chi_nhan_hang" class="form-label">Địa Chỉ Nhận Hàng</label>
                <input type="text" class="form-control" name="dia_chi_nhan_hang" id="dia_chi_nhan_hang" required minlength="5"
                       title="Vui lòng nhập địa chỉ nhận hàng hợp lệ">
                <div class="invalid-feedback">
                    Vui lòng nhập địa chỉ nhận hàng hợp lệ.
                </div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="dang_ky_nhan_ban_tin" id="dang_ky_nhan_ban_tin">
                <label for="dang_ky_nhan_ban_tin" class="form-check-label">Đăng Ký Nhận Bản Tin</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-user-plus"></i> Đăng Ký
            </button>
        </form>
        <div class="register-link">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>


<!-- Custom Scripts -->
<script>
    // Form validation
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('mat_khau');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>
