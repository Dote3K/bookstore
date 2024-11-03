<?php
session_start();

// Khởi tạo giỏ hàng để lưu trữ thông tin sản phẩm người dùng
// thêm vào giỏ hàng nếu giỏ hàng chưa tồn tại.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Thêm sản phẩm vào giỏ hàng
function addToCart($bookId, $quantity)
{
    if (isset($_SESSION['cart'][$bookId])) { // Nếu tồn tại sách trong giỏ hàng
        $_SESSION['cart'][$bookId] += $quantity; // thì tăng số lượng của sản phẩm đó lên bằng cách cộng thêm $quantity vào giá trị hiện tại. 
    } else {
        $_SESSION['cart'][$bookId] = $quantity; // nếu sản phẩm chưa có trong giỏ hàng, tạo 1 mục mới  trong giỏ hàng với khóa $bookId, giá trị $quantity để lưu số lượng sản phẩm
    }
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart($bookId)
{
    unset($_SESSION['cart'][$bookId]); // xóa mã sách khỏi giỏ hàng
}

// Lấy giỏ hàng hiện tại
function getCartItems($db)
{
    $cartItems = [];
    // Duyệt từng phần tử sách với số lượng của nó trong giỏ hàng
    foreach ($_SESSION['cart'] as $bookId => $quantity) {
        $query = 'SELECT * FROM sach WHERE ma_sach = ?';
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $bookId);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($book) {
            $book['quantity'] = $quantity; // ['quantity'] là biến được thêm vào mảng $book để lưu số lượng sách mà người dùng đã chọn trong giỏ hàng.
            $cartItems[] = $book;
        }
    }
    return $cartItems;
}
