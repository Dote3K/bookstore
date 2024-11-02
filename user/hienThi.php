<?php

require '../connect.php';


include '../checker/kiemtra_login.php';
$ma_khach_hang = $_SESSION['ma_khach_hang'];
$sql = "SELECT * FROM khachhang where ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();


echo "<center><h3>THÔNG TIN TÀI KHOẢN</h3></center>";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      echo "<div style='border: 1px solid ; padding: 20px; margin-bottom: 20px; width: 60%;  margin-left: auto; margin-right: auto;'>";

      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Tên đăng nhập:</strong> " . htmlspecialchars($row['ten_dang_nhap']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Họ và tên:</strong> " . htmlspecialchars($row['ho_va_ten']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Giới tính:</strong> " . htmlspecialchars($row["gioi_tinh"]) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Ngày sinh:</strong> " . htmlspecialchars($row['ngay_sinh']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Địa chỉ:</strong> " . htmlspecialchars($row["dia_chi"]) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Địa chỉ nhận hàng:</strong> " . htmlspecialchars($row['dia_chi_nhan_hang']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Số điện thoại:</strong> " . htmlspecialchars($row['so_dien_thoai']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</div>";
      echo "<div style='border-bottom: 1px solid ; padding: 10px;'><strong>Đăng ký nhận bản tin:</strong> " . htmlspecialchars($row['dang_ky_nhan_ban_tin']) . "</div>";

      echo "</div>";
      echo "<div id='buttoncss'><center><a href='suaThongTin.php?id={$row['ma_khach_hang']}'>Sửa</a></center><br>";
      echo "<center><a href='doiMatKhau.php'>Đổi mật khẩu</a></center><br>";
      echo "<center><a href='xoa.php?id={$row['ma_khach_hang']}'>Xóa tài khoản</a></center></div>";
  }
} else {
  echo "<div style='text-align: center;'>Không tìm thấy kết quả.<br></div>";
  echo "<div style='text-align: center;'>Vui lòng <a href='../register.php'>đăng nhập.</a></div>";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
      #buttoncss{
          a {
              width: 60%;
              margin-left: auto;
              margin-right: auto;
              background-color: pink;
              padding: 14px 25px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
          }
      }
    </style>
</head>
<body>
    
</body>
</html>

