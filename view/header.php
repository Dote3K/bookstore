<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
?>
<style>
    .navbar {
        background: linear-gradient(45deg, #ff6b6b, #ffcc33);
    }

    .navbar-brand,
    .navbar-nav .nav-link {
        color: #ffffff;
        font-weight: bold;
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
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

        <a class="navbar-brand" href="/bookstore/index.php">
            <img src="path/to/logo.png" alt="Logo" style="height: 40px;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form class="d-flex" action="search.php" method="get">
                        <input class="form-control me-2" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </li>

                <li class="nav-item dropdown">
                    <?php if (isset($_SESSION['tenDangNhap'])): ?>
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['tenDangNhap']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <?php if ($_SESSION['vai_tro'] === 'admin'): ?>
                                <li><a class="dropdown-item" href="/bookstore/DonHangRouter.php?action=list">Chuyển đến trang quản lý</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/bookstore/KhachHangRouter.php?action=logout">Đăng xuất</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="/bookstore/user/hienThi.php">Trang cá nhân</a></li>
                                <li><a class="dropdown-item" href="/bookstore/DonHangRouter.php?action=listOrderUser">Đơn hàng của tôi</a></li>
                                <li><a class="dropdown-item" href="/bookstore/KhachHangRouter.php?action=logout">Đăng xuất</a></li>
                            <?php endif; ?>
                        </ul>
                <li class="nav-item nav_list notification-icon">
                    <a class="nav-link" href="/bookstore/NotificationRouter.php?action=notificationUser">
                        <i class="fa fa-bell"></i>
                        <span class="badge unread-notifications"></span>
                    </a>
                </li>


                <li class="nav-item nav_list">
                    <a class="nav-link" href="cart.php">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </li>

            <?php else: ?>
                <a class="nav-link" href="/bookstore/KhachHangRouter.php?action=login">
                    <i class="fa fa-user"></i> Tài khoản
                </a>
                <li class="nav-item">
                    <a class="nav-link" href="/bookstore/KhachHangRouter.php?action=login">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/bookstore/KhachHangRouter.php?action=login">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                </li>
            <?php endif; ?>
            </li>

            </ul>
        </div>
    </div>
</nav>
<script>
    function fetchUnreadNotifications() {
        fetch('/bookstore/NotificationRouter.php?action=getUnreadNotifications')
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