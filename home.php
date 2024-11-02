<?php



require 'checker/kiemtra_login.php';

echo "Vai trò: " . ($_SESSION['vai_tro'] === 'admin' ? "Admin " : "Người dùng ");

echo '<br><a href="user/hienThi.php">Thông tin tài khoản</a><br>'
?>

<a href="logout.php">Đăng xuất</a>
