<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_sach = $_POST['ten_sach'];
    $ma_tac_gia = $_POST['ma_tac_gia'];
    $ma_nxb = $_POST['ma_nxb'];
    $ma_the_loai = $_POST['ma_the_loai'];
    $gia_mua = $_POST['gia_mua'];
    $gia_ban = $_POST['gia_ban'];
    $so_luong = $_POST['so_luong'];
    $nam_xuat_ban = $_POST['nam_xuat_ban'];
    $mo_ta = $_POST['mo_ta'];

    $anh_bia = '';
    if (isset($_FILES['anh_bia']) && $_FILES['anh_bia']['error'] == 0) {
        $target_dir = "anhbia/";
        $target_file = $target_dir . basename($_FILES["anh_bia"]["name"]);

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "jpeg", "png");

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["anh_bia"]["tmp_name"], $target_file)) {
                $anh_bia = $target_file;
            } else {
                echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4' role='alert'>Lỗi khi tải lên tập tin.</div>";
            }
        } else {
            echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4' role='alert'>Chỉ cho phép các định dạng JPG, JPEG, PNG</div>";
        }
    }

    $sql = "INSERT INTO sach(ten_sach, ma_tac_gia, ma_nxb, ma_the_loai, gia_mua, gia_ban, so_luong, nam_xuat_ban, mo_ta, anh_bia) 
            VALUES ('$ten_sach', '$ma_tac_gia', '$ma_nxb', '$ma_the_loai', '$gia_mua', '$gia_ban', '$so_luong', '$nam_xuat_ban', '$mo_ta', '$anh_bia')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4' role='alert'>Thêm sách thành công</div>";
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
    <title>Thêm Sách</title>
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
                    <h1 class="text-2xl font-semibold text-gray-900">Thêm Sách Mới</h1>
                </div>
            </header>

            <!-- Page content -->
            <main class="max-w-3xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <form method="post" enctype="multipart/form-data" class="p-6 space-y-6">
                        <div>
                            <label for="ten_sach" class="block text-sm font-medium text-gray-700">Tên Sách</label>
                            <input type="text" name="ten_sach" id="ten_sach" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="ma_tac_gia" class="block text-sm font-medium text-gray-700">Tác Giả</label>
                            <select name="ma_tac_gia" id="ma_tac_gia" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Chọn tác giả</option>
                                <?php
                                $sql = "SELECT ma_tac_gia, ten FROM tacgia";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_array()) {
                                        echo '<option value="' . $row["ma_tac_gia"] . '">' . $row["ten"] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Không có tác giả</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="ma_nxb" class="block text-sm font-medium text-gray-700">Nhà Xuất Bản</label>
                            <select name="ma_nxb" id="ma_nxb" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Chọn NXB</option>
                                <?php
                                $sql = "SELECT ma_nxb, ten FROM nxb";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_array()) {
                                        echo '<option value="' . $row["ma_nxb"] . '">' . $row["ten"] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Không có NXB</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="ma_the_loai" class="block text-sm font-medium text-gray-700">Thể Loại</label>
                            <select name="ma_the_loai" id="ma_the_loai" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="">Chọn Thể Loại</option>
                                <?php
                                $sql = "SELECT ma_the_loai, the_loai FROM theloai";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_array()) {
                                        echo '<option value="' . $row["ma_the_loai"] . '">' . $row["the_loai"] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Không có thể loại</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="gia_mua" class="block text-sm font-medium text-gray-700">Giá Mua</label>
                            <input type="number" name="gia_mua" id="gia_mua" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="gia_ban" class="block text-sm font-medium text-gray-700">Giá Bán</label>
                            <input type="number" name="gia_ban" id="gia_ban" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="so_luong" class="block text-sm font-medium text-gray-700">Số Lượng</label>
                            <input type="number" name="so_luong" id="so_luong" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="nam_xuat_ban" class="block text-sm font-medium text-gray-700">Năm Xuất Bản</label>
                            <input type="number" name="nam_xuat_ban" id="nam_xuat_ban" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div>
                            <label for="mo_ta" class="block text-sm font-medium text-gray-700">Mô Tả</label>
                            <textarea name="mo_ta" id="mo_ta" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" rows="3" required></textarea>
                        </div>

                        <div>
                            <label for="anh_bia" class="block text-sm font-medium text-gray-700">Ảnh Bìa</label>
                            <input type="file" name="anh_bia" id="anh_bia" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border" required>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Thêm Sách
                            </button>
                            <a href="show_sach.php" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Trở về trang quản lý sách
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
