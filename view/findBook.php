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
    <title>Book Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
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

    .footer {
        background-color: #333333;
        color: #ffffff;
        padding: 1.5rem 0;
    }

    .footer a {
        color: #ffcc33;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <?php include 'header.php'; 
    require_once(__DIR__ . '/../model/sach.php'); ?>

    <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
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
    </div>


    <div class="container my-5">
        <h2 class="text-center text-primary mb-4">Kết quả tìm kiếm</h2>

        <!-- Kiểm tra và hiển thị kết quả tìm kiếm -->
        <div class="row">
            <?php if (isset($sachs) && is_array($sachs) && !empty($sachs)): ?>
            <?php foreach ($sachs as $sach): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php echo "<img src='admin/ql_sach/sach/{$sach['anh_bia']}' class='card-img-top' alt='Book'>" ?>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($sach['ten_sach']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($sach['gia_ban']); ?></p>

                        <form action="/view/checkout.php" method="POST">
                            <?php if (isset($_SESSION['ma_khach_hang'])): ?>
                            <input type="hidden" name="ma_sach_home" value="<?php echo $sach['ma_sach']?>">
                            <button type="submit" class="btn btn-primary">Buy Now</button>
                            <?php else: ?>
                            <a href="../KhachHangRouter.php?action=login" class="btn btn-primary">Buy Now</a>
                            <?php endif; ?>
                        </form>

                        <br>

                        <form action="/view/cart.php" method="POST">
                            <?php if(isset($_SESSION['ma_khach_hang'])): ?>
                            <input type="hidden" name="add_to_cart" value="<?= $sach['ma_sach'] ?>">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                            <?php else: ?>
                            <a href="../KhachHangRouter.php?action=login" class="btn btn-primary">Add to Cart</a>
                            <?php endif ?>
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
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

</body>

</html>