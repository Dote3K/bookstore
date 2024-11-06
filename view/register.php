<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(45deg, #ff6a88, #c47ac0);
            min-height: 100vh;
        }
        .container {
            height: auto;
            margin-bottom: 30px;
        }
        .card {
            background-color: white;
            margin: 20px 0;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }
        .invalid-feedback {
            display: none;
            font-size: 80%;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Đăng Ký</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-center">Chào mừng bạn đến với trang đăng ký!</p>
                        <p class="text-center">Hãy điền thông tin của bạn để tạo tài khoản.</p>
                        
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo "<div class='alert alert-danger text-center'>" . $_SESSION['error'] . "</div>";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-success text-center'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']);
                        }
                        ?>

                        <form method="POST" action="" id="registerForm" class="needs-validation" novalidate>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ten_dang_nhap" class="form-label">Tên Đăng Nhập</label>
                                    <input type="text" class="form-control" name="ten_dang_nhap" 
                                           pattern="[a-zA-Z0-9_]{5,20}" required
                                           title="Tên đăng nhập phải từ 5-20 ký tự, chỉ bao gồm chữ cái, số và dấu gạch dưới">
                                    <div class="invalid-feedback">
                                        Vui lòng nhập tên đăng nhập hợp lệ (5-20 ký tự)
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="mat_khau" class="form-label">Mật Khẩu</label>
                                    <div class="password-container">
                                        <input type="password" class="form-control" name="mat_khau" id="mat_khau"
                                               pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" required
                                               title="Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số">
                                        <i class="fas fa-eye toggle-password"></i>
                                        <div class="invalid-feedback">
                                            Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ và số
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ho_va_ten" class="form-label">Họ và Tên</label>
                                    <input type="text" class="form-control" name="ho_va_ten" required
                                           pattern="^[a-zA-ZÀ-ỹ\s]{2,50}$"
                                           title="Họ tên chỉ được chứa chữ cái và khoảng trắng">
                                    <div class="invalid-feedback">
                                        Vui lòng nhập họ tên hợp lệ
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="gioi_tinh" class="form-label">Giới Tính</label>
                                    <select name="gioi_tinh" class="form-select" required>
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Vui lòng chọn giới tính
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ngay_sinh" class="form-label">Ngày Sinh</label>
                                    <input type="date" class="form-control" name="ngay_sinh" required
                                           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                                    <div class="invalid-feedback">
                                        Bạn phải đủ 18 tuổi
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                                    <input type="tel" class="form-control" name="so_dien_thoai" 
                                           pattern="^(0)[0-9]{9}$" required
                                           title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số">
                                    <div class="invalid-feedback">
                                        Vui lòng nhập số điện thoại hợp lệ
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dia_chi" class="form-label">Địa Chỉ</label>
                                    <input type="text" class="form-control" name="dia_chi" required minlength="5">
                                    <div class="invalid-feedback">
                                        Vui lòng nhập địa chỉ hợp lệ
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">
                                        Vui lòng nhập email hợp lệ
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dia_chi_nhan_hang" class="form-label">Địa Chỉ Nhận Hàng</label>
                                <input type="text" class="form-control" name="dia_chi_nhan_hang" required minlength="5">
                                <div class="invalid-feedback">
                                    Vui lòng nhập địa chỉ nhận hàng hợp lệ
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="dang_ky_nhan_ban_tin" id="dang_ky_nhan_ban_tin">
                                <label for="dang_ky_nhan_ban_tin" class="form-check-label">Đăng Ký Nhận Bản Tin</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    document.querySelector('.toggle-password').addEventListener('click', function() {
        const password = document.querySelector('#mat_khau');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>
</html>