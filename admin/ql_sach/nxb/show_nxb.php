<?php
    require "db.php";
    $sql ="SELECT * FROM nxb ";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Thông tin nhà xuất bản </title>
    </head>

    <body>
    <center><h1>Thông tin nhà xuất bản</h1></center>
    <table style="width: 100%; margin: auto; " border="1">
                    <tr>
                        <th>Mã nhà xuất bản</th>
                        <th>Tên Nhà xuất bản</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Chức năng</th>
                    </tr>
                    <?php
                    $sach = $result->num_rows;
                    if ($sach > 0) {
                        while ($count = $result->fetch_array()) {
                            echo "<tr>
                    <td>{$count['ma_nxb']}</td>
                    <td>{$count['ten']}</td>
                    <td>{$count['dia_chi']}</td>
                    <td>{$count['sdt']}</td>
                    <td>{$count['email']}</td>
                    <td>
                         <a href = 'edit_nxb.php?ma_nxb={$count['ma_nxb']}'><button>Chỉnh Sửa </button></a> 
                         <a href = 'xoa_nxb.php?ma_nxb={$count['ma_nxb']}  onclick= return confirm('Bạn có chắc chắn muốn xóa nxb này')'>Xóa</a>
                    </td>
                    ";
                     
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có sách nào trong cơ sở dữ liệu</td></tr>";
                    }
                    
                    ?>

                </table>
                <br>
                <a href = "add_nxb.php"><button type="button">Thêm nhà xuất bản</button></a>
                <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
                
                      

    </body>
</html>