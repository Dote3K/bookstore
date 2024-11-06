<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chủ</title>
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
            margin-top: 50px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #d81b60;
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .button-container a {
            background-color: #d81b60;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .button-container a:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chào mừng đến với Trang chủ</h1>
        <div class="button-container">
            <a href="/bookstore/admin/qlkh/quanlikhachhang.php">Quản lý khách hàng</a>
            <a href="/bookstore/admin/ql_sach/nxb/show_nxb.php">Quản lý nhà xuất bản</a>
            <a href="/bookstore/admin/ql_sach/tacgia/show_tacgia.php">Quản lý tác giả</a>
            <a href="/bookstore/admin/ql_sach/theloai/show_the_loai.php">Quản lý thể loại</a>
            <a href="/bookstore/admin/ql_sach/sach/show_sach.php">Quản lý sách</a>
            <a href="/bookstore/admin/doanhthu/doanhthu.php">Quản lý doanh thu</a>
            <a href="/bookstore/DonHangRouter.php?action=list">Quản lý đơn hàng</a>
        </div>
    </div>
</body>
</html>
