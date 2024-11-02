<?php
require '../connect.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form>
    <label for="ma_tac_gia">Chọn tác giả</label>
    <select name="ma_tac_gia" >
        <?php
        $result = "SELECT * FROM tacgia";
        $runquery = mysqli_query($conn, $result);
        while ($row = mysqli_fetch_assoc($runquery)) {
            $maTacGia = $row['ma_tac_gia'];
            $tenTacGia = $row['ten'];
            echo '<option value="' . $maTacGia . '">' . $tenTacGia . '</option>';
        }
        ?>
    </select>
        <label for="the_loai">Chọn thể loại</label>
        <select name="the_loai">
           <?php
            $result2 = "SELECT * FROM theloai";
            $runquery2 = mysqli_query($conn, $result2);
            while ($row = mysqli_fetch_assoc($runquery2)) {
            $maTheLoai = $row['ma_the_loai'];
            $theLoai = $row['the_loai'];
            echo '<option value="' . $maTheLoai . '">' . $theLoai . '</option>';
            } ?>
        </select>

</form>
</body>
</html>
