<?php
require 'checker/kiemtra_admin.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn Hàng</title>
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
            margin-bottom: 20px;
            border-radius: 5px;
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
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }

        .modal-footer {
            border-top: 1px solid #eaeaea;
        }
        
        /* Fix horizontal scroll issue */
        .table-responsive {
            overflow-x: auto;
        }
        
        @media (max-width: 992px) {
            .table th, .table td {
                white-space: nowrap;
            }
        }
        
        /* Make sidebar work better with main content */
        @media (min-width: 768px) {
            main {
                margin-left: 16rem;
            }
        }
        
        /* Status badges */
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
        }
        
        .status-waiting {
            background-color: #FFF0C2;
            color: #A05E03;
        }
        
        .status-confirmed {
            background-color: #C2F5FF;
            color: #055160;
        }
        
        .status-shipping {
            background-color: #DFCCFF;
            color: #3A0CA3;
        }
        
        .status-delivered {
            background-color: #D1FFD1;
            color: #0A5E0A;
        }
        
        .status-payment {
            background-color: #FFE2C2;
            color: #7D2503;
        }
        
        .status-paid {
            background-color: #C2FFED;
            color: #036355;
        }
        
        .status-cancelled {
            background-color: #FFD1D1;
            color: #5E0A0A;
        }
        
        /* Filter section */
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        /* Print styling */
        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
        
        /* Modal improvements */
        .order-detail-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .order-detail-section {
            padding: 15px;
            border: 1px solid #eaeaea;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-xs {
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
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
                <header class="header d-flex justify-content-between align-items-center mt-3">
                    <h2><i class="fas fa-shopping-cart me-2"></i>Quản lý Đơn Hàng</h2>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> In danh sách
                        </button>
                    </div>
                </header>

                <!-- Filter section -->
                <div class="filter-section no-print">
                    <div class="row">
                        <div class="col-md-9">
                            <form class="row g-3" method="GET" action="DonHangRouter.php">
                                <input type="hidden" name="action" value="list">
                                <div class="col-md-3">
                                    <label for="order-status" class="form-label">Trạng thái:</label>
                                    <select id="order-status" class="form-select form-select-sm" name="status">
                                        <option value="">Tất cả trạng thái</option>
                                        <option value="DANG_CHO" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DANG_CHO') ? 'selected' : ''; ?>>Đang chờ</option>
                                        <option value="CHO_THANH_TOAN" <?php echo (isset($_GET['status']) && $_GET['status'] == 'CHO_THANH_TOAN') ? 'selected' : ''; ?>>Chờ thanh toán</option>
                                        <option value="DA_THANH_TOAN" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DA_THANH_TOAN') ? 'selected' : ''; ?>>Đã thanh toán</option>
                                        <option value="DA_XAC_NHAN" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DA_XAC_NHAN') ? 'selected' : ''; ?>>Đã xác nhận</option>
                                        <option value="DANG_GIAO" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DANG_GIAO') ? 'selected' : ''; ?>>Đang giao</option>
                                        <option value="DA_GIAO" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DA_GIAO') ? 'selected' : ''; ?>>Đã giao</option>
                                        <option value="DA_HUY" <?php echo (isset($_GET['status']) && $_GET['status'] == 'DA_HUY') ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="date-from" class="form-label">Từ ngày:</label>
                                    <input type="date" class="form-control form-control-sm" id="date-from" name="date_from" value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="date-to" class="form-label">Đến ngày:</label>
                                    <input type="date" class="form-control form-control-sm" id="date-to" name="date_to" value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm me-2">
                                        <i class="fas fa-filter me-1"></i> Lọc
                                    </button>
                                    <a href="DonHangRouter.php?action=list" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-sync-alt me-1"></i> Đặt lại
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <label for="searchOrder" class="form-label">Tìm kiếm:</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="searchOrder" placeholder="Mã đơn hàng, khách hàng...">
                                <button class="btn btn-outline-secondary btn-sm" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Stats -->
                <div class="row mb-4 no-print">
                    <div class="col-md-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h5 class="card-title">Tổng đơn hàng</h5>
                                <p class="card-text fs-4"><?php echo count($donHangs); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h5 class="card-title">Đang xử lý</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    echo count(array_filter($donHangs, function($donHang) {
                                        return in_array($donHang->getTrangThai(), ['DANG_CHO', 'CHO_THANH_TOAN', 'DA_THANH_TOAN', 'DA_XAC_NHAN']);
                                    }));
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <h5 class="card-title">Đang giao</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    echo count(array_filter($donHangs, function($donHang) {
                                        return $donHang->getTrangThai() === 'DANG_GIAO';
                                    }));
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title">Đã giao</h5>
                                <p class="card-text fs-4">
                                    <?php
                                    echo count(array_filter($donHangs, function($donHang) {
                                        return $donHang->getTrangThai() === 'DA_GIAO';
                                    }));
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nội dung trang -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Mã KH</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Địa chỉ giao hàng</th>
                            <th class="no-print">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($donHangs)): ?>
                            <?php foreach ($donHangs as $donHang): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($donHang->getMaDonHang()); ?></td>
                                    <td><?php echo htmlspecialchars($donHang->getMaKhachHang()); ?></td>
                                    <td><?php echo number_format($donHang->getTong(), 0, ',', '.'); ?>₫</td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($donHang->getNgayDatHang())); ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        
                                        switch ($donHang->getTrangThai()) {
                                            case 'DANG_CHO':
                                                $statusClass = 'status-waiting';
                                                $statusText = 'Đang chờ';
                                                break;
                                            case 'CHO_THANH_TOAN':
                                                $statusClass = 'status-payment';
                                                $statusText = 'Chờ thanh toán';
                                                break;
                                            case 'DA_THANH_TOAN':
                                                $statusClass = 'status-paid';
                                                $statusText = 'Đã thanh toán';
                                                break;
                                            case 'DA_XAC_NHAN':
                                                $statusClass = 'status-confirmed';
                                                $statusText = 'Đã xác nhận';
                                                break;
                                            case 'DANG_GIAO':
                                                $statusClass = 'status-shipping';
                                                $statusText = 'Đang giao';
                                                break;
                                            case 'DA_GIAO':
                                                $statusClass = 'status-delivered';
                                                $statusText = 'Đã giao';
                                                break;
                                            case 'DA_HUY':
                                                $statusClass = 'status-cancelled';
                                                $statusText = 'Đã hủy';
                                                break;
                                            default:
                                                $statusText = 'Không xác định';
                                        }
                                        echo "<span class='status-badge $statusClass'>$statusText</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $diaChiNganGon = strlen($donHang->getDiaChiNhanHang()) > 30 
                                                ? substr($donHang->getDiaChiNhanHang(), 0, 30) . '...' 
                                                : $donHang->getDiaChiNhanHang();
                                            echo htmlspecialchars($diaChiNganGon);
                                        ?>
                                    </td>
                                    <td class="no-print">
                                        <div class="action-buttons">
                                            <?php if (in_array($donHang->getTrangThai(), ['DANG_CHO', 'DA_THANH_TOAN', 'DA_XAC_NHAN', 'DANG_GIAO'])): ?>
                                                <form method="POST" action="DonHangRouter.php?action=updateStatus" class="d-inline">
                                                    <input type="hidden" name="maDonHang" value="<?php echo htmlspecialchars($donHang->getMaDonHang()); ?>">
                                                    <?php if ($donHang->getTrangThai() === 'DANG_CHO' || $donHang->getTrangThai() === 'DA_THANH_TOAN'): ?>
                                                        <input type="hidden" name="trangThai" value="DA_XAC_NHAN">
                                                        <button type="submit" class="btn btn-success btn-xs" title="Xác nhận đơn hàng">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    <?php elseif ($donHang->getTrangThai() === 'DA_XAC_NHAN'): ?>
                                                        <input type="hidden" name="trangThai" value="DANG_GIAO">
                                                        <button type="submit" class="btn btn-info btn-xs" title="Chuyển sang đang giao">
                                                            <i class="fas fa-truck"></i>
                                                        </button>
                                                    <?php elseif ($donHang->getTrangThai() === 'DANG_GIAO'): ?>
                                                        <input type="hidden" name="trangThai" value="DA_GIAO">
                                                        <button type="submit" class="btn btn-primary btn-xs" title="Xác nhận đã giao">
                                                            <i class="fas fa-box-check"></i> ✓
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            <?php endif; ?>
                                            
                                            <button type="button" 
                                                    class="btn btn-secondary btn-xs btnChiTiet" 
                                                    data-id="<?php echo $donHang->getMaDonHang(); ?>"
                                                    title="Xem chi tiết đơn hàng">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <?php if (in_array($donHang->getTrangThai(), ['DANG_CHO', 'CHO_THANH_TOAN', 'DA_THANH_TOAN'])): ?>
                                                <form id="cancelForm" action="DonHangRouter.php?action=delete" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                                    <input type="hidden" name="maDonHang" value="<?php echo htmlspecialchars($donHang->getMaDonHang()); ?>">
                                                    <button type="submit" class="btn btn-danger btn-xs" title="Hủy đơn hàng">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
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
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">
                                    <i class="fas fa-info-circle me-2"></i>Chi tiết đơn hàng #<span id="orderIdDisplay"></span>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="printArea">
                                    <div id="chiTietDonHangContent">
                                        <!-- Nội dung chi tiết đơn hàng sẽ được thêm vào đây -->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary no-print" onclick="printOrderDetails()">
                                    <i class="fas fa-print me-1"></i> In đơn hàng
                                </button>
                                <form id="deleteForm" action="/DonHangRouter.php?action=delete" method="POST"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" style="display: none;">
                                    <input type="hidden" name="maDonHang" id="maDonHangToDelete">
                                    <button type="submit" class="btn btn-danger no-print">
                                        <i class="fas fa-ban me-1"></i> Hủy đơn
                                    </button>
                                </form>
                                <button type="button" class="btn btn-secondary no-print" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search functionality
            const searchInput = document.getElementById('searchOrder');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr');
                
                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // View detail button functionality
            document.querySelectorAll('.btnChiTiet').forEach(button => {
                button.addEventListener('click', function () {
                    const maDonHang = this.getAttribute('data-id');
                    console.log("Mã Đơn Hàng being sent:", maDonHang);
                    document.getElementById('orderIdDisplay').textContent = maDonHang;

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
                    
                    // Đối tượng ánh xạ trạng thái sang class
                    const statusClasses = {
                        'DANG_CHO': 'status-waiting',
                        'CHO_THANH_TOAN': 'status-payment',
                        'DA_THANH_TOAN': 'status-paid',
                        'DA_XAC_NHAN': 'status-confirmed',
                        'DANG_GIAO': 'status-shipping',
                        'DA_GIAO': 'status-delivered',
                        'DA_HUY': 'status-cancelled'
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
                            const trangThai = trangThaiVietnamese[data.trangThai] || data.trangThai;
                            const statusClass = statusClasses[data.trangThai] || '';

                            const chiTietSachHTML = data.chiTietSach.map(sach =>
                                `<tr>
                                    <td>${sach.tenSach}</td>
                                    <td class="text-center">${sach.soLuong}</td>
                                </tr>`).join('');

                            const formattedDate = new Date(data.ngayDatHang).toLocaleDateString('vi-VN', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            const content = `
                            <div class="order-detail-header d-flex justify-content-between">
                                <div>
                                    <h6>Book Store - Chi tiết đơn hàng</h6>
                                    <p class="mb-0"><strong>Mã đơn hàng:</strong> #${data.maDonHang}</p>
                                    <p class="mb-0"><strong>Ngày đặt:</strong> ${formattedDate}</p>
                                </div>
                                <div>
                                    <span class="status-badge ${statusClass}">${trangThai}</span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="order-detail-section">
                                        <h6 class="mb-3"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h6>
                                        <p class="mb-1"><strong>Mã khách hàng:</strong> ${data.maKhachHang}</p>
                                        <p class="mb-1"><strong>Số điện thoại:</strong> ${data.soDienThoai}</p>
                                        <p class="mb-1"><strong>Địa chỉ nhận hàng:</strong> ${data.diaChiNhanHang}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="order-detail-section">
                                        <h6 class="mb-3"><i class="fas fa-money-bill me-2"></i>Thông tin thanh toán</h6>
                                        <p class="mb-1"><strong>Tổng tiền:</strong> ${data.tongTien.toLocaleString()} VND</p>
                                        <p class="mb-1"><strong>Phương thức thanh toán:</strong> ${data.phuongThucThanhToan || 'COD'}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-detail-section">
                                <h6 class="mb-3"><i class="fas fa-box me-2"></i>Chi tiết sản phẩm</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tên sách</th>
                                                <th class="text-center">Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${chiTietSachHTML}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><strong>Tổng loại sách:</strong></td>
                                                <td class="text-center"><strong>${data.tongSoLoaiSach}</strong></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tổng số sách:</strong></td>
                                                <td class="text-center"><strong>${data.tongSoLuongSach}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="order-detail-section" style="page-break-after: always;">
                                <h6 class="mb-3"><i class="fas fa-clock me-2"></i>Lịch sử đơn hàng</h6>
                                <p class="mb-1"><strong>Ngày đặt hàng:</strong> ${formattedDate}</p>
                                <p class="mb-1"><strong>Trạng thái hiện tại:</strong> <span class="status-badge ${statusClass}">${trangThai}</span></p>
                            </div>`;

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
        
        // Function to print order details
        function printOrderDetails() {
            window.print();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
