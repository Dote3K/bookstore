<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

$ma_tac_gia = $_GET['ma_tac_gia'];
$sql = "SELECT * FROM tacgia WHERE ma_tac_gia = $ma_tac_gia";
$result = $conn->query($sql);
$tacgia = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ten = $_POST['ten'];
    $tieu_su = $_POST['tieu_su'];
    $sql = "UPDATE tacgia SET ten = '$ten', tieu_su = '$tieu_su' WHERE ma_tac_gia = '$ma_tac_gia'";
    if ($conn->query($sql) === TRUE) {
        header("Location: show_tacgia.php");
        exit();
    } else {
        echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin tác giả</title>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Chỉnh sửa thông tin tác giả</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form method="post" class="p-6 space-y-6">
                        <input type="hidden" name="ma_tac_gia" value="<?= htmlspecialchars($tacgia['ma_tac_gia']); ?>">
                        
                        <div>
                            <label for="ma_tac_gia" class="block text-sm font-medium text-gray-700">Mã Tác Giả</label>
                            <input type="text" id="ma_tac_gia" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border bg-gray-100" value="<?= htmlspecialchars($tacgia['ma_tac_gia']); ?>" readonly>
                        </div>

                        <div>
                            <label for="ten" class="block text-sm font-medium text-gray-700">Tên Tác Giả</label>
                            <input type="text" name="ten" id="ten" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?= htmlspecialchars($tacgia['ten']); ?>" required>
                        </div>

                        <div>
                            <label for="tieu_su" class="block text-sm font-medium text-gray-700">Tiểu Sử</label>
                            <textarea name="tieu_su" id="tieu_su" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" rows="4" required><?= htmlspecialchars($tacgia['tieu_su']); ?></textarea>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cập Nhật
                            </button>
                            <a href="show_tacgia.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Trở về trang quản lý tác giả
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
