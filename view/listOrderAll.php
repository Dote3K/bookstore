<?php
// Bao gồm các tệp cần thiết và kiểm tra xác thực
require 'checker/kiemtra_admin.php'; // Đảm bảo rằng admin đã đăng nhập

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
                                <th>Giảm Giá</th>
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
                                        <td><?php echo htmlspecialchars($donHang->getGiamGia()); ?>%</td>
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
                                            <button type="button" class="btn btn-outline-secondary btnChiTiet" data-id="<?php echo $donHang->getMaDonHang(); ?>">
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
                <div class="modal fade" id="modalChiTietDonHang" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-3 shadow-lg">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="modalLabel">Chi tiết đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="chiTietDonHangContent">
                                    <!-- Nội dung chi tiết đơn hàng -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btnChiTiet').forEach(button => {
                button.addEventListener('click', function() {
                    const maDonHang = this.getAttribute('data-id');
                    console.log("Mã Đơn Hàng being sent:", maDonHang);

                    fetch('/DonHangRouter.php?action=chiTietDonHang', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `maDonHang=${maDonHang}`
                        })
                        .then(response => {
                            console.log("Raw Response:", response);
                            return response.json();
                        })
                        .then(data => {
                            console.log("Parsed Data:", data);

                            if (data.error) {
                                alert(data.error);
                            } else {
                                const content = `
                        <p><strong>Tên sách:</strong> ${data.tenSach}</p>
                        <p><strong>Tổng tiền:</strong> ${data.tongTien}</p>
                        <p><strong>số điện thoại :</strong> ${data.soDienThoai}</p>
                        <p><strong>Ngày đặt hàng:</strong> ${data.ngayDatHang}</p>
                        <p><strong>Số lượng:</strong> ${data.soLuong}</p>
                        <p><strong>Trạng thái:</strong> ${data.trangThai}</p>
                        <p><strong>Địa chỉ nhận hàng:</strong> ${data.diaChiNhanHang}</p>
                    `;
                                document.getElementById('chiTietDonHangContent').innerHTML = content;
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