<?php
require '../connect.php';
include '../checker/kiemtra_login.php';

$ma_khach_hang = $_SESSION['ma_khach_hang'];
$sql = "SELECT * FROM khachhang where ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();

echo "<center><h3 style='color: #2c3e50;'>THÔNG TIN TÀI KHOẢN</h3></center>";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      echo "<div style='border: 1px solid #ddd; background-color: #f7f9fc; padding: 20px; margin-bottom: 20px; width: 60%; margin-left: auto; margin-right: auto; border-radius: 8px;'>";

      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Tên đăng nhập:</strong> " . htmlspecialchars($row['ten_dang_nhap']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Họ và tên:</strong> " . htmlspecialchars($row['ho_va_ten']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Giới tính:</strong> " . htmlspecialchars($row["gioi_tinh"]) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Ngày sinh:</strong> " . htmlspecialchars($row['ngay_sinh']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Địa chỉ:</strong> " . htmlspecialchars($row["dia_chi"]) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Địa chỉ nhận hàng:</strong> " . htmlspecialchars($row['dia_chi_nhan_hang']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Số điện thoại:</strong> " . htmlspecialchars($row['so_dien_thoai']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</div>";
      echo "<div style='border-bottom: 1px solid #ddd; padding: 10px; color: #34495e;'><strong>Đăng ký nhận bản tin:</strong> " . htmlspecialchars($row['dang_ky_nhan_ban_tin']) . "</div>";

      echo "</div>";
      echo "<div style='text-align: center; margin-top: 20px;'>";
      echo "<a href='suaThongTin.php?id={$row['ma_khach_hang']}' style='color: white; background-color: #3498db; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-right: 10px;'>Sửa</a>";
      echo "<a href='doiMatKhau.php' style='color: white; background-color: #2ecc71; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; margin-right: 10px;'>Đổi mật khẩu</a>";
      echo "<a href='javascript:void(0);' onclick='xacNhanXoa({$row['ma_khach_hang']});' style='color: white; background-color: #e74c3c; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;'>Xóa tài khoản</a>";
      echo "</div>";
  }
} else {
  echo "<div style='text-align: center; color: #e74c3c;'>Không tìm thấy kết quả.<br></div>";
  echo "<div style='text-align: center;'>Vui lòng <a href='../view/login.php' style='color: #3498db; text-decoration: none;'>đăng nhập.</a></div>";
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Tài Khoản</title>
    <style>
      a {
          display: inline-block;
          padding: 10px 20px;
          text-align: center;
          text-decoration: none;
          color: white;
          font-weight: bold;
          margin: 10px 5px;
          border-radius: 5px;
          transition: background-color 0.3s ease;
      }
    </style>
    <script>
        function xacNhanXoa(id) {
            var kq = confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tài khoản này không?');
            if (kq) {
                window.location.href = 'xoa.php?id=' + id;
            }
        }
    </script>
</head>
<body>
</body>
</html>
