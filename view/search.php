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
        html, body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
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
            margin-top: auto;
        }

        .footer a {
            color: #ffcc33;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
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
            z-index: 1050;
            min-width: 250px;
        }

        /* Styling for the search and filter section */
        .search-filters {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-title {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b6b;
        }

        .form-select {
            width: auto;
            flex-grow: 0;
            margin-right: 15px;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 768px) {
            .search-filters {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-title {
                font-size: 20px;
                margin-bottom: 15px;
            }
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
                    <li class="breadcrumb-item"><a href="/index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tìm kiếm sản phẩm</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 search-filters">
            <h2 class="search-title">Kết quả tìm kiếm cho từ khóa "<?= htmlspecialchars($keyWord ?? '') ?>"</h2>
            <div class="d-flex gap-3">
                <select class="form-select" id="genreFilter">
                    <option selected>Chọn thể loại</option>
                    <!-- Các thể loại sẽ được điền từ kết quả tìm kiếm -->
                </select>
                <select class="form-select" id="priceFilter">
                    <option selected>Chọn giá</option>
                    <option value="low">Giá: Từ thấp đến cao</option>
                    <option value="high">Giá: Từ cao đến thấp</option>
                </select>
            </div>
        </div>
    </div>

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
                    <div class="col-lg-4 col-md-6 mb-4 book-card" data-genre="<?= htmlspecialchars($sach['the_loai']) ?>" data-price="<?= $sach['gia_ban'] ?>">
                        <div class="card h-100">
                            <img src="admin/ql_sach/sach/<?= !empty($sach['anh_bia']) ? htmlspecialchars($sach['anh_bia']) : 'https://via.placeholder.com/150' ?>"
                                 class="card-img-top" alt="<?= htmlspecialchars($sach['ten_sach']) ?>">
                            <div class="card-body d-flex flex-column">
                                <!-- Title with Modal Trigger -->
                                <h5 class="card-title">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#bookModal<?= htmlspecialchars($sach['ma_sach']); ?>" class="text-decoration-none" style="color: #ff6b6b;">
                                        <?= htmlspecialchars($sach['ten_sach']) ?>
                                    </a>
                                </h5>
                                <p class="card-text">Tác giả: <?= htmlspecialchars($sach['ten_tac_gia']) ?></p>
                                <p class="card-text">Thể loại: <?= htmlspecialchars($sach['the_loai']) ?></p>
                                <p class="card-text text-success fw-bold"><?= number_format($sach['gia_ban'], 0, ',', '.') ?> VND</p>
                                <form action="DAO/add_to_cart.php" method="post" class="w-100">
                                    <input type="hidden" name="ma_sach" value="<?= htmlspecialchars($sach['ma_sach']); ?>">
                                    <div class="mb-3">
                                        <label for="so_luong_modal_<?php echo htmlspecialchars($sach['ma_sach']); ?>" class="form-label">Số lượng:</label>
                                        <input type="number" class="form-control" name="so_luong" id="so_luong_modal_<?php echo htmlspecialchars($sach['ma_sach']); ?>" value="1" min="1" max="100" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for the current book -->
                    <div class="modal fade" id="bookModal<?= htmlspecialchars($sach['ma_sach']); ?>" tabindex="-1" aria-labelledby="bookModalLabel<?= htmlspecialchars($sach['ma_sach']); ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookModalLabel<?= htmlspecialchars($sach['ma_sach']); ?>">
                                        <?= htmlspecialchars($sach['ten_sach']) ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="admin/ql_sach/sach/<?= htmlspecialchars($sach['anh_bia']); ?>" class="img-fluid" alt="Book Cover">
                                        </div>
                                        <div class="col-md-8">
                                            <h5>Giá Bán: <span class="text-success fw-bold"><?= htmlspecialchars(number_format($sach['gia_ban'], 0, ',', '.')); ?> VNĐ</span></h5>
                                            <p><strong>Kho:</strong> <?= htmlspecialchars($sach['so_luong']); ?></p>
                                            <p><strong>Tác Giả:</strong> <?= htmlspecialchars($sach['ten_tac_gia']); ?></p>
                                            <p><strong>Năm Xuất Bản:</strong> <?= htmlspecialchars($sach['nam_xuat_ban']); ?></p>
                                            <p><strong>Nhà Xuất Bản:</strong> <?= htmlspecialchars($sach['ten_nxb']); ?></p>
                                            <p><strong>Thể Loại:</strong> <?= htmlspecialchars($sach['the_loai']); ?></p>
                                            <p><strong>Mô Tả:</strong> <?= htmlspecialchars($sach['mo_ta']); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer with Add to Cart Form -->
                                <div class="modal-footer">
                                    <form action="DAO/add_to_cart.php" method="post" class="w-100">
                                        <input type="hidden" name="ma_sach" value="<?= htmlspecialchars($sach['ma_sach']); ?>">
                                        <div class="mb-3">
                                            <label for="so_luong_modal_<?php echo htmlspecialchars($sach['ma_sach']); ?>" class="form-label">Số lượng:</label>
                                            <input type="number" class="form-control" name="so_luong" id="so_luong_modal_<?php echo htmlspecialchars($sach['ma_sach']); ?>" value="1" min="1" max="100" required>
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
    document.querySelectorAll('form[action="DAO/add_to_cart.php"]').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // ngừng gửi form

            // gửi form bằng cách fetch api bằng ajax
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

<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2024 BookStore. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </div>
</footer>

</body>
</html>
