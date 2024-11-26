<?php
require_once '../DAO/sachDAO.php';

// Xử lý tìm kiếm sách
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
    $sachs = (new sachDAO())->timKiemSach($tukhoa);

    // Chuyển hướng về lại findBook.php với kết quả tìm kiếm
    header("Location: findBook.php?tukhoa=" . urlencode($tukhoa));
    exit();
}

// Kiểm tra nếu có từ khóa tìm kiếm qua GET (từ chuyển hướng)
if (isset($_GET['tukhoa'])) {
    $tukhoa = $_GET['tukhoa'];
    $sachs = (new sachDAO())->timKiemSach($tukhoa);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store - Kết quả tìm kiếm</title>
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
    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#bookCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>
    <!-- Carousel Inner -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://media.newyorker.com/photos/59ee325f1685003c9c28c4ad/4:3/w_4992,h_3744,c_limit/Heller-Kirkus-Reviews.jpg"
                 class="d-block w-100" alt="Books">
            <div class="carousel-caption d-none d-md-block">
                <h5>Explore Our Collection</h5>
                <p>Find your next favorite book today!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTleNea0dn5nmkoLkI-ba2cUQWNV0iNspw5UTVSg8Z8sgc2rf8qMsvb9iJCt6qXBipTp28&usqp=CAU"
                 class="d-block w-100" alt="Reading">
            <div class="carousel-caption d-none d-md-block">
                <h5>Best Sellers</h5>
                <p>Discover the top-rated books of the season.</p>
            </div>
        </div>
    </div>
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Trước</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Tiếp theo</span>
    </button>
</div>

<!-- Search Results Section -->
<div class="container my-5">
    <h2 class="text-center text-primary mb-4">Kết quả tìm kiếm cho "<?php echo htmlspecialchars($tukhoa); ?>"</h2>

    <!-- Kiểm tra và hiển thị kết quả tìm kiếm -->
    <div class="row">
        <?php if (isset($sachs) && is_array($sachs) && !empty($sachs)): ?>
            <?php foreach ($sachs as $sach): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="/admin/ql_sach/sach/<?php echo htmlspecialchars($sach['anh_bia']); ?>" class="card-img-top"
                             alt="Book">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($sach['ten_sach']); ?></h5>
                            <p class="card-text text-success fw-bold">
                                <?php echo htmlspecialchars(number_format($sach['gia_ban'], 0, ',', '.')); ?> VNĐ
                            </p>
                            <form action="/DAO/add_to_cart.php" method="post" class="mt-auto">
                                <input type="hidden" name="ma_sach" value="<?php echo htmlspecialchars($sach['ma_sach']); ?>">
                                <div class="mb-3">
                                    <label for="so_luong_<?php echo htmlspecialchars($sach['ma_sach']); ?>"
                                           class="form-label">Số lượng:</label>
                                    <input type="number" class="form-control"
                                           name="so_luong"
                                           id="so_luong_<?php echo htmlspecialchars($sach['ma_sach']); ?>"
                                           value="1" min="1" max="100" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Hiện chưa có sách nào để hiển thị.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2023 BookStore. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </div>
</footer>

</body>

</html>
