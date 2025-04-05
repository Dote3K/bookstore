<?php
require '../../checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline/index.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .form-container {
            transition: all 0.5s ease;
            opacity: 0;
            height: 0;
            overflow: hidden;
        }
        .form-container.active {
            opacity: 1;
            height: auto;
            margin-bottom: 2rem;
        }
        .tab-button {
            position: relative;
        }
        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #4F46E5;
            border-radius: 3px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 2rem;
            }
            .page-break {
                page-break-after: always;
            }
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
        }
        
        th, td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem 1rem;
        }
        
        th {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        tbody tr:nth-child(odd) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .revenue-table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
    <script>
        function showForm(formId) {
            // Hide all forms
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });
            // Show selected form
            document.getElementById(formId).classList.add('active');
            
            // Update button styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`[data-form="${formId}"]`).classList.add('active');
        }
        
        function printReport() {
            window.print();
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include '../sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 ml-64">
            <!-- Topbar -->
            <header class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">Thống kê doanh thu</h1>
                    <div class="flex space-x-2 no-print">
                        <button onclick="printReport()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            In báo cáo
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <!-- Tab navigation -->
                <div class="flex justify-center space-x-4 mb-8 border-b border-gray-200 pb-4 no-print">
                    <button type="button" class="tab-button active px-4 py-2 text-sm font-medium text-indigo-700 focus:outline-none" data-form="form1" onclick="showForm('form1')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Doanh thu theo ngày
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-gray-500 hover:text-indigo-700 focus:outline-none" data-form="form2" onclick="showForm('form2')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Doanh thu theo tháng
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium text-gray-500 hover:text-indigo-700 focus:outline-none" data-form="form3" onclick="showForm('form3')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Doanh thu theo năm
                    </button>
                </div>

                <!-- Form 1: Doanh thu theo ngày -->
                <div id="form1" class="form-container active no-print">
                    <form method="get" action="" class="mx-auto max-w-md bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="ngay_dat_hang" class="block text-sm font-medium text-gray-700 mb-2">Chọn ngày cần xem:</label>
                            <input type="date" name="ngay_dat_hang" id="ngay_dat_hang" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Hiển thị báo cáo
                        </button>
                    </form>
                </div>

                <!-- Form 2: Doanh thu theo tháng -->
                <div id="form2" class="form-container no-print">
                    <form method="get" action="" class="mx-auto max-w-md bg-white p-6 rounded-lg shadow-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Tháng:</label>
                                <select name="month" id="month" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <?php
                                    $current_month = date('n');
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
                                        $selected = ($value == $current_month) ? 'selected' : '';
                                        echo "<option value=\"$value\" $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Năm:</label>
                                <select name="year" id="year" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <?php
                                    $current_year = date('Y');
                                    foreach(range(2020, (int)date("Y")) as $year) {
                                        $selected = ($year == $current_year) ? 'selected' : '';
                                        echo "<option value='$year' $selected>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Hiển thị báo cáo
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form 3: Doanh thu theo năm -->
                <div id="form3" class="form-container no-print">
                    <form method="get" action="" class="mx-auto max-w-md bg-white p-6 rounded-lg shadow-md">
                        <div class="mb-4">
                            <label for="yearonly" class="block text-sm font-medium text-gray-700 mb-2">Chọn năm cần xem:</label>
                            <select name="yearonly" id="yearonly" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <?php
                                $current_year = date('Y');
                                foreach(range(2020, (int)date("Y")) as $year) {
                                    $selected = ($year == $current_year) ? 'selected' : '';
                                    echo "<option value='$year' $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Hiển thị báo cáo
                        </button>
                    </form>
                </div>

                <?php
                include '../../connect.php';

                if(isset($_GET['ngay_dat_hang']) || isset($_GET['month']) || isset($_GET['yearonly'])) {
                    include '../../controllers/doanhthuController.php';
                    $controller = new doanhthufunction($conn);
                    $reportTitle = "";
                    $chartData = [];
                    $chartLabels = [];
                    $totalRevenue = 0;
                    $totalProfit = 0;
                    $totalOrders = 0;
                    $totalBooks = 0;
                    
                    // Report header based on type
                    if (isset($_GET['ngay_dat_hang'])) {
                        $date = date('d/m/Y', strtotime($_GET['ngay_dat_hang']));
                        $reportTitle = "Báo cáo doanh thu ngày $date";
                        $result = $controller->doanhThuNgay($_GET['ngay_dat_hang']);
                        $result3 = $controller->bestSellerNgay($_GET['ngay_dat_hang']);
                        $header = 'Ngày';
                        $header3 = 'Sách bán chạy trong ngày';
                        
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $totalRevenue = $row['doanh_thu'];
                            $totalProfit = $row['loi_nhuan'];
                            $totalOrders = $row['so_don'];
                            $totalBooks = $row['so_luong'];
                        }
                    } elseif (isset($_GET['month']) && isset($_GET['year'])) {
                        $month_name = date('F', mktime(0, 0, 0, $_GET['month'], 10));
                        $reportTitle = "Báo cáo doanh thu tháng {$_GET['month']} năm {$_GET['year']}";
                        $result = $controller->chiTietDoanhThuThang($_GET['month'], $_GET['year']);
                        $result2 = $controller->doanhThuThang($_GET['month'], $_GET['year']);
                        $result3 = $controller->bestSellerThang($_GET['month'], $_GET['year']);
                        $header2 = 'Theo ngày trong tháng';
                        $header = 'Tháng';
                        $header3 = 'Sách bán chạy trong tháng';
                        
                        // Calculate totals
                        if ($result2 && $result2->num_rows > 0) {
                            $row = $result2->fetch_assoc();
                            $totalRevenue = $row['doanh_thu'];
                            $totalProfit = $row['loi_nhuan'];
                            $totalOrders = $row['so_don'];
                            $totalBooks = $row['so_luong'];
                        }
                        
                        // Prepare chart data
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $chartLabels[] = date("d/m", strtotime($row['ngay_dat_hang']));
                                $chartData[] = $row['doanh_thu'];
                            }
                            // Reset result pointer
                            $result->data_seek(0);
                        }
                    } elseif (isset($_GET['yearonly'])) {
                        $reportTitle = "Báo cáo doanh thu năm {$_GET['yearonly']}";
                        $result = $controller->chiTietDoanhThuNam($_GET['yearonly']);
                        $result2 = $controller->doanhThuNam($_GET['yearonly']);
                        $result3 = $controller->bestSellerNam($_GET['yearonly']);
                        $header2 = 'Theo tháng trong năm';
                        $header = 'Năm';
                        $header3 = 'Sách bán chạy trong năm';
                        
                        // Calculate totals
                        if ($result2 && $result2->num_rows > 0) {
                            $row = $result2->fetch_assoc();
                            $totalRevenue = $row['doanh_thu'];
                            $totalProfit = $row['loi_nhuan'];
                            $totalOrders = $row['so_don'];
                            $totalBooks = $row['so_luong'];
                        }
                        
                        // Prepare chart data
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $chartLabels[] = "Tháng " . date("m/Y", strtotime($row['ngay_dat_hang']));
                                $chartData[] = $row['doanh_thu'];
                            }
                            // Reset result pointer
                            $result->data_seek(0);
                        }
                    }
                    
                    ?>
                    <div class="print-header text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900"><?php echo $reportTitle; ?></h2>
                        <p class="text-sm text-gray-500">Báo cáo được tạo vào: <?php echo date('d/m/Y H:i:s'); ?></p>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <div class="bg-white overflow-hidden shadow rounded-lg stats-card">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Tổng doanh thu</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> ₫</div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white overflow-hidden shadow rounded-lg stats-card">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Lợi nhuận</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900"><?php echo number_format($totalProfit, 0, ',', '.'); ?> ₫</div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white overflow-hidden shadow rounded-lg stats-card">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Tổng đơn hàng</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900"><?php echo number_format($totalOrders, 0, ',', '.'); ?></div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white overflow-hidden shadow rounded-lg stats-card">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-pink-100 rounded-md p-3">
                                        <svg class="h-8 w-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Số lượng sách đã bán</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900"><?php echo number_format($totalBooks, 0, ',', '.'); ?></div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (count($chartLabels) > 0 && count($chartData) > 0): ?>
                    <!-- Chart Section -->
                    <div class="bg-white p-6 shadow rounded-lg mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Biểu đồ doanh thu</h3>
                        <div style="height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('revenueChart').getContext('2d');
                            const revenueChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($chartLabels); ?>,
                                    datasets: [{
                                        label: 'Doanh thu (₫)',
                                        data: <?php echo json_encode($chartData); ?>,
                                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                        borderColor: 'rgba(79, 70, 229, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function(value) {
                                                    return new Intl.NumberFormat('vi-VN', { 
                                                        style: 'currency', 
                                                        currency: 'VND',
                                                        maximumFractionDigits: 0
                                                    }).format(value);
                                                }
                                            }
                                        }
                                    },
                                    plugins: {
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return new Intl.NumberFormat('vi-VN', { 
                                                        style: 'currency', 
                                                        currency: 'VND',
                                                        maximumFractionDigits: 0
                                                    }).format(context.raw);
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <?php endif; ?>

                    <?php
                    if ($result && $result->num_rows > 0) {
                        // Revenue table
                        echo '<div class="mb-8">';
                        echo '<h3 class="text-lg font-medium text-gray-900 mb-4">Chi tiết doanh thu</h3>';
                        echo '<div class="revenue-table-container">';
                        echo "<table class='min-w-full border-separate'>
                                    <thead>
                                        <tr>
                                            <th class='text-left'>{$header}</th>
                                            <th class='text-center'>Số đơn</th>
                                            <th class='text-center'>Sách đã bán</th>
                                            <th class='text-right'>Doanh thu</th>
                                            <th class='text-right'>Lợi nhuận</th>
                                            <th class='text-right'>Tỷ suất lợi nhuận</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        
                        if (isset($_GET['month']) || isset($_GET['yearonly'])) {
                            if ($result2) {
                                while ($row = $result2->fetch_assoc()) {
                                    $profitMargin = ($row['doanh_thu'] > 0) ? ($row['loi_nhuan'] / $row['doanh_thu'] * 100) : 0;
                                    echo "<tr>
                                            <td class='text-left font-medium'>{$row['ngay_dat_hang']}</td>
                                            <td class='text-center'>{$row['so_don']}</td>
                                            <td class='text-center'>{$row['so_luong']}</td>
                                            <td class='text-right'>" . number_format($row['doanh_thu'], 0, ',', '.') . "₫</td>
                                            <td class='text-right'>" . number_format($row['loi_nhuan'], 0, ',', '.') . "₫</td>
                                            <td class='text-right'>" . number_format($profitMargin, 1) . "%</td>
                                        </tr>";
                                }
                            }
                            
                            echo "</tbody>
                                <tfoot class='bg-gray-100 font-medium'>
                                    <tr>
                                        <td class='text-left'>Tổng cộng</td>
                                        <td class='text-center'>" . number_format($totalOrders, 0, ',', '.') . "</td>
                                        <td class='text-center'>" . number_format($totalBooks, 0, ',', '.') . "</td>
                                        <td class='text-right'>" . number_format($totalRevenue, 0, ',', '.') . "₫</td>
                                        <td class='text-right'>" . number_format($totalProfit, 0, ',', '.') . "₫</td>
                                        <td class='text-right'>" . number_format(($totalRevenue > 0 ? ($totalProfit / $totalRevenue * 100) : 0), 1) . "%</td>
                                    </tr>
                                </tfoot>
                            </table></div>";
                            
                            echo '<h3 class="text-lg font-medium text-gray-900 my-4 page-break">' . $header2 . '</h3>';
                            echo '<div class="revenue-table-container">';
                            echo '<table class="min-w-full border-separate">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Ngày</th>
                                                <th class="text-center">Số đơn</th>
                                                <th class="text-center">Sách đã bán</th>
                                                <th class="text-right">Doanh thu</th>
                                                <th class="text-right">Lợi nhuận</th>
                                                <th class="text-right">Tỷ suất lợi nhuận</th>
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
                            $profitMargin = ($row['doanh_thu'] > 0) ? ($row['loi_nhuan'] / $row['doanh_thu'] * 100) : 0;
                            echo "<tr>
                                    <td class='text-left'>{$date_format}</td>
                                    <td class='text-center'>{$row['so_don']}</td>
                                    <td class='text-center'>{$row['so_luong']}</td>
                                    <td class='text-right'>" . number_format($row['doanh_thu'], 0, ',', '.') . "₫</td>
                                    <td class='text-right'>" . number_format($row['loi_nhuan'], 0, ',', '.') . "₫</td>
                                    <td class='text-right'>" . number_format($profitMargin, 1) . "%</td>
                                </tr>";
                        }
                        echo "</tbody></table></div></div>";
                        
                        // Best seller section
                        if ($result3 && $result3->num_rows > 0) {
                            echo "<div class='mb-8 page-break'>";
                            echo "<h3 class='text-lg font-medium text-gray-900 mb-4'>{$header3}</h3>";
                            echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                            
                            $count = 0;
                            while ($row = $result3->fetch_assoc()) {
                                $count++;
                                $badge = '';
                                if ($count == 1) {
                                    $badge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                #1
                                            </span>';
                                } else if ($count == 2) {
                                    $badge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                                #2
                                            </span>';
                                } else if ($count == 3) {
                                    $badge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 mr-2">
                                                #3
                                            </span>';
                                }
                                
                                echo '<div class="bg-white rounded-lg shadow overflow-hidden flex">';
                                echo '<div class="w-1/3 p-4">';
                                echo '<img src="../ql_sach/sach/' . htmlspecialchars($row['anh_bia']) . '" alt="Ảnh bìa" class="h-40 object-contain mx-auto">';
                                echo '</div>';
                                echo '<div class="w-2/3 p-4">';
                                echo '<h4 class="font-medium text-gray-900">' . $badge . htmlspecialchars($row['ten_sach']) . '</h4>';
                                echo '<div class="mt-2 flex items-center">';
                                echo '<div class="flex-shrink-0 bg-indigo-100 rounded-full p-1">';
                                echo '<svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">';
                                echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                                echo '</svg>';
                                echo '</div>';
                                echo '<div class="ml-2">';
                                echo '<p class="text-sm text-gray-600">Đã bán: <span class="font-medium text-gray-900">' . number_format($row['so_luong_ban'], 0, ',', '.') . ' quyển</span></p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            
                            echo '</div></div>';
                        }

                    } else {
                        echo "<div class='mt-8 bg-yellow-50 border-l-4 border-yellow-400 p-4'>
                                <div class='flex'>
                                    <div class='flex-shrink-0'>
                                        <svg class='h-5 w-5 text-yellow-400' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor'>
                                            <path fill-rule='evenodd' d='M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z' clip-rule='evenodd'/>
                                        </svg>
                                    </div>
                                    <div class='ml-3'>
                                        <p class='text-sm text-yellow-700'>Không có dữ liệu doanh thu cho khoảng thời gian đã chọn.</p>
                                    </div>
                                </div>
                            </div>";
                    }
                }
                ?>
            </main>
        </div>
    </div>
</body>
</html>
