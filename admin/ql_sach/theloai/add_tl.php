<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $the_loai = $_POST['the_loai'];
    $sql = "INSERT INTO theloai(the_loai) VALUES ('$the_loai')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green; text-align: center;'>Thêm thành công</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi do: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Thể Loại</title>

</head>
<body>
    <div class="container">
        <h1>Thêm Thể Loại</h1>
        <form method="post">
            <label>Tên Thể Loại</label><br>
            <input type="text" name="the_loai" required><br>
            <button type="submit">Thêm Thể Loại</button>
        </form>
        <div class="button-container">
            <a href="show_the_loai.php" class="back-link">Trở về trang quản lý thể loại</a>

        </div>
    </div>
</body>
</html>
