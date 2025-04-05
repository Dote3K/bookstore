<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Thể Loại</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline/index.min.js"></script>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Thông tin Thể Loại</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="mb-5">
                    <a href="add_tl.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Thêm Thể Loại
                    </a>
                </div>

                <!-- Table -->
                <div class="flex flex-col mt-6">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-blue-500">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mã Thể Loại</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tên Thể Loại</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Chức Năng</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    $sql = "SELECT * FROM theloai";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($count = $result->fetch_assoc()) {
                                            echo "<tr class='hover:bg-gray-50'>
                                                    <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>{$count['ma_the_loai']}</td>
                                                    <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$count['the_loai']}</td>
                                                    <td class='px-6 py-4 whitespace-nowrap text-sm font-medium'>
                                                        <a href='edit_tl.php?ma_the_loai={$count['ma_the_loai']}' class='text-indigo-600 hover:text-indigo-900 mr-3'>
                                                            <span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md'>Chỉnh Sửa</span>
                                                        </a>
                                                        <a href='xoa_tl.php?ma_the_loai={$count['ma_the_loai']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa thể loại này?\")' class='text-red-600 hover:text-red-900'>
                                                            <span class='px-2 py-1 bg-red-100 text-red-800 rounded-md'>Xóa</span>
                                                        </a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='px-6 py-4 text-center text-sm text-gray-500'>Không có thể loại nào trong cơ sở dữ liệu</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
