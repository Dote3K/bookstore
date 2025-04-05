<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sách</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline/index.min.js"></script>
    <style>
        /* Fix for horizontal scrolling */
        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }
        
        .w-auto-important {
            width: auto !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .ml-64 {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include '../../sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 ml-64">
            <!-- Topbar -->
            <header class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Thông tin Sách</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="mb-5">
                    <a href="add_book.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Thêm Sách
                    </a>
                </div>

                <!-- Table -->
                <div class="flex flex-col mt-6">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div class="table-container">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-blue-500">
                                            <tr>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mã</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tên Sách</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tác giả</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">NXB</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Thể loại</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Giá mua</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Giá bán</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">SL</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Năm XB</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mô tả</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Ảnh bìa</th>
                                                <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        <?php
                                        $sql = "SELECT * FROM sach";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($count = $result->fetch_assoc()) {
                                                $ma_tac_gia = $count['ma_tac_gia'];
                                                $sql1 = "SELECT ten FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
                                                $ten_tac_gia = $conn->query($sql1)->fetch_assoc()['ten'] ?? 'N/A';

                                                $ma_nxb = $count['ma_nxb'];
                                                $sql2 = "SELECT ten FROM nxb WHERE ma_nxb = $ma_nxb";
                                                $ten_nxb = $conn->query($sql2)->fetch_assoc()['ten'] ?? 'N/A';

                                                $ma_the_loai = $count['ma_the_loai'];
                                                $sql3 = "SELECT the_loai FROM theloai WHERE ma_the_loai = $ma_the_loai";
                                                $the_loai = $conn->query($sql3)->fetch_assoc()['the_loai'] ?? 'N/A';

                                                $gia_mua_formatted = number_format($count['gia_mua'], 0, ',', '.') . "₫";
                                                $gia_ban_formatted = number_format($count['gia_ban'], 0, ',', '.') . "₫";
                                                $mo_ta_short = strlen($count['mo_ta']) > 30 ? substr($count['mo_ta'], 0, 30) . "..." : $count['mo_ta'];

                                                echo "<tr class='hover:bg-gray-50'>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>{$count['ma_sach']}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$count['ten_sach']}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$ten_tac_gia}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$ten_nxb}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$the_loai}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$gia_mua_formatted}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$gia_ban_formatted}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$count['so_luong']}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>{$count['nam_xuat_ban']}</td>
                                                        <td class='px-3 py-4 text-sm text-gray-500'>{$mo_ta_short}</td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm text-gray-500'>
                                                            <img src='{$count['anh_bia']}' alt='Ảnh bìa' class='h-10 w-auto object-cover'>
                                                        </td>
                                                        <td class='px-3 py-4 whitespace-nowrap text-sm font-medium flex flex-col gap-1'>
                                                            <a href='edit_sach.php?ma_sach={$count['ma_sach']}' class='text-indigo-600 hover:text-indigo-900 block mb-1'>
                                                                <span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md'>Chỉnh Sửa</span>
                                                            </a>
                                                            <a href='xoa_sach.php?ma_sach={$count['ma_sach']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sách này?\")' class='text-red-600 hover:text-red-900 block'>
                                                                <span class='px-2 py-1 bg-red-100 text-red-800 rounded-md'>Xóa</span>
                                                            </a>
                                                        </td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='12' class='px-6 py-4 text-center text-sm text-gray-500'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
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
