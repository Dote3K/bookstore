<?php
require_once '../checker/kiemtra_login.php';
require_once '../DAO/sachDAO.php';
require_once '../DAO/donhangDAO.php';

if(!isset($_SESSION['ma_khach_hang'])) {
    header("Location: login.php");
    exit();
}

$sachDAO = new sachDAO();
$selected_books = $_SESSION['selected_books'] ?? [];


// Xử lý thanh toán khi sách được lấy từ home.php và findBook.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ma_sach_home'])) {
    $ma_sach_home = $_POST['ma_sach_home'];
    if (!in_array($ma_sach_home, $selected_books)) {
        $selected_books[] = $ma_sach_home;
        $_SESSION['selected_books'] = $selected_books;
    }
}
// Xử lý thanh toán khi sách được lấy từ cart.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_books_cart'])) {
    $selected_books_cart = $_POST['selected_books_cart'];
    foreach ($selected_books_cart as $ma_sach) {
        if (!in_array($ma_sach, $selected_books)) {
            $selected_books[] = $ma_sach;
        }
    }
    $_SESSION['selected_books'] = $selected_books;
}

// Xử lý cập nhật số lượng sản phẩm trong giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    foreach ($_POST['quantity'] as $ma_sach => $so_luong) {
        if ($so_luong > 0 && $so_luong <= $_SESSION['book_quantities'][$ma_sach]) {
            $_SESSION['selected_books'][$ma_sach] = $so_luong;
        }
    }
    $_SESSION['selected_books'] = $selected_books;
}
// Chuyển hướng sau khi xác nhận thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    $ma_khach_hang = $_SESSION['ma_khach_hang'];
    $dia_chi_nhan_hang = $_POST['dia_chi_nhan_hang'] ?? '';
    $giam_gia = $_POST['giam_gia'] ?? 0;

    $total_cost = calculateTotalCost($selected_books, $sachDAO);
    $_SESSION['total_cost'] = $total_cost - $giam_gia;

    $donHangDAO = new DonHangDAO();
    $donHangDAO->addOrder($ma_khach_hang, $_SESSION['total_cost'], $dia_chi_nhan_hang, $giam_gia, 'DANG_CHO');

    header("Location: orderStatus.php");
    exit();
}

function calculateTotalCost($selected_books, $sachDAO) {
    $total_cost = 0;
    foreach ($selected_books as $ma_sach => $so_luong) {
        $thongTinChiTiet = $sachDAO->getBookById($ma_sach);
        if ($thongTinChiTiet) {
            $gia_ban = $thongTinChiTiet['gia_ban'];
            $total_cost += $gia_ban * $so_luong;
        }
    }
    return $total_cost;
}

    // unset($_SESSION['selected_books']);
    // header("Location: orderStatus.php");
    // exit();
// }

// Xóa các session `ma_sach_home` và `selected_books`
if (isset($_GET['action']) && $_GET['action'] === 'unset_sessions') {
    unset($_SESSION['selected_books']);
    echo "Sessions cleared";
    exit;
}
 ?>

<!-- Xóa session khi chuyển trang -->
<!--script>
window.addEventListener('beforeunload', function() {
    // Gửi yêu cầu AJAX đến cùng `checkout.php` để xóa session
    navigator.sendBeacon('checkout.php?action=unset_sessions');
});
</script-->
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
        <h1 class="text-center mb-4">Your orders</h1>

        <?php
        if (!empty($selected_books)) {
            // Loại bỏ các mã sách bị trùng lặp trong giỏ hàng
            $selected_books = array_unique($selected_books);
            $total_cost = 0;

            echo '<div class="container my-5">';
            echo '<form method="POST" action="">';

            foreach ($selected_books as $ma_sach) {
                $thongTinChiTiet = $sachDAO->getBookById($ma_sach);
                if ($thongTinChiTiet) {
                    $anh_bia = htmlspecialchars($thongTinChiTiet['anh_bia'] ?? 'default_image.jpg');
                    $ten_sach = htmlspecialchars($thongTinChiTiet['ten_sach'] ?? 'Tên sách không có');
                    $tac_gia = htmlspecialchars($thongTinChiTiet['ten_tacgia'] ?? 'Chưa có thông tin tác giả');
                    $the_loai = htmlspecialchars($thongTinChiTiet['the_loai'] ?? 'Chưa có thông tin thể loại');
                    $nha_xuat_ban = htmlspecialchars($thongTinChiTiet['ten_nxb'] ?? 'Chưa có thông tin nhà xuất bản');
                    $gia_ban = htmlspecialchars($thongTinChiTiet['gia_ban'] ?? 'Chưa có giá');
                    $mo_ta = htmlspecialchars($thongTinChiTiet['mo_ta'] ?? 'Chưa có mô tả');
                    $so_luong = $thongTinChiTiet['so_luong'] ?? 1;

                    // Hiển thị thông tin sách đã chọn dưới phần header
                    echo '<div class="card mb-4">';
                    echo '<div class="row g-0">';
                    echo '<div class="col-md-4">';
                    echo '<img src="' . $anh_bia . '" class="img-fluid rounded-start" alt="Book">';
                    echo '</div>';
                    echo '<div class="col-md-8">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $ten_sach . '</h5>';
                    echo '<p class="card-text">Tác giả: ' . $tac_gia . '</p>';
                    echo '<p class="card-text">Thể loại: ' . $the_loai . '</p>';
                    echo '<p class="card-text">Nhà xuất bản: ' . $nha_xuat_ban . '</p>';
                    echo '<p class="card-text">Mô tả: ' . $mo_ta . '</p>';
                    echo '<p class="card-text">Giá: <span class="book-price" data-price="' . $gia_ban . '">' . $gia_ban . '</span></p>';
                    echo '<p class="card-text">Số lượng hiện có: ' . $so_luong . '</p>';
                    echo '<div class="input-group mb-3">
                          <span class="input-group-text">Số lượng</span>
                          <input type="number" class="form-control quantity-input" name="quantity[' . $ma_sach . ']" value="1" min="1" max="' . $so_luong . '" onchange="updateTotalCost()">
                      </div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    // Tính tổng tiền cho các sách
                    $total_cost += $gia_ban * 1; 
                }
            }

            echo '<div class="text-end mb-3">';
            echo '<button class="btn btn-warning" type="submit" name="confirm_payment">Xác nhận thanh toán</button>';
            echo '</div>';
            echo '<h3 id="total_cost">Tổng tiền: ' . $total_cost . '</h3>';
            echo '</form>';
        } else {
            echo '<p class="text-center">Giỏ hàng của bạn trống. Hãy thêm sản phẩm vào giỏ hàng.</p>';
        }
        ?>
        <!-- Footer -->
        <footer class="footer text-center">
            <div class="container">
                <p>&copy; 2023 BookStore. All Rights Reserved.</p>
                <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </footer>

        <script>
        function updateTotalCost() {
            let total_cost = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                let quantity = parseInt(input.value) || 1;
                let price = parseFloat(input.closest('.card-body').querySelector('.book-price').getAttribute(
                    'data-price')) || 0;
                total_cost += quantity * price;
            });
            document.getElementById('total_cost').textContent = "Tổng tiền: " + total_cost;
        }
        </script>

</body>

</html>