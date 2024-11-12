<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';

$sql = "SELECT * FROM theloai";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin thể loại</title>

</head>

<body>
    <div class="container">
        <h1>Thông tin thể loại</h1>
        <table>
            <tr>
                <th>Mã thể loại</th>
                <th>Tên thể loại</th>
                <th>Chức năng</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($count = $result->fetch_array()) {
                    echo "<tr>
                            <td>{$count['ma_the_loai']}</td>
                            <td>{$count['the_loai']}</td>
                            <td>
                                <a href='edit_tl.php?ma_the_loai={$count['ma_the_loai']}'><button>Chỉnh Sửa</button></a> 
                                <a href='xoa_tl.php?ma_the_loai={$count['ma_the_loai']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa?')\"><button>Xóa</button></a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Không có thể loại nào trong cơ sở dữ liệu</td></tr>";
            }
            ?>
        </table>

        <div class="button-container">
            <a href="add_tl.php" class="back-link">Thêm thể loại</a>

        </div>
    </div>
</body>
</html>
