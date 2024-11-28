<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
        }

        .navbar {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: bold;
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

        .breadcrumb-item a {
            color: #e60000;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .alert {
            font-size: 1rem;
            font-weight: 500;
            background-color: #ffeeba;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #e60000 !important;
            border-color: #e60000 !important;
        }

        .btn-primary {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-img-top {
                height: 200px;
            }
        }

        /* Custom toast style */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050; /* Ensure it's above other content */
            min-width: 250px;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>

<div class="container mt-4">
    <div class="row mt-5">
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<%=url%>/index.jsp">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tìm kiếm sản phẩm</li>
                </ol>
            </nav>
        </div>
        <h2 class="text-center text-primary mb-4">Kết quả tìm kiếm cho từ khóa "<?= htmlspecialchars($keyWord ?? '') ?>"</h2>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <select class="form-select d-inline-block w-auto" id="genreFilter">
                <option selected>Chọn thể loại</option>
                <!-- Các thể loại sẽ được điền từ kết quả tìm kiếm -->
            </select>
            <select class="form-select d-inline-block w-auto" id="priceFilter">
                <option selected>Chọn giá</option>
                <option value="low">Giá: Từ thấp đến cao</option>
                <option value="high">Giá: Từ cao đến thấp</option>
            </select>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php if (!empty($sachs)): ?>
            <?php
            // Lưu các thể loại để điền vào dropdown
            $genres = [];
            foreach ($sachs as $sach) {
                if (!in_array($sach['the_loai'], $genres)) {
                    $genres[] = $sach['the_loai'];
                }
            }
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const genreSelect = document.getElementById('genreFilter');
                    const genres = <?= json_encode($genres) ?>;
                    genres.forEach(function(genre) {
                        const option = document.createElement('option');
                        option.value = genre.toLowerCase();
                        option.textContent = genre;
                        genreSelect.appendChild(option);
                    });
                });
            </script>

            <div class="row" id="bookCardsContainer">
                <?php foreach ($sachs as $sach): ?>
                    <div class="col-lg-4 col-md-6 mb-4 book-card" data-genre="<?= htmlspecialchars($sach['the_loai']) ?>"
                         data-price="<?= $sach['gia_ban'] ?>">
                        <div class="card h-100">
                            <img src="admin/ql_sach/sach/<?= !empty($sach['anh_bia']) ? htmlspecialchars($sach['anh_bia']) : 'https://via.placeholder.com/150' ?>"
                                 class="card-img-top" alt="<?= htmlspecialchars($sach['ten_sach']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($sach['ten_sach']) ?></h5>
                                <p class="card-text">Tác giả: <?= htmlspecialchars($sach['ten_tac_gia']) ?></p>
                                <p class="card-text">Thể loại: <?= htmlspecialchars($sach['the_loai']) ?></p>
                                <p class="card-text text-success fw-bold"><?= number_format($sach['gia_ban'], 0, ',', '.') ?> VND</p>
                                <form action="view/addCartSearch.php" method="POST" class="mt-auto add-to-cart-form">
                                    <input type="hidden" name="bookId" value="<?= $sach['ma_sach'] ?>">
                                    <input type="hidden" name="so_luong" value="1">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    Không tìm thấy sách cho từ khóa "<?= htmlspecialchars($keyWord ?? '') ?>"
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Toast -->
<div class="toast" id="cartSuccessToast" data-bs-autohide="true" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="me-auto">Thông Báo</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Sản phẩm đã được thêm vào giỏ hàng thành công!
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const genreFilter = document.getElementById('genreFilter');
        const priceFilter = document.getElementById('priceFilter');
        const bookCardsContainer = document.getElementById('bookCardsContainer');
        const bookCards = Array.from(document.querySelectorAll('.book-card'));
        const toast = new bootstrap.Toast(document.getElementById('cartSuccessToast'));

        genreFilter.addEventListener('change', applyFilters);
        priceFilter.addEventListener('change', applyFilters);

        function applyFilters() {
            const selectedGenre = genreFilter.value.toLowerCase();
            const selectedPrice = priceFilter.value;

            // Filter theo thể loại
            let filteredCards = bookCards.filter(card => {
                const genre = card.getAttribute('data-genre').toLowerCase();
                return selectedGenre === 'chọn thể loại' || genre === selectedGenre;
            });

            // Sắp xếp theo giá nếu có bộ lọc giá
            if (selectedPrice === 'low' || selectedPrice === 'high') {
                filteredCards.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    return selectedPrice === 'low'
                        ? priceA - priceB  // Từ thấp đến cao
                        : priceB - priceA; // Từ cao đến thấp
                });
            }

            // Cập nhật lại danh sách sách hiển thị
            if (filteredCards.length > 0) {
                bookCardsContainer.innerHTML = '';
                filteredCards.forEach(card => {
                    bookCardsContainer.appendChild(card);
                });
            } else {
                const noResultsHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            Không tìm thấy sách cho bộ lọc đã chọn
                        </div>
                    </div>
                `;
                bookCardsContainer.innerHTML = noResultsHTML;
            }
        }
    });
    document.querySelectorAll('form[action="view/addCartSearch.php"]').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // ngừng gửi form

            // gửi form bằng cách fetch api bằng ajax
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
                .then(response => response.text())
                .then(data => {
                    var toast = new bootstrap.Toast(document.getElementById('cartSuccessToast'));
                    toast.show();
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra khi thêm vào giỏ:', error);
                });
        });
    });
</script>

<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2023 BookStore. Tất cả quyền được bảo lưu.</p>
        <p>
            <a href="#">Chính sách bảo mật</a> |
            <a href="#">Điều khoản dịch vụ</a>
        </p>
    </div>
</footer>

</body>
</html>
