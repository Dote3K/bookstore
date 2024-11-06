<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM sach";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin Sách</title>
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
            max-width: 1000px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            margin-top: 30px;
        }

        h1 {
            font-size: 28px;
            color: #d81b60;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: center;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #d81b60;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #d81b60;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px;
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

        img {
            width: 100px;
            height: auto;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Thông tin Sách</h1>
    <table>
        <tr>
            <th>Mã Sách</th>
            <th>Tên Sách</th>
            <th>Tác giả</th>
            <th>Nhà xuất bản</th>
            <th>Thể loại</th>
            <th>Giá mua</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Năm xuất bản</th>
            <th>Mô tả</th>
            <th>Ảnh bìa</th>
            <th>Chức năng</th>
        </tr>
        <?php
        $sach = $result->num_rows;
        if ($sach > 0) {
            while ($count = $result->fetch_array()) {
                $ma_tac_gia = $count['ma_tac_gia'];
                $sql1 = "SELECT ten FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
                $ten_tac_gia = $conn->query($sql1)->fetch_array()['ten'] ?? 'N/A';

                $ma_nxb = $count['ma_nxb'];
                $sql2 = "SELECT ten FROM nxb WHERE ma_nxb = $ma_nxb";
                $ten_nxb = $conn->query($sql2)->fetch_array()['ten'] ?? 'N/A';

                $ma_the_loai = $count['ma_the_loai'];
                $sql3 = "SELECT the_loai FROM theloai WHERE ma_the_loai = $ma_the_loai";
                $the_loai = $conn->query($sql3)->fetch_array()['the_loai'] ?? 'N/A';

                echo "<tr>
                        <td>{$count['ma_sach']}</td>
                        <td>{$count['ten_sach']}</td>
                        <td>{$ten_tac_gia}</td>
                        <td>{$ten_nxb}</td>
                        <td>{$the_loai}</td>
                        <td>{$count['gia_mua']} VND</td>
                        <td>{$count['gia_ban']} VND</td>
                        <td>{$count['so_luong']}</td>
                        <td>{$count['nam_xuat_ban']}</td>
                        <td>{$count['mo_ta']}</td>
                        <td><img src='{$count['anh_bia']}' alt='Ảnh bìa'></td>
                        <td>
                            <a href='edit_sach.php?ma_sach={$count['ma_sach']}'><button>Chỉnh Sửa</button></a> 
                            <a href='xoa_sach.php?ma_sach={$count['ma_sach']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa sách này?')\"><button>Xóa</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='12'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
        }
        ?>
    </table>
    <a href="add_book.php" class="back-link">Thêm sách</a>
    <a href="../../admin_page.php" class="back-link">Trang chủ</a>
</div>
</body>
</html>
