<?php
require_once 'db.php'; // Kết nối CSDL

// Hàm lấy tất cả các sách
function getAllBooks($db)
{
    $query = 'SELECT * FROM sach';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy danh sách các thể loại
function getAllCategories($db)
{
    $query = 'SELECT * FROM theloai';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lấy sách theo thể loại
function getBooksByCategory($db, $categoryId)
{
    $sql = "SELECT sach.*, theloai.the_loai AS ten_the_loai, tacgia.ten AS ten_tac_gia
            FROM sach 
            JOIN theloai ON sach.ma_the_loai = theloai.ma_the_loai  
            JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
            WHERE sach.ma_the_loai = :categoryId";
    // :categoryId khai báo tham số rằng buôc trong Sql
    $stmt = $db->prepare($sql);
    $stmt->execute(['categoryId' => $categoryId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Lấy tên tác giả từ mã tác giả
function getAuthorName($db, $authorId)
{
    $query = 'SELECT ten FROM tacgia WHERE ma_tac_gia = :authorId';
    $stmt = $db->prepare($query);
    // bindValue(): gán giá trị không thể bị thay đổi sau khi bindValue đã được gọi
    // bindParam(): giá trị sẽ thay đổi theo biến (nếu biến thay đổi).
    $stmt->bindValue(':authorId', $authorId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['ten'] : 'Không xác định';
}
function getBookById($db, $bookId)
{
    $stmt = $db->prepare("SELECT * FROM sach WHERE ma_sach = ?");
    $stmt->execute([$bookId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
