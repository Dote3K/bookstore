<?php
require '../../checker/kiemtra_admin.php';
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-top: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
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
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0b7dda;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }


        #form1, #form2, #form3 {
            display: none;
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
include '../../connect.php';

if(isset($_GET['ngay_dat_hang']) || isset($_GET['month']) || isset($_GET['yearonly'])) {
    include '../../controllers/doanhthuController.php';
    $controller = new doanhthufunction($conn);

    if (isset($_GET['ngay_dat_hang'])) {
        $result = $controller->doanhThuNgay($_GET['ngay_dat_hang']);
        $result3 = $controller->bestSellerNgay($_GET['ngay_dat_hang']);
        $header = 'Ngày';
        $header3 = 'Sách bán chạy trong ngày';
    } elseif (isset($_GET['month']) && isset($_GET['year'])) {
        $result = $controller->chiTietDoanhThuThang($_GET['month'], $_GET['year']);
        $result2 = $controller->doanhThuThang($_GET['month'], $_GET['year']);
        $result3 = $controller->bestSellerThang($_GET['month'], $_GET['year']);
        $header2 = 'Theo ngày trong tháng';
        $header = 'Tháng';
        $header3 = 'Sách bán chạy trong tháng';
    } elseif (isset($_GET['yearonly'])) {
        $result = $controller->chiTietDoanhThuNam($_GET['yearonly']);
        $result2 = $controller->doanhThuNam($_GET['yearonly']);
        $result3 = $controller->bestSellerNam($_GET['yearonly']);
        $header2 = 'Theo tháng trong năm';
        $header = 'Năm';
        $header3 = 'Sách bán chạy trong năm';
    }

    if ($result && $result->num_rows > 0) {

        echo "<table border='1'>
                <tr>
                    <th>{$header}</th>
                    <th>Số đơn</th>
                    <th>Số sách đã bán</th>
                    <th>Doanh thu</th>
                    <th>Lợi nhuận</th>
                </tr>";
        if (isset($_GET['month']) || isset($_GET['yearonly'])) {
            while ($row = $result2->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['ngay_dat_hang']}</td>
                    <td>{$row['so_don']}</td>
                    <td>{$row['so_luong']}</td>
                    <td>{$row['doanh_thu']}</td>
                    <td>{$row['loi_nhuan']}</td>
                  </tr>";
            }
            echo "</table><br>";
            echo "<table border='1'><tr>
                    <th>{$header2}</th>
                    <th>Số đơn</th>
                    <th>Số sách đã bán</th>
                    <th>Doanh thu</th>
                    <th>Lợi nhuận</th>
                    
                </tr>";
        }

        while ($row = $result->fetch_assoc()) {
            if (isset($_GET['yearonly'])) {
                $date_format = date("m/Y", strtotime($row['ngay_dat_hang']));
            } else {
                $date_format = date("d/m/Y", strtotime($row['ngay_dat_hang']));
            }
            echo "<tr>
                    <td>{$date_format}</td>
                    <td>{$row['so_don']}</td>
                    <td>{$row['so_luong']}</td>
                    <td>{$row['doanh_thu']}</td>
                    <td>{$row['loi_nhuan']}</td>
                  </tr>";
        }
        echo "</table>";
        echo "<table border='1'>
                <tr>
                    <th colspan='2'>{$header3}</th>
                    <th>Số sách đã bán</th>
                </tr>";
        while ($row = $result3->fetch_assoc()) {
            echo "<tr>
                    <td style='width: 120px'><img src='../ql_sach/sach/{$row['anh_bia']}' alt='Ảnh bìa' style='width: 100px; height: auto;'></td>
                    <td>{$row['ten_sach']}</td>
                    <td>{$row['so_luong_ban']}</td>
                  </tr>";
        }
        echo "</table>";

    }
    else {
        echo "<br><br>0 kết quả<br><br>";
    }
}
echo '<button><a href="../admin_page.php">Trở về trang quản lý</a></button>';
?>
</body>
</html>
