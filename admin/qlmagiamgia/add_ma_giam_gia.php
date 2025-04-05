<?php
require "../../connect.php";
require '../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_giam = $_POST['ma_giam'];
    $loai_giam_gia = $_POST['loai_giam_gia'];
    $gia_tri_giam = $_POST['gia_tri_giam'];
    $so_lan_su_dung_toi_da = !empty($_POST['so_lan_su_dung_toi_da']) ? $_POST['so_lan_su_dung_toi_da'] : null;
    $tong_don_hang_toi_thieu = !empty($_POST['tong_don_hang_toi_thieu']) ? $_POST['tong_don_hang_toi_thieu'] : null;
    $trang_thai = $_POST['trang_thai'];

    // Chuyển đổi định dạng ngày giờ
    $ngay_bat_dau = !empty($_POST['ngay_bat_dau']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_bat_dau'])) : null;
    $ngay_ket_thuc = !empty($_POST['ngay_ket_thuc']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_ket_thuc'])) : null;

    $sql = "INSERT INTO ma_giam_gia (ma_giam, loai_giam_gia, gia_tri_giam, so_lan_su_dung_toi_da, ngay_bat_dau, ngay_ket_thuc, trang_thai, tong_don_hang_toi_thieu)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiissd", $ma_giam, $loai_giam_gia, $gia_tri_giam, $so_lan_su_dung_toi_da, $ngay_bat_dau, $ngay_ket_thuc, $trang_thai, $tong_don_hang_toi_thieu);

    if ($stmt->execute()) {
        $success_message = "Thêm mã giảm giá thành công";
    } else {
        $error_message = "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Mã Giảm Giá</title>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Thêm Mã Giảm Giá</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <?php if(isset($success_message)): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <?= $success_message ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($error_message)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <?= $error_message ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form method="post" class="p-6 space-y-6">
                        <div>
                            <label for="ma_giam" class="block text-sm font-medium text-gray-700">Mã Giảm Giá</label>
                            <input type="text" name="ma_giam" id="ma_giam" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="loai_giam_gia" class="block text-sm font-medium text-gray-700">Loại Giảm Giá</label>
                            <select name="loai_giam_gia" id="loai_giam_gia" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="phan_tram">Phần trăm</option>
                                <option value="gia_co_dinh">Giá cố định</option>
                            </select>
                        </div>

                        <div>
                            <label for="gia_tri_giam" class="block text-sm font-medium text-gray-700">Giá Trị Giảm</label>
                            <input type="number" step="0.01" name="gia_tri_giam" id="gia_tri_giam" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="so_lan_su_dung_toi_da" class="block text-sm font-medium text-gray-700">Số Lần Sử Dụng Tối Đa</label>
                            <input type="number" name="so_lan_su_dung_toi_da" id="so_lan_su_dung_toi_da" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>

                        <div>
                            <label for="tong_don_hang_toi_thieu" class="block text-sm font-medium text-gray-700">Tổng Đơn Hàng Tối Thiểu</label>
                            <input type="number" step="0.01" name="tong_don_hang_toi_thieu" id="tong_don_hang_toi_thieu" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>

                        <div>
                            <label for="ngay_bat_dau" class="block text-sm font-medium text-gray-700">Ngày Bắt Đầu</label>
                            <input type="datetime-local" name="ngay_bat_dau" id="ngay_bat_dau" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>

                        <div>
                            <label for="ngay_ket_thuc" class="block text-sm font-medium text-gray-700">Ngày Kết Thúc</label>
                            <input type="datetime-local" name="ngay_ket_thuc" id="ngay_ket_thuc" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border">
                        </div>

                        <div>
                            <label for="trang_thai" class="block text-sm font-medium text-gray-700">Trạng Thái</label>
                            <select name="trang_thai" id="trang_thai" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="kich_hoat">Kích hoạt</option>
                                <option value="khong_kich_hoat">Không kích hoạt</option>
                            </select>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Thêm Mã Giảm Giá
                            </button>
                            <a href="show_ma_giam_gia.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Trở về trang quản lý mã giảm giá
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
