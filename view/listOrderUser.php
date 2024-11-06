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
                    <th>thao tác</th>
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
</body>

</html>