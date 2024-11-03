<?php
require_once '../backend/db.php'; // Kết nối CSDL

function searchBooks($db, $keyword)
{
    // Truy vấn để tìm kiếm sách theo tên sách hoặc tên tác giả
    $sql = "SELECT sach.*, tacgia.ten AS ten_tac_gia
            FROM sach 
            JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
            WHERE sach.ten_sach LIKE :keyword OR tacgia.ten LIKE :keyword";

    $stmt = $db->prepare($sql);
    $stmt->execute(['keyword' => "%$keyword%"]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy từ khóa tìm kiếm từ form
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $books = searchBooks($db, $keyword);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm sách</title>
</head>

<body>
    <h1>Kết quả tìm kiếm</h1>
    <a href="index.php">Quay lại trang chủ</a>
    <div>
        <?php if (isset($books) && count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <div>
                    <h3><?= $book['ten_sach'] ?></h3>
                    <p>Tác giả: <?= $book['ten_tac_gia'] ?></p>
                    <p>Giá: <?= $book['gia_ban'] ?> VND</p>
                    <img src="images/<?= $book['anh_bia'] ?>" alt="<?= $book['ten_sach'] ?>"
                        style="width: 100px; height: 150px;" />
                    <form action="cart.php" method="post">
                        <input type="hidden" name="ma_sach" value="<?= $book['ma_sach'] ?>">
                        <input type="hidden" name="ten_sach" value="<?= $book['ten_sach'] ?>">
                        <input type="hidden" name="gia" value="<?= $book['gia_ban'] ?>">
                        <label for="so_luong">Số lượng:</label>
                        <input type="number" name="so_luong" min="1" value="1">
                        <button type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>
                    </form>
                    <a href="checkout.php?bookId=<?= $book['ma_sach'] ?>">Mua ngay</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy sách nào.</p>
        <?php endif; ?>
    </div>
</body>

</html>