<?php
require "../../../connect.php";
require '../../../checker/kiemtra_admin.php';
include '../../sidebar.php';
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
                        <th>Tác giả</th>
                        <th>Nhà xuất bản</th>
                        <th>Thể loại</th>
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
                            $ma_tac_gia = $count['ma_tac_gia'];
                            $sql1 = "SELECT ten from tacgia";
                            $result1 = $conn->query($sql1);
                            $tentg = $result1->num_rows;
                            if($tentg > 0){
                                $ten_tac_gia = $result1->fetch_array()['ten'];
                            } 
                            $ma_nxb = $count['ma_nxb'];
                            $sql2 = "SELECT ten from nxb";
                            $result2 = $conn->query($sql2);
                            $tennxb = $result2->num_rows;
                            if($tennxb > 0){
                                $ten_nxb = $result2->fetch_array()['ten'];
                            }
                            $ma_the_loai = $count['ma_the_loai'];
                            $sql3 = "SELECT the_loai from theloai";
                            $result3 = $conn->query($sql3);
                            $tentl = $result3->num_rows;
                            if($tentl > 0){
                                $the_loai = $result3->fetch_array()['the_loai'];
                            }
                            echo "<tr>
                    <td>{$count['ma_sach']}</td>
                    <td>{$count['ten_sach']}</td>
                    <td >{$ten_tac_gia}</td>
                    <td>{$ten_nxb}</td>
                    <td>{$the_loai}</td>
                    <td>{$count['gia_mua']}</td>
                    <td>{$count['gia_ban']}</td>
                    <td>{$count['so_luong']}</td>
                    <td>{$count['nam_xuat_ban']}</td>
                    <td>{$count['mo_ta']}</td>
                    <td><img src='{$count['anh_bia']}' alt='Ảnh bìa' style='width: 100px; height: auto;'></td>
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
                <a href = "../../admin_page.php"><button type="button">Trang chủ</button></a>
                      

    </body>
</html>