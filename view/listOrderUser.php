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
                    <th colspan="2">Thao tác</th>
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
                            <td><?php echo $donHang->getTrangThai(); ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary btnChiTiet" data-id="<?php echo $donHang->getMaDonHang(); ?>">
                                    Xem chi tiết
                                </button>
                            </td>
                            <td>
                                <form action="/DonHangRouter.php?action=delete" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?');">
                                    <input type="hidden" name="maDonHang" value="<?php echo $donHang->getMaDonHang(); ?>">
                                    <button type="submit" class="btn btn-danger">Hủy</button>
                                </form>
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

    <!-- <script>
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
    </script> -->
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
                                // Tạo HTML cho chi tiết sách
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
                                <p><strong>Tổng Tiền:</strong> ${data.tongTien.toLocaleString()} VND</p>
                                <p><strong>Ngày Đặt Hàng:</strong> ${data.ngayDatHang}</p>
                                <p><strong>Trạng Thái:</strong> ${data.trangThai}</p>
                                <p><strong>Địa Chỉ Nhận Hàng:</strong> ${data.diaChiNhanHang}</p>
                            </div>
                            <div class="col-md-6">
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
                        </div>
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
</body>

</html>