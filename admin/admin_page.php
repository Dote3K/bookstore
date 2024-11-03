<?php
session_start();

if (!isset($_SESSION['ma_khach_hang']) || $_SESSION['vai_tro'] !== 'admin') {
    header("Location: home.php");
    exit();
}

echo "Admin";
?>
<br>
<a href="../admin/doanhthu/doanhthu.php"><button>Quản lý doanh thu</button></a><br>
<a href="ql_sach/nxb/show_nxb.php"><button>Nhà xuất bản</button></a><br>
<a href="ql_sach/tacgia/show_tacgia.php"><button>Tác Giả</button></a><br>
<a href="ql_sach/theloai/show_the_loai.php"><button>Thể loại</button></a><br>
<a href="ql_sach/sach/show_sach.php"><button>Sách</button></a><br>


<a href="../home.php">Trở về trang chủ</a>