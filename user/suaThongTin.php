<?php 
    require '../connect.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM khachhang WHERE ma_khach_hang='$id'";
        $result = $conn->query($sql);
        $khachhang = $result->fetch_assoc();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ma_khach_hang = $_POST['ma_khach_hang'];
        $ten_dang_nhap = $_POST['ten_dang_nhap'];
        // $mat_khau = $_POST['mat_khau'];
        $ho_va_ten = $_POST['ho_va_ten'];
        $gioi_tinh = $_POST['gioi_tinh'];
        $ngay_sinh = $_POST['ngay_sinh'];
        $dia_chi = $_POST['dia_chi'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $email = $_POST['email'];

        $sql = "UPDATE khachhang SET ten_dang_nhap='$ten_dang_nhap', ho_va_ten='$ho_va_ten', gioi_tinh='$gioi_tinh', ngay_sinh='$ngay_sinh', dia_chi='$dia_chi', so_dien_thoai='$so_dien_thoai', email='$email' WHERE ma_khach_hang='$ma_khach_hang'";
        $conn->query($sql);
        if($conn->query($sql)  === TRUE ){
            header('Location: hienThi.php');
        }
        else{
            echo "Lỗi: ". $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Khách Hàng</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { width: 60%; margin: 50px auto; background-color: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; }
        h2 { text-align: center; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: bold; }
        input[type="text"], input[type="date"], input[type="email"], select { padding: 10px; font-size: 16px; width: 100%; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { padding: 10px; font-size: 16px; background-color: pink; color: white; border: none; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa Thông Tin Khách Hàng</h2>
        <form method="POST" action="">
            <label for="ma_khach_hang">Mã khách hàng:</label>
            <input type="text" name="ma_khach_hang" value="<?= $khachhang['ma_khach_hang'] ?>" readonly>

            <label for="ten_dang_nhap">Tên đăng nhập:</label>
            <input type="text" name="ten_dang_nhap" value="<?= $khachhang['ten_dang_nhap'] ?>" required>


            <label for="ho_va_ten">Họ và tên:</label>
            <input type="text" name="ho_va_ten" value="<?= $khachhang['ho_va_ten'] ?>" required>

            <label for="gioi_tinh">Giới tính:</label>
            <select name="gioi_tinh">
                <option value="Nam" <?= $khachhang['gioi_tinh'] === 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?= $khachhang['gioi_tinh'] === 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
            </select>

            <label for="ngay_sinh">Ngày sinh:</label>
            <input type="date" name="ngay_sinh" value="<?= $khachhang['ngay_sinh'] ?>" required>

            <label for="dia_chi">Địa chỉ:</label>
            <input type="text" name="dia_chi" value="<?= $khachhang['dia_chi'] ?>">

            <label for="so_dien_thoai">Số điện thoại:</label>
            <input type="text" name="so_dien_thoai" value="<?= $khachhang['so_dien_thoai'] ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $khachhang['email'] ?>" required>

            <input type="submit" value="Cập nhật">
        </form>
    </div>
</body>
</html>
