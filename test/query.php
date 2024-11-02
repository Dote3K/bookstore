
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
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

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="date"], select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        .no-result {
            font-style: italic;
            color: #ff0000;
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
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>
<h1>Quản lý doanh thu</h1>
<button onclick="showForm('form1')">Doanh thu theo ngày</button>
<button onclick="showForm('form2')">Doanh thu theo tháng</button>
<button onclick="showForm('form3')">Doanh thu theo năm</button>

<div id="form1" style="display:none;">
<form method="get" action="">
    <label for="date">Chọn ngày: </label>
    <input type="date" name="ngay_dat_hang" id="ngay_dat_hang">
    <br>
    <br>
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
                echo "\t<option value='".$year."'>".$year."</option>\n\r";
            } // https://stackoverflow.com/questions/7083123/populate-a-select-box-with-years-using-php
            ?>
        </select>
        <input type="submit" value="Gửi">
    </form>
</div>
<div id="form3" style="display:none;">
    <form method="get" action="">
        <label for="yearonly">Năm:</label>
        <select name="yearonly" id="yearonly" required>
            <?php
            foreach(range(2020, (int)date("Y")) as $year) {
                echo "\t<option value='".$year."'>".$year."</option>\n\r";
            } // https://stackoverflow.com/questions/7083123/populate-a-select-box-with-years-using-php
            ?>
        </select>
        <input type="submit" value="Gửi">
    </form>
</div>
<?php if(isset($_GET['ngay_dat_hang'])):
    $ngay_dat_hang = $_GET['ngay_dat_hang'];
    $sql1 = "SELECT 
    DATE(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(s.gia_ban * ctdh.so_luong) as doanh_thu,
    SUM((s.gia_ban - s.gia_mua) * ctdh.so_luong) - dh.giam_gia AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND DATE(dh.ngay_dat_hang) = '$ngay_dat_hang'
GROUP BY
    DATE(dh.ngay_dat_hang);";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Ngày</th>
                <th>Số đơn</th>
                <th>Số sách đã bán</th>
                <th>Doanh thu</th>
                <th>Lợi nhuận</th>
                
            </tr>";
        while($row = $result1->fetch_assoc()) {
            echo "<tr>
                <td>{$row['ngay_dat_hang']}</td>
                <td>{$row['so_don']}</td>
                <td>{$row['so_luong']}</td>
                <td>{$row['doanh_thu']}</td>
                <td>{$row['loi_nhuan']}</td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "<br><br>0 kết quả";
    }
endif;
    ?>

<?php
if(isset($_GET['month']) && isset($_GET['year'])):
    $month = $_GET['month'];
    $year = $_GET['year'];
    $sql2 = "SELECT 
    MONTH(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(s.gia_ban * ctdh.so_luong) as doanh_thu,
    SUM((s.gia_ban - s.gia_mua) * ctdh.so_luong) - (
        SELECT SUM(giam_gia) 
        FROM donhang 
        WHERE trang_thai = 'DA_GIAO' 
        AND MONTH(dh.ngay_dat_hang) = '$month'
        AND YEAR(ngay_dat_hang) = '$year'
    ) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND MONTH(dh.ngay_dat_hang) = '$month'
    AND YEAR(dh.ngay_dat_hang) = '$year'
GROUP BY
    MONTH(dh.ngay_dat_hang);";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Tháng</th>
                <th>Số đơn</th>
                <th>Số sách đã bán</th>
                <th>Doanh thu</th>
                <th>Lợi nhuận</th>
                
            </tr>";
        while($row = $result2->fetch_assoc()) {
            echo "<tr>
                <td>{$row['ngay_dat_hang']}</td>
                <td>{$row['so_don']}</td>
                <td>{$row['so_luong']}</td>
                <td>{$row['doanh_thu']}</td>
                <td>{$row['loi_nhuan']}</td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "<br><br>0 kết quả";
    }
endif;
?>


<?php
if(isset($_GET['yearonly'])):
    $yearonly = $_GET['yearonly'];
    $sql3 = "SELECT  
    YEAR(dh.ngay_dat_hang) AS ngay_dat_hang,
    SUM(s.gia_ban * ctdh.so_luong) AS doanh_thu,
    SUM((s.gia_ban - s.gia_mua) * ctdh.so_luong) - (
        SELECT SUM(giam_gia) 
        FROM donhang 
        WHERE trang_thai = 'DA_GIAO' 
        AND YEAR(ngay_dat_hang) = '$yearonly'
    ) AS loi_nhuan,
    SUM(ctdh.so_luong) AS so_luong,
    COUNT(DISTINCT ctdh.ma_don_hang) AS so_don
FROM 
    donhang dh
JOIN 
    chitietdonhang ctdh ON dh.ma_don_hang = ctdh.ma_don_hang
JOIN 
    sach s ON ctdh.ma_sach = s.ma_sach
WHERE
    dh.trang_thai = 'DA_GIAO'
    AND YEAR(dh.ngay_dat_hang) = '$yearonly'
GROUP BY
    YEAR(dh.ngay_dat_hang);
";
    $result3 = $conn->query($sql3);
    if ($result3->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Ngày</th>
                <th>Số đơn</th>
                <th>Số sách đã bán</th>
                <th>Doanh thu</th>
                <th>Lợi nhuận</th>
                
            </tr>";
        while($row = $result3->fetch_assoc()) {
            echo "<tr>
                <td>{$row['ngay_dat_hang']}</td>
                <td>{$row['so_don']}</td>
                <td>{$row['so_luong']}</td>
                <td>{$row['doanh_thu']}</td>
                <td>{$row['loi_nhuan']}</td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "<br><br>0 kết quả";
    }
endif;
?>
</body>
</html>
