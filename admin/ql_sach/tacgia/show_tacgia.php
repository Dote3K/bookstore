<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM tacgia";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Tác Giả</title>
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
            margin-bottom: 20px;
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
        <h1>Thông tin Tác Giả</h1>
        <table>
            <tr>
                <th>Mã Tác Giả</th>
                <th>Tên</th>
                <th>Tiểu Sử</th>
                <th>Chức Năng</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($count = $result->fetch_array()) {
                    echo "<tr>
                        <td>{$count['ma_tac_gia']}</td>
                        <td>{$count['ten']}</td>
                        <td>{$count['tieu_su']}</td>
                        <td>
                            <a href='edit_tg.php?ma_tac_gia={$count['ma_tac_gia']}'><button>Chỉnh Sửa</button></a> 
                            <a href='xoa_tg.php?ma_tac_gia={$count['ma_tac_gia']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa tác giả này?\")'><button>Xóa</button></a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Không có tác giả nào trong cơ sở dữ liệu</td></tr>";
            }
            ?>
        </table>
        <div class="button-container">
            <a href="add_tg.php" class="back-link">Thêm Tác Giả</a>
            <a href="../../admin_page.php" class="back-link">Trang Chủ</a>
        </div>
    </div>
</body>
</html>
