<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_sach = $_POST['ten_sach'];
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ma_nxb = $_POST['ma_nxb'];
    $ma_the_loai = $_POST['ma_the_loai'];
    $gia_mua = $_POST['gia_mua'];
    $gia_ban = $_POST['gia_ban'];
    $so_luong = $_POST['so_luong'];
    $nam_xuat_ban = $_POST['nam_xuat_ban'];
    $mo_ta = $_POST['mo_ta'];

    $anh_bia = '';
    if (isset($_FILES['anh_bia']) && $_FILES['anh_bia']['error'] == 0) {
        $target_dir = "anhbia/";
        $target_file = $target_dir . basename($_FILES["anh_bia"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["anh_bia"]["tmp_name"], $target_file)) {
                $anh_bia = $target_file;
            } else {
                echo "Lỗi.";
            }
        } else {
            echo "Chỉ cho phép các định dạng JPG, JPEG, PNG";
        }
    }

    $sql = "INSERT INTO sach(ten_sach, ma_tac_gia, ma_nxb, ma_the_loai, gia_mua, gia_ban, so_luong, nam_xuat_ban, mo_ta, anh_bia) 
            VALUES ('$ten_sach', '$ma_tac_gia', '$ma_nxb', '$ma_the_loai', '$gia_mua', '$gia_ban', '$so_luong', '$nam_xuat_ban', '$mo_ta', '$anh_bia')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success-msg'>Thêm thành công</p>";
    } else {
        echo "<p class='error-msg'>Lỗi do: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sách</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
            margin-top: 30px;
        }

        h1 {
            font-size: 28px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
            text-align: left;
        }

        input[type="text"], input[type="number"], input[type="file"], select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            background-color: #d81b60;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2185b;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #d81b60;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #c2185b;
        }

        .success-msg {
            color: #4CAF50;
            font-weight: bold;
        }

        .error-msg {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Thêm Sách Mới</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="ten_sach">Tên Sách</label>
        <input type="text" name="ten_sach" id="ten_sach" required>

        <label for="ma_tac_gia">Mã Tác Giả</label>
        <select name="ma_tac_gia" id="ma_tac_gia">
            <option value="">Chọn tác giả</option>
            <?php
            $sql = "SELECT ma_tac_gia, ten from tacgia";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    echo '<option value="' . $row["ma_tac_gia"] . '">' . $row["ten"] . '</option>';
                }
            } else {
                echo '<option value="">Không có tác giả</option>';
            }
            ?>
        </select>

        <label for="ma_nxb">Mã Nhà Xuất Bản</label>
        <select name="ma_nxb" id="ma_nxb">
            <option value="">Chọn NXB</option>
            <?php
            $sql = "SELECT ma_nxb, ten from nxb";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    echo '<option value="' . $row["ma_nxb"] . '">' . $row["ten"] . '</option>';
                }
            } else {
                echo '<option value="">Không có NXB</option>';
            }
            ?>
        </select>

        <label for="ma_the_loai">Mã Thể Loại</label>
        <select name="ma_the_loai" id="ma_the_loai">
            <option value="">Chọn Thể Loại</option>
            <?php
            $sql = "SELECT ma_the_loai, the_loai from theloai";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_array()) {
                    echo '<option value="' . $row["ma_the_loai"] . '">' . $row["the_loai"] . '</option>';
                }
            } else {
                echo '<option value="">Không có thể loại</option>';
            }
            ?>
        </select>

        <label for="gia_mua">Giá Mua</label>
        <input type="number" name="gia_mua" id="gia_mua" required>

        <label for="gia_ban">Giá Bán</label>
        <input type="number" name="gia_ban" id="gia_ban" required>

        <label for="so_luong">Số Lượng</label>
        <input type="number" name="so_luong" id="so_luong" required>

        <label for="nam_xuat_ban">Năm Xuất Bản</label>
        <input type="number" name="nam_xuat_ban" id="nam_xuat_ban" required>

        <label for="mo_ta">Mô Tả</label>
        <input type="text" name="mo_ta" id="mo_ta" required>

        <label for="anh_bia">Ảnh Bìa</label>
        <input type="file" name="anh_bia" id="anh_bia" required>

        <button type="submit">Thêm Sách</button>
    </form>
    <a href="show_sach.php" class="back-link">Trở về trang quản lý sách</a><br>
    <a href="../../admin_page.php" class="back-link">Trang chủ</a>
</div>
</body>
</html>
