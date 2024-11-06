<?php
require_once '../../connect.php'; // Kết nối CSDL

function searchBooks($conn, $keyword)
{
    // Truy vấn để tìm kiếm sách theo tên sách hoặc tên tác giả
    $sql = "SELECT sach.*, tacgia.ten AS ten_tac_gia
            FROM sach 
            JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
            WHERE sach.ten_sach LIKE ? OR tacgia.ten LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);

    // Tạo biến cho tham số
    $searchKeyword = "%" . $keyword . "%";

    // Gán tham số cho câu lệnh
    mysqli_stmt_bind_param($stmt, 'ss', $searchKeyword, $searchKeyword);

    // Thực thi câu lệnh
    mysqli_stmt_execute($stmt);

    // Lấy kết quả
    $result = mysqli_stmt_get_result($stmt);

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    return $books; // Trả về danh sách sách
}

// Lấy từ khóa tìm kiếm từ form
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $books = searchBooks($conn, $keyword);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm sách</title>
    <link rel="stylesheet" href="../../css/timkiemsach.css">
</head>
<body>
    <div class="container">
        <h1>Kết quả tìm kiếm</h1>
        <a href="../trangchu/trang_chu.php" class="back-link">Quay lại trang chủ</a>

        <div class="search-results">
            <?php if (isset($books) && count($books) > 0): ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-item">
                        <img src="images/<?= htmlspecialchars($book['anh_bia']) ?>" alt="<?= htmlspecialchars($book['ten_sach']) ?>" />
                        <div class="book-info">
                            <h3><?= htmlspecialchars($book['ten_sach']) ?></h3>
                            <p>Tác giả: <?= htmlspecialchars($book['ten_tac_gia']) ?></p>
                            <p>Giá: <?= number_format($book['gia_ban'], 0, ',', '.') ?> VND</p>
                            <form action="../giohang/form_giohang.php" method="post">
                                <input type="hidden" name="ma_sach" value="<?= htmlspecialchars($book['ma_sach']) ?>">
                                <input type="hidden" name="ten_sach" value="<?= htmlspecialchars($book['ten_sach']) ?>">
                                <input type="hidden" name="gia" value="<?= htmlspecialchars($book['gia_ban']) ?>">
                                <label for="so_luong">Số lượng:</label>
                                <input type="number" name="so_luong" min="1" value="1">
                                <button type="submit" name="add_to_cart" class="add-to-cart">Thêm vào giỏ hàng</button>
                            </form>
                            <a href="../thanhtoan/form_thanhtoan.php?ma_sach=<?= $book['ma_sach'] ?>" class="buy-now">Mua ngay</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">Không tìm thấy sách nào.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
