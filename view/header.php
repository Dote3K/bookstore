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

            <a class="navbar-brand" href="/index.php">
                <img src="path/to/logo.png" alt="Logo" style="height: 40px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

                    <li class="nav-item dropdown">
                        <?php if (isset($_SESSION['tenDangNhap'])): ?>
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
                    <a class="nav-link" href="/KhachHangRouter.php?action=login">
                        <i class="fa fa-user"></i> Tài khoản
                    </a>
                    <li class="nav-item">
                        <a class="nav-link" href="/KhachHangRouter.php?action=login">
                            <i class="fa fa-bell"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/KhachHangRouter.php?action=login">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Nút Chat
                <li class="nav-item">
                    <a class="nav-link text-white fw-bold"
                        data-bs-toggle="offcanvas" href="#offcanvasChat"
                        role="button" aria-controls="offcanvasChat">
                        <i class="fas fa-comment-dots"></i> Chat
                    </a>
                </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- Offcanvas Chat 
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasChat" aria-labelledby="offcanvasChatLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasChatLabel">Chat với trợ lý sách</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-0">
            <ul id="chat-window" class="list-group list-group-flush flex-grow-1 overflow-auto m-2"></ul>
            <div class="input-group p-2">
                <input id="chat-input" type="text" class="form-control" placeholder="Nhập tin nhắn...">
                <button id="send-btn" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div> -->
    <script>
        // //chatBot
        // const offcanvasEl = document.getElementById('offcanvasChat'),
        //     chatWindow = document.getElementById('chat-window'),
        //     chatInput = document.getElementById('chat-input'),
        //     sendBtn = document.getElementById('send-btn');

        // // Tự focus khi mở
        // offcanvasEl.addEventListener('shown.bs.offcanvas', () => chatInput.focus());

        // // Gửi tin nhắn
        // chatInput.addEventListener('keydown', e => {
        //     if (e.key === 'Enter') sendMessage();
        // });
        // sendBtn.addEventListener('click', sendMessage);

        // function appendMessage(txt, sender) {
        //     const li = document.createElement('li');
        //     li.className = 'list-group-item';
        //     li.innerHTML = `<strong>${sender}:</strong> ${txt}`;
        //     chatWindow.appendChild(li);
        //     chatWindow.scrollTop = chatWindow.scrollHeight;
        // }

        // function sendMessage() {
        //     const msg = chatInput.value.trim();
        //     if (!msg) return;
        //     appendMessage(msg, 'Bạn');
        //     chatInput.value = '';
        //     fetch('/chat/respond', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             },
        //             body: JSON.stringify({
        //                 message: msg
        //             })
        //         })
        //         .then(r => r.json())
        //         .then(d => appendMessage(d.reply || 'Không có phản hồi', 'Bot'))
        //         .catch(() => appendMessage('Lỗi kết nối server', 'System'));
        // }


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