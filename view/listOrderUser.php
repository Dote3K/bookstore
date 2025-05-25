<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
        crossorigin="anonymous">
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffafbd, #ffc3a0);
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #fff;
        }

        .table {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        th {
            background-color: #ff6f61;
        }

        td {
            text-align: center;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .modal-header {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-footer {
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .btn-close {
            color: white;
            opacity: 0.5;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .btn-outline-secondary,
        .btn-danger {
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-secondary:hover {
            background-color: #ff6f61;
            color: white;
        }

        .btn-danger:hover {
            background-color: #d9534f;
            color: white;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 12px;
        }

        .modal-body h5 {
            color: #2c3e50;
            font-weight: 600;
        }

        .modal-body p {
            color: #34495e;
        }

        .modal-body .row {
            margin-bottom: 20px;
        }

        /* Table details in modal */
        .table-details {
            margin-top: 20px;
        }

        .modal-footer .btn-danger {
            background-color: #ff6f61;
            border-color: #ff6f61;
        }

        .modal-footer .btn-danger:hover {
            background-color: #d9534f;
        }

        .custom-btn {
            color: #6e5494;
            border-color: #d9a3c8;
            background-color: transparent;
            transition: all 0.3s ease;
            /* Thêm hiệu ứng chuyển đổi */
        }

        .custom-btn:hover {
            background-color: #ff6666 !important;
            color: white !important;
            border-color: #ff4b4b !important;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <h1>Danh sách đơn hàng</h1>
    <div class="container mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Địa chỉ nhận hàng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($donHangs)): ?>
                    <?php foreach ($donHangs as $donHang): ?>
                        <tr>
                            <td><?php echo $donHang->getMaDonHang(); ?></td>
                            <td><?php echo $donHang->getNgayDatHang(); ?></td>
                            <td><?php echo $donHang->getTong(); ?></td>
                            <td><?php echo $donHang->getDiaChiNhanHang(); ?></td>
                            <td><?php
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
                                ?></td>
                            <td>
                                <button type="button"
                                    class="ms-auto btn btn-sm btn-outline-primary btnChiTiet custom-btn"
                                    data-id="<?php echo $donHang->getMaDonHang(); ?>">
                                    Xem chi tiết
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Không có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
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
                    <!-- Form xóa đơn hàng, sẽ được điền thông tin qua JavaScript -->
                    <form id="deleteForm" action="/DonHangRouter.php?action=delete" method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');" style="display: none;">
                        <input type="hidden" name="maDonHang" id="maDonHangToDelete">
                        <button type="submit" class="btn btn-danger">Hủy đơn</button>
                    </form>
                    <button type="button"
                        class="btn btn-secondary custom-btn"
                        data-bs-dismiss="modal">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btnChiTiet').forEach(button => {
                button.addEventListener('click', function() {
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
                                const trangThai = trangThaiVietnamese[data.trangThai] || data.trangThai; // Nếu không tìm thấy trạng thái, giữ nguyên giá trị mã trạng thái

                                const chiTietSachHTML = data.chiTietSach.map(sach =>
                                    `<tr>
                                <td>${sach.tenSach}</td>
                                <td>${sach.soLuong}</td>
                            </tr>`
                                ).join('');

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"></script>
</body>

</html>