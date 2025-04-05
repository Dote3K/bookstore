<?php
require '../../connect.php';
require '../../checker/kiemtra_admin.php';

// Xử lý tìm kiếm và lọc theo vai trò
$search_query = '';
$role_filter = '';
if (isset($_GET['search']) || isset($_GET['role'])) {
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';
    $role_filter = isset($_GET['role']) ? $_GET['role'] : '';

    $sql = "SELECT * FROM khachhang WHERE (ten_dang_nhap LIKE ? OR ho_va_ten LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?)";

    if (!empty($role_filter)) {
        $sql .= " AND vai_tro = ?";
    }

    $stmt = $conn->prepare($sql);
    $search_keyword = "%$search_query%";

    if (!empty($role_filter)) {
        $stmt->bind_param("sssss", $search_keyword, $search_keyword, $search_keyword, $search_keyword, $role_filter);
    } else {
        $stmt->bind_param("ssss", $search_keyword, $search_keyword, $search_keyword, $search_keyword);
    }

    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM khachhang";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.5/outline/index.min.js"></script>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Quản lý khách hàng</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <!-- Search and filter form -->
                <div class="bg-white p-4 rounded-md shadow-sm mb-6">
                    <form method="GET" action="quanlikhachhang.php" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                            <input type="text" name="search" id="search" placeholder="Tìm kiếm khách hàng..." value="<?php echo htmlspecialchars($search_query); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                        </div>
                        
                        <div class="w-48">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                            <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                <option value="">Tất cả vai trò</option>
                                <option value="admin" <?php if ($role_filter == 'admin') echo 'selected'; ?>>Admin</option>
                                <option value="khachhang" <?php if ($role_filter == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Tìm kiếm & Lọc
                            </button>
                            
                            <a href="quanlikhachhang.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Hiển thị tất cả
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Customer table -->
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-blue-500">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tên đăng nhập</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Họ và tên</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Số điện thoại</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Địa chỉ</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nhận bản tin</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Vai trò</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr class='hover:bg-gray-50'>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'>{$row['ma_khach_hang']}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['ten_dang_nhap']}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['ho_va_ten']}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['email']}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>{$row['so_dien_thoai']}</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . (strlen($row['dia_chi']) > 20 ? substr($row['dia_chi'], 0, 20) . '...' : $row['dia_chi']) . "</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . ($row['dang_ky_nhan_ban_tin'] ? 
                                                    '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Có</span>' : 
                                                    '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Không</span>') . "</td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm text-gray-500'>" . 
                                                    ($row['vai_tro'] == 'admin' ? 
                                                        '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Admin</span>' : 
                                                        '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Khách hàng</span>') . "
                                                </td>
                                                <td class='px-6 py-4 whitespace-nowrap text-sm font-medium'>
                                                    <a href='chinhsua_khachhang.php?id={$row['ma_khach_hang']}' class='text-indigo-600 hover:text-indigo-900 mr-3'>
                                                        <span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-md'>Chỉnh sửa</span>
                                                    </a>
                                                    <a href='xoakhachhang.php?id={$row['ma_khach_hang']}' class='text-red-600 hover:text-red-900' onclick='return confirmDelete()'>
                                                        <span class='px-2 py-1 bg-red-100 text-red-800 rounded-md'>Xóa</span>
                                                    </a>
                                                </td>
                                              </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='px-6 py-4 text-center text-sm text-gray-500'>Không có khách hàng nào được tìm thấy</td></tr>";
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

    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc muốn xóa khách hàng này?");
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
