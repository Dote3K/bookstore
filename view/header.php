<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
</script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Custom Styles -->
<style>
    .navbar {
        background: linear-gradient(45deg, #ff6b6b, #ffcc33) !important;
    }

    .navbar-brand,
    .navbar-nav .nav-link {
        color: #ffffff !important;
        font-weight: bold;
    }

    .navbar-brand:hover,
    .navbar-nav .nav-link:hover {
        color: #333333 !important;
    }

    .notification-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f7f7f7;
    }

    .badge.unread-notifications {
        background-color: orange;
        color: red;
        padding: 2px 6px;
        border-radius: 100%;
        font-size: 12px;
        position: absolute;
        top: 6px;
        right: 2px;
        display: none;
    }

    .nav-link {
        position: relative;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

        <a class="navbar-brand" href="/index.php">
            <img src="path/to/logo.png" alt="Logo" style="height: 40px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form class="d-flex" action="/searchRouter.php?action=search" method="POST">
                        <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </li>
                <?php if (isset($_SESSION['tenDangNhap'])): ?>
                    <!-- Đã đăng nhập -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['tenDangNhap']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <?php if ($_SESSION['vai_tro'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="/DonHangRouter.php?action=list">Chuyển đến trang quản lý</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/KhachHangRouter.php?action=logout">Đăng xuất</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="/user/hienThi.php">Trang cá nhân</a></li>
                                <li><a class="dropdown-item" href="/DonHangRouter.php?action=listOrderUser">Đơn hàng của tôi</a></li>
                                <li><a class="dropdown-item" href="/KhachHangRouter.php?action=logout">Đăng xuất</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="nav-item nav_list notification-icon">
                        <a class="nav-link" href="/NotificationRouter.php?action=notificationUser">
                            <i class="fa fa-bell"></i>
                            <span class="badge unread-notifications"></span>
                        </a>
                    </li>
                    <li class="nav-item nav_list">
                        <a class="nav-link" href="/view/cart.php">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Chưa đăng nhập -->
                    <li class="nav-item">
                        <a class="nav-link" href="/KhachHangRouter.php?action=login">
                            <i class="fa fa-user"></i> Tài khoản
                        </a>
                    </li>
                    <li class="nav-item nav_list">
                        <a class="nav-link" href="/KhachHangRouter.php?action=login">
                            <i class="fa fa-bell"></i>
                        </a>
                    </li>
                    <li class="nav-item nav_list">
                        <a class="nav-link" href="/KhachHangRouter.php?action=login">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<script>
    //notification 

    function fetchUnreadNotifications() {
        fetch('/NotificationRouter.php?action=getUnreadNotifications')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                const unreadCount = data.count;
                const unreadBadge = document.querySelector('.unread-notifications');
                const hmtl = document.querySelectorAll(".nav_list");

                console.log(unreadCount);
                if (unreadCount > 0) {
                    unreadBadge.textContent = unreadCount;
                    unreadBadge.style.display = 'inline';
                } else {
                    unreadBadge.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }

    setInterval(fetchUnreadNotifications, 10000);
</script>