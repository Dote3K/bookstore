<?php
// require '../../checker/kiemtra_admin.php';
include '../sidebar.php';
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thống kê doanh thu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ff9a9e, #fad0c4); /* Tông màu gradient hồng nhẹ */
            margin: 0;
            padding: 0;
            text-align: center;
            color: #333;
        }

        h1 {
            color: #d81b60; /* Màu hồng đậm cho tiêu đề */
            margin-top: 20px;
            font-size: 28px;
        }

        button {
            background-color: #c2185b; /* Màu hồng đậm cho nút */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin: 10px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ad1457; /* Màu hồng đậm hơn khi hover */
        }

        form {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            display: inline-block;
            text-align: left;
            max-width: 400px;
            width: 100%;
        }

        label, select, input[type="date"], input[type="submit"] {
            font-size: 16px;
            margin: 10px 0;
            display: block;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #e57373; /* Màu hồng nhạt cho nút gửi */
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #ef5350; /* Màu hồng đậm hơn khi hover */
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 90%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #c2185b; /* Màu hồng cho tiêu đề bảng */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fce4ec; /* Màu hồng nhạt cho hàng chẵn */
        }

        tr:hover {
            background-color: #f8bbd0; /* Màu hồng nhạt hơn khi hover */
        }

        #form1, #form2, #form3 {
            display: none;
        }

        .back-button {
            margin-top: 20px;
            display: inline-block;
            background-color: #d81b60;
            color: white;
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .back-button:hover {
            background-color: #ad1457;
        }

        a {
            color: inherit;
            text-decoration: none;
        }
    </style>

    <script>
        function showForm(formId) {
            const forms = ['form1', 'form2', 'form3'];
            forms.forEach(function(id) {
                document.getElementById(id).style.display = 'none';
            });
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</head>
<body>
<h1>Thống kê doanh thu</h1>
<button onclick="showForm('form1')">Doanh thu theo ngày</button>
<button onclick="showForm('form2')">Doanh thu theo tháng</button>
<button onclick="showForm('form3')">Doanh thu theo năm</button>

<div id="form1" style="display:none;">
    <form method="get" action="">
        <label for="date">Chọn ngày: </label>
        <input type="date" name="ngay_dat_hang" id="ngay_dat_hang">
        <input type="submit" value="Hiển thị doanh thu">
    </form>
</div>
<div id="form2" style="display:none;">
    <form method="get" action="">
        <label for="month">Tháng:</label>
        <select name="month" id="month" required>
            <?php
            $months = [
                1 => 'Tháng 1',
                2 => 'Tháng 2',
                3 => 'Tháng 3',
                4 => 'Tháng 4',
                5 => 'Tháng 5',
                6 => 'Tháng 6',
                7 => 'Tháng 7',
                8 => 'Tháng 8',
                9 => 'Tháng 9',
                10 => 'Tháng 10',
                11 => 'Tháng 11',
                12 => 'Tháng 12',
            ];
            foreach ($months as $value => $name) {
                echo "<option value=\"$value\">$name</option>";
            }
            ?>
        </select>
        <label for="year">Năm:</label>
        <select name="year" id="year" required>
            <?php
            foreach(range(2020, (int)date("Y")) as $year) {
                echo "<option value='".$year."'>".$year."</option>";
            }
            ?>
        </select>
        <input type="submit" value="Hiển thị doanh thu">
    </form>
</div>
<div id="form3" style="display:none;">
    <form method="get" action="">
        <label for="yearonly">Năm:</label>
        <select name="yearonly" id="yearonly" required>
            <?php
            foreach(range(2020, (int)date("Y")) as $year) {
                echo "<option value='".$year."'>".$year."</option>";
            }
            ?>
        </select>
        <input type="submit" value="Hiển thị doanh thu">
    </form>
</div>

<?php
?>
<a href="../admin_page.php" class="back-button">Trở về trang quản lý</a>
</body>
</html>
