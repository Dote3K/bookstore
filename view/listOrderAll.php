<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đơn Hàng</title>
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
            background: linear-gradient(45deg, #ffafbd, #ffc3a0);
            color: #333;
        }

        h1 {
            color: #5a005a;
        }

        table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #ff6a88;
        }

        tr:hover {
            background-color: #ffe6f2;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container my-5">
        <h1 class="text-center my-4">Danh Sách Đơn Hàng</h1>
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
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($donHangs)): ?>
                    <?php foreach ($donHangs as $donHang): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($donHang->getMaDonHang()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getMaKhachHang()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getTong()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getNgayDatHang()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getTrangThai()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getDiaChiNhanHang()); ?></td>
                            <td><?php echo htmlspecialchars($donHang->getGiamGia()); ?></td>
                            <td>
                                <form method="POST" action="/DonHangRouter.php?action=updateStatus" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="maDonHang" value="<?php echo htmlspecialchars($donHang->getMaDonHang()); ?>">

                                    <select name="trangThai" class="form-select form-select-sm" style="width: auto;">
                                        <?php if ($donHang->getTrangThai() === 'DANG_CHO') : ?>
                                            <option value="DA_XAC_NHAN">Đã xác nhận</option>
                                        <?php elseif ($donHang->getTrangThai() === 'DA_XAC_NHAN') : ?>
                                            <option value="DANG_GIAO">Đang giao</option>
                                        <?php elseif ($donHang->getTrangThai() === 'DANG_GIAO') : ?>
                                            <option value="DA_GIAO">Đã giao</option>
                                        <?php endif; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                        Cập nhật
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có dữ liệu đơn hàng</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>