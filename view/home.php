<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
        }

        .navbar {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
        }

        .navbar-brand,
        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: bold;
        }

        .carousel-item img {
            height: 450px;
            object-fit: cover;
            filter: brightness(85%);
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 1rem;
            border-radius: 8px;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .card-title {
            color: #ff6b6b;
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

        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 1.5rem 0;
        }

        .footer a {
            color: #ffcc33;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #e60000 !important;
            border-color: #e60000 !important;
        }

        .btn-primary {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
        }

        .pagination .page-link {
            background-color: #ff9999;
            color: #ffffff;
            border: 1px solid #ff6b6b;
        }

        .pagination .page-link:hover {
            background-color: #ff6666;
            color: white;
            border-color: #ff4b4b;
        }

        .pagination .page-item.active .page-link {
            background-color: #d60000;
            color: white;
            border-color: #d60000;
        }

        .pagination .page-item .page-link {
            color: white;
        }

        .pagination .page-item .page-link:disabled {
            background-color: #f1f1f1;
            color: #ccc;
            border-color: #ddd;
        }


        /* Responsive adjustments */
        @media (max-width: 576px) {
            .carousel-item img {
                height: 250px;
            }

            .card-img-top {
                height: 200px;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <!-- Carousel -->
    <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://media.newyorker.com/photos/59ee325f1685003c9c28c4ad/4:3/w_4992,h_3744,c_limit/Heller-Kirkus-Reviews.jpg" class="d-block w-100" alt="Books">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Hãy khám phá kho sách của chúng tôi</h5>
                    <p>Tìm cuốn sách yêu thích tiếp theo của bạn ngay hôm nay</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTleNea0dn5nmkoLkI-ba2cUQWNV0iNspw5UTVSg8Z8sgc2rf8qMsvb9iJCt6qXBipTp28&usqp=CAU" class="d-block w-100" alt="Reading">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Sellers</h5>
                    <p>Không biết mua gì? Hãy mua một quyển sách best seller.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Tiếp theo</span>
        </button>
    </div>

    <!-- Book Section -->
    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Sách nổi bật</h2>
        <div class="row">
            <?php foreach ($sachs as $sach): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="admin/ql_sach/sach/<?php echo htmlspecialchars($sach->getThemAnh()); ?>" class="card-img-top" alt="Book">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a style="color: #ff6b6b" href="#" data-bs-toggle="modal" data-bs-target="#bookModal<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" class="text-decoration-none">
                                    <?php echo htmlspecialchars($sach->getTenSanPham()); ?>
                                </a>
                            </h5>
                            <p class="card-text text-success fw-bold"><?php echo htmlspecialchars(number_format($sach->getGiaBan(), 0, ',', '.')); ?> VNĐ</p>
                            <form action="DAO/add_to_cart.php" method="post" class="mt-auto">
                                <input type="hidden" name="ma_sach" value="<?php echo htmlspecialchars($sach->getMaSanPham()); ?>">
                                <div class="mb-3">
                                    <label for="so_luong_<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" class="form-label">Số lượng:</label>
                                    <input type="number" class="form-control" name="so_luong" id="so_luong_<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" value="1" min="1" max="100" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="bookModal<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" tabindex="-1" aria-labelledby="bookModalLabel<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookModalLabel<?php echo htmlspecialchars($sach->getMaSanPham()); ?>"><?php echo htmlspecialchars($sach->getTenSanPham()); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="admin/ql_sach/sach/<?php echo htmlspecialchars($sach->getThemAnh()); ?>" class="img-fluid" alt="Book">
                                    </div>
                                    <div class="col-md-8">
                                        <h5>Giá Bán: <span class="text-success fw-bold"><?php echo htmlspecialchars(number_format($sach->getGiaBan(), 0, ',', '.')); ?> VNĐ</span></h5>
                                        <p><strong>Kho:</strong> <?php echo htmlspecialchars($sach->getSoluong()); ?></p>
                                        <p><strong>Tác Giả:</strong> <?php echo htmlspecialchars($sach->getTen_tac_gia()); ?></p>
                                        <p><strong>Năm xuất bản:</strong> <?php echo htmlspecialchars($sach->getNamxuatban()); ?></p>
                                        <p><strong>Nhà Xuất Bản:</strong> <?php echo htmlspecialchars($sach->getTen_nxb()); ?></p>
                                        <p><strong>Thể Loại:</strong> <?php echo htmlspecialchars($sach->getThe_loai()); ?></p>
                                        <p><strong>Mô Tả:</strong> <?php echo htmlspecialchars($sach->getMoTa()); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <form action="DAO/add_to_cart.php" method="post" class="w-100">
                                    <input type="hidden" name="ma_sach" value="<?php echo htmlspecialchars($sach->getMaSanPham()); ?>">
                                    <div class="mb-3">
                                        <label for="so_luong_modal_<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" class="form-label">Số lượng:</label>
                                        <input type="number" class="form-control" name="so_luong" id="so_luong_modal_<?php echo htmlspecialchars($sach->getMaSanPham()); ?>" value="1" min="1" max="100" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($current > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($i == $current) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- toast -->
    <div class="toast" id="cartSuccessToast" data-bs-autohide="true" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Thông Báo</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Sản phẩm đã được thêm vào giỏ hàng thành công!
        </div>
    </div>

    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 BookStore. All Rights Reserved.</p>
            <p>
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
    <!-- gửi form bằng ajax -->
    <script>
        document.querySelectorAll('form[action="DAO/add_to_cart.php"]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === true) {
                            var toast = new bootstrap.Toast(document.getElementById('cartSuccessToast'));
                            toast.show();
                        } else {
                            console.log('Không thành công: ', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Có lỗi xảy ra khi thêm vào giỏ:', error);
                    });
            });
        });
    </script>
    <div id="chat-toggle" title="Chat với trợ lý sách">
        <i class="fas fa-comment-dots"></i>
    </div>
    <div id="chat-panel">
        <div class="chat-header">
            Trợ lý sách
            <span style="float:right;cursor:pointer;font-size:22px;margin-right:2px;" id="chat-close" title="Đóng">&times;</span>
        </div>
        <div id="chat-window"></div>
        <div class="chat-input-group">
            <input id="chat-input" type="text" placeholder="Nhập tin nhắn...">
            <button id="send-btn"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    <style>
        #chat-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff6b6b, #ffcc33);
            border-radius: 50%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1100;
            transition: transform .2s;
        }

        #chat-toggle:hover {
            transform: scale(1.08);
        }

        #chat-toggle i {
            color: #fff;
            font-size: 1.6rem;
        }

        #chat-panel {
            position: fixed;
            bottom: 100px;
            right: 24px;
            width: 340px;
            height: 500px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.16);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0);
            transform-origin: bottom right;
            transition: transform .25s cubic-bezier(.6, -0.2, .7, 1.5);
            z-index: 1099;
        }

        #chat-panel.active {
            transform: scale(1);
        }

        #chat-panel .chat-header {
            padding: 16px 18px;
            background: linear-gradient(135deg, #ff6b6b, #ffcc33);
            color: #fff;
            font-weight: 600;
            font-size: 18px;
            letter-spacing: .5px;
            border-bottom: 1px solid #fff3;
            position: relative;
        }

        #chat-window {
            flex: 1;
            padding: 14px 12px 10px 16px;
            overflow-y: auto;
            background: #f7f8fa;
        }

        .message {
            display: flex;
            margin-bottom: 9px;
        }

        .message.bot {
            justify-content: flex-start;
        }

        .message.user {
            justify-content: flex-end;
        }

        .message .bubble {
            max-width: 74%;
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            font-size: 1rem;
            line-height: 1.55;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            word-break: break-word;
        }

        .message.bot .bubble {
            background: #fff;
            color: #333;
            border-bottom-left-radius: 7px;
        }

        .message.user .bubble {
            background: linear-gradient(135deg, #ff6b6b, #ffcc33);
            color: #fff;
            border-bottom-right-radius: 7px;
        }

        .chat-input-group {
            display: flex;
            padding: 9px;
            background: #fff;
            border-top: 1px solid #f3e7e7;
        }

        .chat-input-group input {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 22px 0 0 22px;
            padding: 9px 16px;
            outline: none;
            font-size: 1.04rem;
            background: #f9fafb;
        }

        .chat-input-group button {
            width: 48px;
            border: none;
            background: #ff6b6b;
            border-radius: 0 22px 22px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
        }

        .chat-input-group button:hover {
            background: #ff4b4b;
        }

        .chat-input-group button i {
            color: #fff;
            font-size: 1.1rem;
        }

        @media (max-width: 450px) {
            #chat-panel {
                right: 7px;
                width: 97vw;
                max-width: 390px;
                height: 70vh;
            }
        }
    </style>
    <script>
        const toggleBtn = document.getElementById('chat-toggle'),
            chatPanel = document.getElementById('chat-panel'),
            chatWindow = document.getElementById('chat-window'),
            chatInput = document.getElementById('chat-input'),
            sendBtn = document.getElementById('send-btn'),
            closeBtn = document.getElementById('chat-close');
        toggleBtn.onclick = () => {
            chatPanel.classList.toggle('active');
            if (chatPanel.classList.contains('active')) chatInput.focus();
        };
        closeBtn.onclick = () => chatPanel.classList.remove('active');
        chatInput.addEventListener('keydown', e => e.key === 'Enter' && sendMessage());
        sendBtn.addEventListener('click', sendMessage);

        function appendMessage(txt, sender) {
            const m = document.createElement('div');
            m.className = `message ${sender==='Bạn'?'user':'bot'}`;
            const b = document.createElement('div');
            b.className = 'bubble';
            b.textContent = txt;
            m.appendChild(b);
            chatWindow.appendChild(m);
            chatWindow.scrollTop = chatWindow.scrollHeight;
        }

        function sendMessage() {
            const t = chatInput.value.trim();
            if (!t) return;
            appendMessage(t, 'Bạn');
            chatInput.value = '';
            fetch('/chat/respond', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        message: t
                    })
                })
                .then(r => r.json()).then(d => appendMessage(d.reply || 'Không có phản hồi', 'Bot'))
                .catch(_ => appendMessage('Lỗi kết nối', 'Bot'));
        }
    </script>
</body>

</html>