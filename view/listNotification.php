<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notification</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
        crossorigin="anonymous">
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
    body {

        background: linear-gradient(to right, #fbc2eb, #a6c1ee);
        color: #333;
        margin: 0;
        padding: 0;
    }

    .wrapper {
        background: linear-gradient(135deg, #f9c0c0, #a1c4fd);
        border-radius: 10px;
        padding: 20px;
    }

    .user-avatar {
        border: 2px solid #e4e4e4;
    }

    .col-md-3 {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .nav-link {
        color: #a480b6;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #6e5494;
    }

    .notification-list {
        margin-top: 20px;
    }

    .notification-item {
        background: #f2e5f3;
        border-left: 5px solid #d9a3c8;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .notification-item a.btn {
        color: #6e5494;
        border-color: #d9a3c8;
        background-color: #f9f0ff;
    }

    .notification-item a.btn:hover {
        color: #fff;
        background-color: #d9a3c8;
    }

    h3 {
        color: #9b59b6;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .navbar {
        background: linear-gradient(45deg, #ff6b6b, #ffcc33);
    }

    .navbar-brand,
    .navbar-nav .nav-link {
        color: #ffffff;
    }

    .navbar-brand:hover,
    .navbar-nav .nav-link:hover {
        color: #333333;
    }


    .notification-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f7f7f7;
    }

    .badge {
        background-color: orange;
        color: red;
        padding: 2px;
        border-radius: 100%;
        font-size: 12px;
    }

    @media (min-width: 768px) {
        .col-md-9 {
            flex: 0 0 auto;
            width: 100%;
        }
    }
</style>


<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5 wrapper" style="padding-top: 50px">
        <div class="row">
            <?php if (isset($_SESSION['tenDangNhap'])): ?>

                <!-- Main Content Area -->
                <div class="col-md-9 p-3 bg-light">
                    <div id="notifications" class="content-section" style="display: block;">
                        <h3 style="text-align: center">Thông Báo</h3>
                        <div class="notification-list">
                            <?php if (!empty($notifications)): ?>
                                <?php foreach ($notifications as $notification): ?>
                                    <div class="notification-item d-flex align-items-center">
                                        <div>
                                            <p class="mb-1"><?php echo htmlspecialchars($notification->getMessage()); ?></p>

                                            <small class="text-muted">
                                                <?php
                                                $createdAt = $notification->getCreatedAt();
                                                if (is_string($createdAt)) {
                                                    $createdAt = new DateTime($createdAt);
                                                }
                                                echo $createdAt->format('d/m/Y H:i');
                                                ?>
                                            </small>
                                        </div>
                                        <a href="DonHangRouter.php?action=listOrderUser" class="ms-auto btn btn-sm btn-outline-primary">Xem Chi Tiết</a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Không có thông báo nào.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a class="nav-link" href="/KhachHangRouter.php?action=login">
                    <i class="fa fa-user"></i> Tài khoản
                </a>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
</body>

</html>