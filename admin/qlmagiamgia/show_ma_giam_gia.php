<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Mã Giảm Giá</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline/index.min.js"></script>
    <!-- Alpine.js for component interactions -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Fix for horizontal scrolling */
        .table-container {
            overflow-x: auto;
            max-width: 100%;
            margin-bottom: 1rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .ml-64 {
                margin-left: 0;
            }
            .px-3 {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include '../sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 ml-64">
            <!-- Topbar -->
            <header class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Quản Lý Mã Giảm Giá</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="mb-5">
                    <a href="add_ma_giam_gia.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Thêm Mã Giảm Giá
                    </a>
                </div>

                <!-- Table -->
                <div class="flex flex-col mt-6">
                    <div class="-my-2 sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div class="table-container">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-blue-500">
                                            <tr>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mã</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mã Giảm Giá</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Loại Giảm Giá</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Giá Trị Giảm</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">SL Tối Đa</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">SL Đã Dùng</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Ngày Bắt Đầu</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Ngày Kết Thúc</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Trạng Thái</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tổng ĐH Tối Thiểu</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Chức Năng</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <?php
                                        $sql = "SELECT * FROM ma_giam_gia";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($ma_giam_gia = $result->fetch_assoc()) {
                                                $trang_thai_class = $ma_giam_gia['trang_thai'] == 'kich_hoat' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold';
                                                $trang_thai_text = $ma_giam_gia['trang_thai'] == 'kich_hoat' ? 'Kích hoạt' : 'Không kích hoạt';
                                                
                                                $loai_giam_gia_text = $ma_giam_gia['loai_giam_gia'] == 'phan_tram' ? 'Phần trăm' : 'Giá cố định';
                                                
                                                // Format dates or show "Không giới hạn" if null
                                                $ngay_bat_dau = !empty($ma_giam_gia['ngay_bat_dau']) ? date("d/m/Y", strtotime($ma_giam_gia['ngay_bat_dau'])) : "Không giới hạn";
                                                $ngay_ket_thuc = !empty($ma_giam_gia['ngay_ket_thuc']) ? date("d/m/Y", strtotime($ma_giam_gia['ngay_ket_thuc'])) : "Không giới hạn";
                                                
                                                // Format giá trị giảm
                                                $gia_tri_giam = $ma_giam_gia['loai_giam_gia'] == 'phan_tram' 
                                                    ? $ma_giam_gia['gia_tri_giam'] . '%' 
                                                    : number_format($ma_giam_gia['gia_tri_giam'], 0, ',', '.') . 'đ';
                                                
                                                // Format tổng đơn hàng tối thiểu
                                                $tong_don_hang_toi_thieu = !empty($ma_giam_gia['tong_don_hang_toi_thieu']) 
                                                    ? number_format($ma_giam_gia['tong_don_hang_toi_thieu'], 0, ',', '.') . 'đ' 
                                                    : "Không giới hạn";
                                                
                                                echo "<tr class='hover:bg-gray-50'>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900'>{$ma_giam_gia['ma']}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$ma_giam_gia['ma_giam']}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$loai_giam_gia_text}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$gia_tri_giam}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$ma_giam_gia['so_lan_su_dung_toi_da']}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$ma_giam_gia['so_lan_da_su_dung']}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$ngay_bat_dau}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$ngay_ket_thuc}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm {$trang_thai_class}'>{$trang_thai_text}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>{$tong_don_hang_toi_thieu}</td>
                                                        <td class='px-3 py-2 whitespace-nowrap text-sm font-medium'>
                                                            <div class='flex flex-col gap-1'>
                                                                <a href='edit_ma_giam_gia.php?ma={$ma_giam_gia['ma']}' class='text-indigo-600 hover:text-indigo-900'>
                                                                    <span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md inline-block mb-1'>Sửa</span>
                                                                </a>
                                                                <a href='xoa_ma_giam_gia.php?ma={$ma_giam_gia['ma']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa mã giảm giá này?\")' class='text-red-600 hover:text-red-900'>
                                                                    <span class='px-2 py-1 bg-red-100 text-red-800 rounded-md inline-block'>Xóa</span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='11' class='px-6 py-4 text-center text-sm text-gray-500'>Không có mã giảm giá nào trong cơ sở dữ liệu</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
