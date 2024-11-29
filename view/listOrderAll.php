<?php
require 'checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh Sách Đơn Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .table thead {
            background-color: #4da6ff;
            color: white;
        }

        .header {
            background-color: #e9ecef;
            padding: 10px;
        }

        .header .nav-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
        }

        .header .nav-links a:hover {
            text-decoration: underline;
        }

        .table tbody tr:hover {
            background-color: #f2f2f2;
        }

        /* Cải tiến giao diện modal */
        .modal-content {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #4da6ff;
            color: white;
            font-size: 1.2rem;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
        }

        .table-details table th, .table-details table td {
            padding: 8px;
        }

        .table-details h5 {
            color: #4da6ff;
            margin-bottom: 10px;
        }

        .btn-close {
            background-color: transparent;
            border: none;
            color: #4da6ff;
            font-size: 1.2rem;
        }

        .btn-close:hover {
            color: #004a80;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <?php include 'admin/sidebar.php'; ?>
        </nav>
        <!-- Nội dung chính -->
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header -->
            <header class="header d-flex justify-content-between align-items-center">
                <h1>Danh Sách Đơn Hàng</h1>
            </header>

            <!-- Nội dung trang -->
            <div class="container my-5">
                <h2 class="text-center my-4">Danh Sách Đơn Hàng</h2>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Mã Khách Hàng</th>
                        <th>Tổng</th>
                        <th>Ngày Đặt Hàng</th>
                        <th>Trạng Thái</th>
                        <th>Địa Chỉ Nhận Hàng</th>
                        <th colspan="3">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($donHangs)): ?>
                        <?php foreach ($donHangs as $donHang): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donHang->getMaDonHang()); ?></td>
                                <td><?php echo htmlspecialchars($donHang->getMaKhachHang()); ?></td>
                                <td><?php echo number_format($donHang->getTong(), 0, ',', '.'); ?>₫</td>
                                <td><?php echo htmlspecialchars($donHang->getNgayDatHang()); ?></td>
                                <td>
                                    <?php
                                    switch ($donHang->getTrangThai()) {
                                        case 'DANG_CHO':
                                            echo 'Đang chờ';
                                            break;
                                        case 'CHO_THANH_TOAN':
                                            echo 'Chờ thanh toán';
                                            break;
                                        case 'DA_THANH_TOAN':
                                            echo 'Đã thanh toán';
                                            break;
                                        case 'DA_XAC_NHAN':
                                            echo 'Đã xác nhận';
                                            break;
                                        case 'DANG_GIAO':
                                            echo 'Đang giao';
                                            break;
                                        case 'DA_GIAO':
                                            echo 'Đã giao';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                    }
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($donHang->getDiaChiNhanHang()); ?></td>
                                <td>
                                    <form method="POST" action="DonHangRouter.php?action=updateStatus" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="maDonHang" value="<?php echo htmlspecialchars($donHang->getMaDonHang()); ?>">

                                        <select name="trangThai" class="form-select form-select-sm" style="width: auto;">
                                            <?php if ($donHang->getTrangThai() === 'DANG_CHO') : ?>
                                                <option value="DA_XAC_NHAN">Đã xác nhận</option>
                                            <?php elseif ($donHang->getTrangThai() === 'DA_THANH_TOAN') : ?>
                                                <option value="DA_XAC_NHAN">Đã xác nhận</option>
                                            <?php elseif ($donHang->getTrangThai() === 'DA_XAC_NHAN') : ?>
                                                <option value="DANG_GIAO">Đang giao</option>
                                            <?php elseif ($donHang->getTrangThai() === 'DANG_GIAO') : ?>
                                                <option value="DA_GIAO">Đã giao</option>
                                            <?php endif; ?>
                                        </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                        Cập nhật
                                    </button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="ms-auto btn btn-sm btn-outline-primary btnChiTiet" data-id="<?php echo $donHang->getMaDonHang(); ?>">
                                        Xem chi tiết
                                    </button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu đơn hàng</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
            <!-- Modal chi tiết đơn hàng -->
            <div class="modal fade" id="modalChiTietDonHang" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Chi tiết đơn hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="chiTietDonHangContent">
                                <!-- Nội dung chi tiết đơn hàng sẽ được thêm vào đây -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form id="deleteForm" action="/DonHangRouter.php?action=delete" method="POST"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');" style="display: none;">
                                <input type="hidden" name="maDonHang" id="maDonHangToDelete">
                                <button type="submit" class="btn btn-danger">Hủy đơn</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btnChiTiet').forEach(button => {
            button.addEventListener('click', function () {
                const maDonHang = this.getAttribute('data-id');
                console.log("Mã Đơn Hàng being sent:", maDonHang);

                // Đối tượng ánh xạ trạng thái sang tiếng Việt
                const trangThaiVietnamese = {
                    'DANG_CHO': 'Đang chờ',
                    'CHO_THANH_TOAN': 'Chờ thanh toán',
                    'DA_THANH_TOAN': 'Đã thanh toán',
                    'DA_XAC_NHAN': 'Đã xác nhận',
                    'DANG_GIAO': 'Đang giao',
                    'DA_GIAO': 'Đã giao',
                    'DA_HUY': 'Đã hủy'
                };

                fetch('/DonHangRouter.php?action=chiTietDonHang', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `maDonHang=${maDonHang}`
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        console.log("Parsed Data:", data);

                        if (data.error) {
                            alert(data.error);
                        } else {
                            // Chuyển trạng thái đơn hàng sang tiếng Việt
                            const trangThai = trangThaiVietnamese[data.trangThai] || data.trangThai;  // Nếu không tìm thấy trạng thái, giữ nguyên giá trị mã trạng thái

                            const chiTietSachHTML = data.chiTietSach.map(sach =>
                                `<tr>
                                <td>${sach.tenSach}</td>
                                <td>${sach.soLuong}</td>
                            </tr>`).join('');

                            const content = `
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Thông Tin Đơn Hàng</h5>
                                <p><strong>Mã Đơn Hàng:</strong> ${data.maDonHang}</p>
                                <p><strong>Số Điện Thoại:</strong> ${data.soDienThoai}</p>
                                <p><strong>Địa Chỉ Nhận Hàng:</strong> ${data.diaChiNhanHang}</p>
                                <br><br>
                                <p><strong>Ngày Đặt Hàng:</strong> ${data.ngayDatHang}</p>
                                <p><strong>Tổng Tiền:</strong> ${data.tongTien.toLocaleString()} VND</p>
                                <p><strong>Trạng Thái:</strong> ${trangThai}</p>

                            </div>
                        </div>
                        <div class="table-details">
                            <h5>Chi Tiết Sách</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên Sách</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${chiTietSachHTML}
                                </tbody>
                            </table>
                            <p><strong>Tổng Số Loại Sách:</strong> ${data.tongSoLoaiSach}</p>
                            <p><strong>Tổng Số Lượng Sách:</strong> ${data.tongSoLuongSach}</p>
                        </div>
                    `;

                            document.getElementById('chiTietDonHangContent').innerHTML = content;

                            // Cập nhật form xóa
                            const deleteForm = document.getElementById('deleteForm');
                            const maDonHangToDelete = document.getElementById('maDonHangToDelete');
                            maDonHangToDelete.value = data.maDonHang; // Gán mã đơn hàng vào form xóa

                            // Kiểm tra trạng thái đơn hàng và hiển thị nút "Hủy" nếu phù hợp
                            const allowedStates = ['DANG_CHO', 'CHO_THANH_TOAN', 'DA_THANH_TOAN'];
                            if (allowedStates.includes(data.trangThai)) {
                                deleteForm.style.display = 'block';
                            } else {
                                deleteForm.style.display = 'none';
                            }

                            const modal = new bootstrap.Modal(document.getElementById('modalChiTietDonHang'));
                            modal.show();
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi chi tiết:', error);
                        alert('Không thể tải chi tiết đơn hàng: ' + error);
                    });
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
