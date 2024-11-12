<div class="sidebar">
    <h1>Admin</h1>
    <a href="/DonHangRouter.php?action=list"><button>Quản lý đơn hàng</button></a>
    <a href="/admin/doanhthu/doanhthu.php"><button>Quản lý doanh thu</button></a>
    <a href="/admin/qlkh/quanlikhachhang.php"><button>Quản lý khách hàng</button></a>
    <a href="/admin/ql_sach/nxb/show_nxb.php"><button>Quản lý nhà xuất bản</button></a>
    <a href="/admin/ql_sach/tacgia/show_tacgia.php"><button>Quản lý tác Giả</button></a>
    <a href="/admin/ql_sach/theloai/show_the_loai.php"><button>Quản lý thể loại</button></a>
    <a href="/admin/ql_sach/sach/show_sach.php"><button>Quản lý sách</button></a>
</div>

<style>
    /* CSS cho sidebar */
    .sidebar {
    width: 200px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    padding: 10px;
    background-color: #5D4037; /* Màu nâu */
    border-radius: 0 8px 8px 0;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    z-index: 1;
}

.sidebar h1 {
    color: #ffffff;
    font-size: 24px;
    margin-bottom: 20px;
}

.sidebar button {
    width: 100%;
    background-color: #FFA726; /* Màu cam cho nút */
    color: white;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    margin-bottom: 10px;
}

.sidebar button:hover {
    background-color: #FB8C00; /* Màu cam đậm khi hover */
}


    .sidebar a {
        text-decoration: none;
        color: white;
    }
</style>
