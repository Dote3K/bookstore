<?php
    require "../nxb/db.php";
    $sql ="SELECT * FROM sach ";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Thông tin Sách </title>
    </head>

    <body>
    <center><h1>Thông tin sách</h1></center>
    <table style="width: 100%; margin: auto; " border="1">
                    <tr>
                        <th>Mã Sách</th>
                        <th>Tên Sách</th>
                        <th>Mã tác giả</th>
                        <th>Mã nhà xuất bản</th>
                        <th>Mã thể loại</th>
                        <th>Giá mua</th>
                        <th>Giá bán</th>
                        <th>Số lượng</th>
                        <th>Năm xuất bản</th>
                        <th>Mô tả</th>
                        <th>Ảnh bìa</th>
                        <th>Chức năng</th>
                    </tr>
                    <?php
                    $sach = $result->num_rows;
                    if ($sach > 0) {
                        while ($count = $result->fetch_array()) {
                            $image = $count['anh_bia'];
                            echo "<tr>
                    <td>{$count['ma_sach']}</td>
                    <td>{$count['ten_sach']}</td>
                    <td>{$count['ma_tac_gia']}</td>
                    <td>{$count['ma_nxb']}</td>
                    <td>{$count['ma_the_loai']}</td>
                    <td>{$count['gia_mua']}</td>
                    <td>{$count['gia_ban']}</td>
                    <td>{$count['so_luong']}</td>
                    <td>{$count['nam_xuat_ban']}</td>
                    <td>{$count['mo_ta']}</td>
                    <td>{$count['anh_bia']}</td>
                    <td>
                         <a href = 'edit_sach.php?ma_sach={$count['ma_sach']}'><button>Chỉnh Sửa </button></a> 
                         <a href = 'xoa_sach.php?ma_sach={$count['ma_sach']}  onclick= return confirm('Bạn có chắc chắn muốn xóa nxb này')'>Xóa</a>
                    </td>
                    ";
                     
                        }
                    } else {
                        echo "<tr><td colspan='11'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
                    }
                    
                    ?>

                </table>
                <br>
                <a href = "add_book.php"><button type="button">Thêm sách</button></a>
                <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
                      

    </body>
</html>