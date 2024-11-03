<?php
    require "../nxb/db.php";
    $sql ="SELECT * FROM theloai ";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Thông tin thể loại </title>
    </head>

    <body>
        <center><h1>Thông tin thể loại</h1></center>
    <table style="width: 100%; margin: auto; " border="1">
                    <tr>
                        <th>Mã thể loại</th>
                        <th>Tên thể loại</th>
                        <th>Chức năng</th>
                    </tr>
                    <?php
                    $sach = $result->num_rows;
                    if ($sach > 0) {
                        while ($count = $result->fetch_array()) {
                            echo "<tr>
                    <td>{$count['ma_the_loai']}</td>
                    <td>{$count['the_loai']}</td>
                    <td>
                         <a href = 'edit_tl.php?ma_the_loai={$count['ma_the_loai']}'><button>Chỉnh Sửa </button></a> 
                         <a href = 'xoa_tl.php?ma_the_loai={$count['ma_the_loai']}  onclick= return confirm('Bạn có chắc chắn muốn xóa ')'> Xóa </a>
                    </td>
                    ";
                     
                        }
                    } else {
                        echo "<tr><td colspan='2'>Không có thể loại nào trong cơ sở dữ liệu</td></tr>";
                    }
                    
                    ?>

                </table>
                <br>
                <a href = "add_tl.php"><button type="button">Thêm thể loại</button></a>
                <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
                      

    </body>
</html>