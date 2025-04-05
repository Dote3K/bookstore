<?php
require '../../connect.php';
require '../../checker/kiemtra_admin.php';

$id = $_GET['id'];
$sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $ho_va_ten = $_POST['ho_va_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    $dia_chi_nhan_hang = $_POST['dia_chi_nhan_hang'];
    $dang_ky_nhan_ban_tin = $_POST['dang_ky_nhan_ban_tin'];
    $vai_tro = $_POST['vai_tro'];

    // Kiểm tra trùng tên đăng nhập (ngoại trừ tài khoản hiện tại)
    $check_username = "SELECT * FROM khachhang WHERE ten_dang_nhap = ? AND ma_khach_hang != ?";
    $stmt_check = $conn->prepare($check_username);
    $stmt_check->bind_param("si", $ten_dang_nhap, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.');</script>";
    } else {
        // Cập nhật thông tin khách hàng
        $sql_update = "UPDATE khachhang SET ten_dang_nhap = ?, ho_va_ten = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, dia_chi_nhan_hang = ?, dang_ky_nhan_ban_tin = ?, vai_tro = ? WHERE ma_khach_hang = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssssssi", $ten_dang_nhap, $ho_va_ten, $email, $so_dien_thoai, $dia_chi, $dia_chi_nhan_hang, $dang_ky_nhan_ban_tin, $vai_tro, $id);
        if ($stmt_update->execute()) {
            echo "<script>alert('Cập nhật khách hàng thành công.'); window.location='quanlikhachhang.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa khách hàng</title>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Chỉnh sửa khách hàng</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form method="POST" class="p-6 space-y-6">
                        <div>
                            <label for="ten_dang_nhap" class="block text-sm font-medium text-gray-700">Tên đăng nhập:</label>
                            <input type="text" name="ten_dang_nhap" id="ten_dang_nhap" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['ten_dang_nhap']); ?>" required>
                        </div>

                        <div>
                            <label for="ho_va_ten" class="block text-sm font-medium text-gray-700">Họ và tên:</label>
                            <input type="text" name="ho_va_ten" id="ho_va_ten" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['ho_va_ten']); ?>" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                            <input type="email" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                        </div>

                        <div>
                            <label for="so_dien_thoai" class="block text-sm font-medium text-gray-700">Số điện thoại:</label>
                            <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['so_dien_thoai']); ?>" required>
                        </div>

                        <div>
                            <label for="dia_chi" class="block text-sm font-medium text-gray-700">Địa chỉ:</label>
                            <input type="text" name="dia_chi" id="dia_chi" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['dia_chi']); ?>">
                        </div>

                        <div>
                            <label for="dia_chi_nhan_hang" class="block text-sm font-medium text-gray-700">Địa chỉ nhận hàng:</label>
                            <input type="text" name="dia_chi_nhan_hang" id="dia_chi_nhan_hang" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" value="<?php echo htmlspecialchars($row['dia_chi_nhan_hang']); ?>">
                        </div>

                        <div>
                            <label for="dang_ky_nhan_ban_tin" class="block text-sm font-medium text-gray-700">Đăng ký nhận bản tin:</label>
                            <select name="dang_ky_nhan_ban_tin" id="dang_ky_nhan_ban_tin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="1" <?php if ($row['dang_ky_nhan_ban_tin'] == 1) echo 'selected'; ?>>Có</option>
                                <option value="0" <?php if ($row['dang_ky_nhan_ban_tin'] == 0) echo 'selected'; ?>>Không</option>
                            </select>
                        </div>

                        <div>
                            <label for="vai_tro" class="block text-sm font-medium text-gray-700">Vai trò:</label>
                            <select name="vai_tro" id="vai_tro" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="khachhang" <?php if ($row['vai_tro'] == 'khachhang') echo 'selected'; ?>>Khách hàng</option>
                                <option value="admin" <?php if ($row['vai_tro'] == 'admin') echo 'selected'; ?>>Admin</option>
                            </select>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cập Nhật
                            </button>
                            <a href="quanlikhachhang.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Trở về trang quản lý khách hàng
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
