<?php
require_once '../../connect.php'; // Kết nối CSDL
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang Chủ</title>
    <link rel="stylesheet" href="../../css/trangchu.css">
</head>

<body>
    <h1><a href="trang_chu.php">Trang Chủ</a></h1>
    <form action="tim_kiem_sach.php" method="get">
        <input type="text" name="keyword" placeholder="Tìm sách hoặc tác giả..." required>
        <button type="submit">Tìm kiếm</button>
    </form>
    <a href="../giohang/form_giohang.php">Xem Giỏ Hàng</a>
    <a href="../donhang/form_donhang.php">Đơn hàng</a>

    <div style="display: flex;">
        <!-- Danh sách thể loại bên trái -->
        <aside style="width: 20%;">
            <h2>Thể loại</h2>
            <ul>
                <?php
                require_once 'chucnang_sach.php';
                $categories = getAllCategories($conn);
                foreach ($categories as $category) {
                    echo "<li><a href='trang_chu.php?categoryId={$category['ma_the_loai']}'>{$category['the_loai']}</a></li>";
                }
                ?>
            </ul>
        </aside>

        <!-- Danh sách sách ở phần chính giữa -->
        <main style="width: 75%;">
            <h2>Danh sách sách</h2>
            <?php
            $books = isset($_GET['categoryId']) ? getBooksByCategory($conn, $_GET['categoryId']) : getAllBooks($conn);
            foreach ($books as $book) {
                // Lấy tên tác giả dựa vào mã tác giả
                $authorName = getAuthorName($conn, $book['ma_tac_gia']);
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
                echo "<img src='images/{$book['anh_bia']}' alt='{$book['ten_sach']}' style='width: 100px; height: 150px;' />";
                echo "<h3>{$book['ten_sach']}</h3>";
                echo "<p>Tác giả: {$authorName}</p>";
                echo "<p>Thể loại: {$category['the_loai']}</p>";
                echo "<p>Giá: {$book['gia_ban']} VND</p>";

                // Form thêm vào giỏ hàng
                echo "<form action='../giohang/form_giohang.php' method='post'>";
                echo "<input type='hidden' name='ma_sach' value='{$book['ma_sach']}'>";
                echo "<input type='hidden' name='ten_sach' value='{$book['ten_sach']}'>";
                echo "<input type='hidden' name='gia' value='{$book['gia_ban']}'>";
                echo "<label for='so_luong'>Số lượng:</label>";
                echo "<input type='number' name='so_luong' min='1' value='1'>";
                echo "<button type='submit' name='add_to_cart'>Thêm vào giỏ hàng</button>";
                echo "</form>";

                // Nút mua ngay
                echo "<form action='../thanhtoan/form_thanhtoan.php' method='post'>";
                echo "<input type='hidden' name='ma_sach' value='{$book['ma_sach']}'>";
                echo "<input type='hidden' name='so_luong' value='1'>"; // Mặc định số lượng là 1
                echo "<button type='submit' name='buy_now'>Mua ngay</button>";
                echo "</form>";

                echo "</div>";
            }
            ?>
        </main>
    </div>
</body>

</html>