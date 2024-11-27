<?php
require '../../checker/kiemtra_admin.php';
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê doanh thu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        #form1, #form2, #form3 {
            display: none;
        }
        .table thead {
            background-color: #4da6ff;
            color: white;
        }
        .sidebar {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #e9ecef;
            padding: 10px;
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
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <?php include '../sidebar.php'; ?>
        </nav>
        <!-- Nội dung chính -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 text-center">
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Thông tin Sách</h1>

            </header>
            <div class="btn-group mt-3" role="group">
                <button type="button" class="btn btn-primary" onclick="showForm('form1')">Doanh thu theo ngày</button>
                <button type="button" class="btn btn-primary" onclick="showForm('form2')">Doanh thu theo tháng</button>
                <button type="button" class="btn btn-primary" onclick="showForm('form3')">Doanh thu theo năm</button>
            </div>


            <div id="form1" class="mt-3">
                <form method="get" action="" class="mx-auto" style="max-width: 400px;">
                    <div class="mb-3">
                        <label for="ngay_dat_hang" class="form-label">Chọn ngày:</label>
                        <input type="date" name="ngay_dat_hang" id="ngay_dat_hang" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Hiển thị doanh thu</button>
                </form>
            </div>


            <div id="form2" class="mt-3">
                <form method="get" action="" class="mx-auto" style="max-width: 400px;">
                    <div class="mb-3">
                        <label for="month" class="form-label">Tháng:</label>
                        <select name="month" id="month" class="form-select" required>
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
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Năm:</label>
                        <select name="year" id="year" class="form-select" required>
                            <?php
                            foreach(range(2020, (int)date("Y")) as $year) {
                                echo "<option value='".$year."'>".$year."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Hiển thị doanh thu</button>
                </form>
            </div>


            <div id="form3" class="mt-3">
                <form method="get" action="" class="mx-auto" style="max-width: 400px;">
                    <div class="mb-3">
                        <label for="yearonly" class="form-label">Năm:</label>
                        <select name="yearonly" id="yearonly" class="form-select" required>
                            <?php
                            foreach(range(2020, (int)date("Y")) as $year) {
                                echo "<option value='".$year."'>".$year."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Hiển thị doanh thu</button>
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
                    echo '<div class="table-responsive mt-4">';
                    echo "<table class='table table-bordered text-center'>
                                <thead>
                                    <tr>
                                        <th>{$header}</th>
                                        <th>Số đơn</th>
                                        <th>Số sách đã bán</th>
                                        <th>Doanh thu</th>
                                        <th>Lợi nhuận</th>
                                    </tr>
                                </thead>
                                <tbody>";
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
                        echo "</tbody></table><br>";
                        echo '<table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>'.$header2.'</th>
                                            <th>Số đơn</th>
                                            <th>Số sách đã bán</th>
                                            <th>Doanh thu</th>
                                            <th>Lợi nhuận</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
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
                    echo "</tbody></table></div>";
                    echo "<h3 class='mt-5'>{$header3}</h3>";
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Ảnh bìa</th>
                                        <th>Tên sách</th>
                                        <th>Số sách đã bán</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    while ($row = $result3->fetch_assoc()) {
                        echo "<tr>
                                    <td style='width: 120px'><img src='../ql_sach/sach/{$row['anh_bia']}' alt='Ảnh bìa' class='img-fluid'></td>
                                    <td>{$row['ten_sach']}</td>
                                    <td>{$row['so_luong_ban']}</td>
                                  </tr>";
                    }
                    echo "</tbody></table></div>";

                } else {
                    echo "<br><br><strong>Không có kết quả</strong><br><br>";
                }
            }
            ?>
        </main>
    </div>
</div>
</body>
</html>
