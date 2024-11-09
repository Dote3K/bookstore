<?php
require_once '../checker/kiemtra_login.php';
require_once '../DAO/sachDAO.php';

if(!isset($_SESSION['ma_khach_hang'])) {
    header("Location: login.php");
    exit();
}

$selected_books = $_POST['selected_books'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ma_sach'])) {
    // Thêm mã sách vào danh sách sách đã chọn
    $selected_books[] = $_POST['ma_sach'];
    $_SESSION['selected_books'] = $selected_books;
}

if (!empty($selected_books)) {
    $sachDAO = new sachDAO();
    // Hiển thị thông tin sách đã chọn
    foreach ($selected_books as $ma_sach) {    
        $thongTinChiTiet = $sachDAO->getBookById($ma_sach);  // Lấy thông tin sách từ database
        if ($thongTinChiTiet) {
            echo "<pre>";
            print_r($thongTinChiTiet); // In ra thông tin chi tiết sách để kiểm tra
            echo "</pre>";
        } else {
            echo "Không tìm thấy thông tin sách!";
        }
    }
} else {
    echo "Không có mã sách được gửi!";
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
        <h1 class="text-center mb-4">Checkout</h1>

        <?php if (isset($thongTinChiTiet) && $thongTinChiTiet): ?>
        <div class="card mb-4">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($thongTinChiTiet['anh_bia'] ?? 'default_image.jpg'); ?>"
                        class="img-fluid rounded-start" alt="Book">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= htmlspecialchars($thongTinChiTiet['ten_sach'] ?? 'Tên sách không có'); ?></h5>
                        <p class="card-text">Tác giả:
                            <?= htmlspecialchars($thongTinChiTiet['tac_gia'] ?? 'Chưa có thông tin tác giả'); ?></p>
                        <p class="card-text">Thể loại:
                            <?= htmlspecialchars($thongTinChiTiet['the_loai'] ?? 'Chưa có thông tin thể loại'); ?></p>
                        <p class="card-text">Nhà xuất bản:
                            <?= htmlspecialchars($thongTinChiTiet['nha_xuat_ban'] ?? 'Chưa có thông tin nhà xuất bản'); ?>
                        </p>
                        <p class="card-text">Giá: <?= htmlspecialchars($thongTinChiTiet['gia_ban'] ?? 'Chưa có giá'); ?>
                        </p>
                        <p class="card-text"><?= htmlspecialchars($thongTinChiTiet['mo_ta'] ?? 'Chưa có mô tả'); ?></p>
                        <a href="checkout.php?ma_sach=<?= $ma_sach; ?>" class="btn btn-primary">Proceed to Payment</a>
                        <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <p class="text-danger text-center">No product information available.</p>
        <?php endif; ?>
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