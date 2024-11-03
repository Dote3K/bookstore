<?php
    require "../nxb/db.php";
    $sql ="SELECT * FROM tacgia ";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
    <title>Thông tin tác giả </title>
    </head>

    <body>
    <center><h1>Thông tin tác giả</h1></center>
    <table style="width: 100%; margin: auto; " border="1">
                    <tr>
                        <th>Mã tác giả</th>
                        <th>Tên</th>
                        <th>Tiểu Sử</th>
                        <th>Chức năng</th>
                    </tr>
                    <?php
                    $sach = $result->num_rows;
                    if ($sach > 0) {
                        while ($count = $result->fetch_array()) {
                            echo "<tr>
                    <td>{$count['ma_tac_gia']}</td>
                    <td>{$count['ten']}</td>
                    <td>{$count['tieu_su']}</td>
                    <td>
                         <a href = 'edit_tg.php?ma_tac_gia={$count['ma_tac_gia']}'><button>Chỉnh Sửa </button></a> 
                         <a href = 'xoa_tg.php?ma_tac_gia={$count['ma_tac_gia']}  onclick= return confirm('Bạn có chắc chắn muốn xóa tác giả này')'>Xóa</a>
                    </td>
                    ";
                     
                        }
                    } else {
                        echo "<tr><td colspan='4'>Không có tác giả nào trong cơ sở dữ liệu</td></tr>";
                    }
                    
                    ?>

                </table>
                <br>
                <a href = "add_tg.php"><button type="button">Thêm tác giả</button></a>
                <a href = "../trang_quan_ly.php"><button type="button">Trang chủ</button></a>
                      

    </body>
</html>