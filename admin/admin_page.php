<?php
require '../checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị</title>
    <style>
        /* Định dạng tổng quan */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4); /* Nền gradient hồng nhẹ */
            margin: 0;
            padding: 0;
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
            color: #d81b60; /* Màu hồng đậm cho tiêu đề */
            margin-bottom: 20px;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-container a {
            text-decoration: none;
        }

        button {
            background-color: #d81b60; /* Màu hồng cho nút */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            max-width: 250px;
        }

        button:hover {
            background-color: #c2185b; /* Màu hồng đậm hơn khi hover */
        }

        .back-link {
            margin-top: 20px;
            display: inline-block;
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
    </style>
</head>
<body>

<div class="container">
    <h1>Trang Quản Trị</h1>
    <div class="btn-container">
        <a href="doanhthu/doanhthu.php"><button>Quản lý doanh thu</button></a>
        <a href="qlkh/quanlikhachhang.php"><button>Quản lý khách hàng</button></a>
        <a href="ql_sach/nxb/show_nxb.php"><button>Nhà xuất bản</button></a>
        <a href="ql_sach/tacgia/show_tacgia.php"><button>Tác Giả</button></a>
        <a href="ql_sach/theloai/show_the_loai.php"><button>Thể loại</button></a>
        <a href="ql_sach/sach/show_sach.php"><button>Sách</button></a>
    </div>
    <a href="../home.php" class="back-link">Trở về trang chủ</a>
</div>

</body>
</html>
