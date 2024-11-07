<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM nxb";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Nhà Xuất Bản</title>
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
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 16px;
        }

        th {
            background-color: #d81b60;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fce4ec;
        }

        tr:hover {
            background-color: #f8bbd0;
        }

        button {
            background-color: #d81b60;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
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

        .action-buttons a {
            margin: 0 5px;
            text-decoration: none;
        }

        .action-buttons button {
            padding: 6px 10px;
            font-size: 13px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Thông tin Nhà Xuất Bản</h1>
    <table>
        <tr>
            <th>Mã nhà xuất bản</th>
            <th>Tên Nhà xuất bản</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Chức năng</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($count = $result->fetch_array()) {
                echo "<tr>
                        <td>{$count['ma_nxb']}</td>
                        <td>{$count['ten']}</td>
                        <td>{$count['dia_chi']}</td>
                        <td>{$count['sdt']}</td>
                        <td>{$count['email']}</td>
                        <td class='action-buttons'>
                            <a href='edit_nxb.php?ma_nxb={$count['ma_nxb']}'><button>Chỉnh Sửa</button></a> 
                            <a href='xoa_nxb.php?ma_nxb={$count['ma_nxb']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa NXB này?\")'><button>Xóa</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
        }
        ?>
    </table>
    <a href="add_nxb.php" class="back-link">Thêm Nhà Xuất Bản</a><br>
    <a href="../../admin_page.php" class="back-link">Trang chủ</a>
</div>
</body>
</html>
