<?php
require '../checker/kiemtra_login.php';

if (!isset($_SESSION['ma_khach_hang'])) {
    header("Location: login.php");
    exit();
}
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function addToCart($ma_sach) {
    if(!isset($_SESSION['cart'][$ma_sach])) {
        $_SESSION['cart'][$ma_sach] = $ma_sach;
    }
}
if(isset($_POST['add_to_cart'])) {
    $ma_sach = $_POST['add_to_cart'];
    addToCart($ma_sach);
    header("Location: cart.php");
    exit();
}
function removeFromCart($selected_books_cart) {
    foreach ($selected_books_cart as $ma_sach) {
            unset($_SESSION['cart'][$ma_sach]);     
    }
}

if (isset($_POST['removeFromCart'])) {
    $selected_books_cart = $_POST['selected_books_cart'] ?? [];
    removeFromCart($selected_books_cart);
    header("Location: cart.php");
    exit();
}


if (isset($_POST['buyNow'])) {
    $selected_books_cart = $_POST['selected_books_cart'] ?? [];

    if(!empty($selected_books_cart)) {
        $_SESSION['selected_books'] = $selected_books_cart;
        header("Location: checkout.php");
        exit();
    } else {
        echo "<script>alert('Vui lòng chọn ít nhất một sản phẩm để tiếp tục!');</script>";
    }
    
   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
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
        background: linear-gradient(45deg, #a8d0e6, #f8b195);
        color: #333;
    }

    .navbar {
        background: linear-gradient(45deg, #374785, #f76c6c);
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
        color: #374785;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #f76c6c;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #e63946;
    }

    .btn-danger {
        background-color: #ff5a5f;
        border: none;
    }

    .btn-danger:hover {
        background-color: #d9534f;
    }

    .footer {
        background-color: #374785;
        color: #ffffff;
        padding: 1.5rem 0;
    }

    .footer a {
        color: #f8b195;
        text-decoration: none;
    }

    .footer a:hover {
        color: #ff5a5f;
    }
    </style>
</head>

<body>
    <?php include 'header.php';
    require_once '../DAO/sachDAO.php'; ?>

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
        <h2 class="text-center text-primary mb-4">My Cart</h2>

        <form action="cart.php" method="POST">
            <div class="row">
                <?php if (!empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $ma_sach):
                    $sach = (new sachDAO())->getBookById($ma_sach); 
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="admin/ql_sach/sach/<?= htmlspecialchars($sach['anh_bia']) ?>" class="card-img-top"
                            alt="Book">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($sach['ten_sach']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($sach['gia_ban']); ?></p>
                            <label><input type="checkbox" name="selected_books_cart[]" value="<?= $ma_sach ?>">
                            </label>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-center">Giỏ hàng của bạn hiện trống.</p>
                <?php endif; ?>
            </div>

            <?php if (!empty($_SESSION['cart'])): ?>
            <button type="submit" name="buyNow" class="btn btn-primary">Buy Now</button>
            <button type="submit" name="removeFromCart" class="btn btn-danger">Remove from Cart</button>
            <?php endif; ?>
        </form>
    </div>

    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2023 BookStore. All Rights Reserved.</p>
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>

</body>

</html>
