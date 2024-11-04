<?php
require_once '../../connect.php'; // Kết nối CSDL

// Hàm lấy tất cả các sách
function getAllBooks($conn)
{
    $query = 'SELECT * FROM sach';
    $result = mysqli_query($conn, $query); // Thực hiện truy vấn

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) { // Lặp qua từng dòng kết quả
        $books[] = $row; // Thêm dòng vào mảng sách
    }

    return $books; // Trả về danh sách sách
}

// Lấy danh sách các thể loại
function getAllCategories($conn)
{
    $query = 'SELECT * FROM theloai';
    $result = mysqli_query($conn, $query);
    $categories = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }

    return $categories;
}

// Lấy sách theo thể loại
function getBooksByCategory($conn, $categoryId)
{
    $sql = "SELECT sach.*, theloai.the_loai AS ten_the_loai, tacgia.ten AS ten_tac_gia
            FROM sach 
            JOIN theloai ON sach.ma_the_loai = theloai.ma_the_loai  
            JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
            WHERE sach.ma_the_loai = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    return $books;
}


// Lấy tên tác giả từ mã tác giả
function getAuthorName($conn, $authorId)
{
    $query = 'SELECT ten FROM tacgia WHERE ma_tac_gia = ?';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $authorId); // Gán tham số
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row ? $row['ten'] : 'Không xác định';
}
function getBookById($conn, $bookId)
{
    $stmt = mysqli_prepare($conn, "SELECT * FROM sach WHERE ma_sach = ?");
    mysqli_stmt_bind_param($stmt, 'i', $bookId); // Gán tham số
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result); // Trả về sách
}
