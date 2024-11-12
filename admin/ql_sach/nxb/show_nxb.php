<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM nxb";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin Nhà Xuất Bản</title>

</head>

<body>
<div class="container">
    <h1>Thông tin Nhà Xuất Bản</h1>
    <table>
        <tr>
            <th>Mã nhà xuất bản</th>
            <th>Tên Nhà xuất bản</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Chức năng</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($count = $result->fetch_array()) {
                echo "<tr>
                        <td>{$count['ma_nxb']}</td>
                        <td>{$count['ten']}</td>
                        <td>{$count['dia_chi']}</td>
                        <td>{$count['sdt']}</td>
                        <td>{$count['email']}</td>
                        <td class='action-buttons'>
                            <a href='edit_nxb.php?ma_nxb={$count['ma_nxb']}'><button>Chỉnh Sửa</button></a> 
                            <a href='xoa_nxb.php?ma_nxb={$count['ma_nxb']}' onclick='return confirm(\"Bạn có chắc chắn muốn xóa NXB này?\")'><button>Xóa</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
        }
        ?>
    </table>
    <a href="add_nxb.php" class="back-link">Thêm Nhà Xuất Bản</a><br>

</div>
</body>
</html>
