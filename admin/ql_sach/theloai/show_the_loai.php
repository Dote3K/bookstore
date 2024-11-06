<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM theloai";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin thể loại</title>
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
            max-width: 800px;
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
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
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

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        button, .back-link {
            background-color: #d81b60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        button:hover, .back-link:hover {
            background-color: #c2185b;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Thông tin thể loại</h1>
        <table>
            <tr>
                <th>Mã thể loại</th>
                <th>Tên thể loại</th>
                <th>Chức năng</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($count = $result->fetch_array()) {
                    echo "<tr>
                            <td>{$count['ma_the_loai']}</td>
                            <td>{$count['the_loai']}</td>
                            <td>
                                <a href='edit_tl.php?ma_the_loai={$count['ma_the_loai']}'><button>Chỉnh Sửa</button></a> 
                                <a href='xoa_tl.php?ma_the_loai={$count['ma_the_loai']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa?')\"><button>Xóa</button></a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Không có thể loại nào trong cơ sở dữ liệu</td></tr>";
            }
            ?>
        </table>

        <div class="button-container">
            <a href="add_tl.php" class="back-link">Thêm thể loại</a>
            <a href="../../admin_page.php" class="back-link">Trang chủ</a>
        </div>
    </div>
</body>
</html>
