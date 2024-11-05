<?php
session_start();
require_once '../trangchu/chucnang_sach.php';
require_once '../../connect.php';

if (!isset($_SESSION['ma_khach_hang'])) {
    echo "Vui lòng đăng nhập để thanh toán đơn hàng của bạn";
    exit();
}

// Kiểm tra xem có sản phẩm nào trong giỏ hàng hoặc sản phẩm "Mua ngay" được gửi tới không
$cartItems = [];
if (isset($_POST['cart']) && !empty($_POST['cart'])) {
    // Trường hợp sản phẩm trong giỏ hàng
    $cartItems = $_POST['cart'];
} elseif (isset($_POST['ma_sach']) && !empty($_POST['ma_sach'])) {
    // Trường hợp người dùng nhấn "Mua ngay"
    $maSach = $_POST['ma_sach'];
    $soLuong = $_POST['so_luong'] ?? 1;
    $book = getBookById($conn, $maSach);
    $authorName = getAuthorName($conn, $book['ma_tac_gia']);

    // Tạo mảng chứa sản phẩm mua ngay
    $cartItems[$maSach] = [
        'ten_sach' => $book['ten_sach'],
        'gia' => $book['gia_ban'],
        'so_luong' => $soLuong,
    ];
} else {
    echo "Không có sản phẩm nào được chọn.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="../../css/formthanhtoan.css">
</head>
<body>
    <h1>Thanh Toán</h1>

    <?php foreach ($cartItems as $maSach => $item):
        $book = getBookById($conn, $maSach);
        $authorName = getAuthorName($conn, $book['ma_tac_gia']);
    ?>
        <div class="book-info">
            <img src="images/<?php echo htmlspecialchars($book['anh_bia']); ?>" alt="<?php echo htmlspecialchars($book['ten_sach']); ?>" />
            <div>
                <h2><?php echo htmlspecialchars($item['ten_sach']); ?></h2>
                <p>Tác giả: <?php echo htmlspecialchars($authorName); ?></p>
                <p>Giá: <span id="price_<?php echo $maSach; ?>"><?php echo htmlspecialchars($item['gia']); ?> VND</span></p>
                
                <form action="../donhang/form_donhang.php" method="post" class="paymentForm">
                    <input type="hidden" name="ma_sach" value="<?php echo htmlspecialchars($maSach); ?>">
                    <input type="hidden" name="gia" value="<?php echo htmlspecialchars($item['gia']); ?>">
                    <input type="hidden" name="cart" value="<?php echo htmlspecialchars(json_encode($cartItems)); ?>">
                    
                    <label for="so_luong_<?php echo $maSach; ?>">Số lượng:</label>
                    <input type="number" id="so_luong_<?php echo $maSach; ?>" name="so_luong" min="1" value="<?php echo $item['so_luong']; ?>" max="<?php echo htmlspecialchars($book['so_luong']); ?>" required>
                    
                    <p>Tổng chi phí: <span id="total_cost_<?php echo $maSach; ?>" class="total-cost"><?php echo htmlspecialchars($item['gia'] * $item['so_luong']); ?> VND</span></p>

                    <label for="payment_method">Hình thức thanh toán:</label>
                    <select name="payment_method" required>
                        <option value="" disabled selected>Chọn hình thức thanh toán</option>
                        <option value="cod">Thanh toán khi nhận hàng</option>
                        <option value="prepaid">Thanh toán trước</option>
                    </select>

                    <button type="submit" name="confirm_payment" class="confirm-button">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <a href="../trangchu/trang_chu.php" class="back-link">Quay về trang chủ</a>

    <script>
        const quantityInputs = document.querySelectorAll('input[id^="so_luong_"]');
        quantityInputs.forEach(input => {
            const bookId = input.id.split('_')[2];
            const price = parseFloat(document.getElementById(`price_${bookId}`).textContent);
            const totalCost = document.getElementById(`total_cost_${bookId}`);

            input.addEventListener('input', () => {
                totalCost.textContent = (price * input.value).toLocaleString() + " VND";
            });
        });
    </script>
</body>
</html>
