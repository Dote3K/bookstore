<?php
require_once '../checker/kiemtra_login.php';
require '../connect.php';

$ma_don_hang = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($ma_don_hang <= 0) {
    die('Mã đơn hàng không hợp lệ.');
}

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT * FROM donhang WHERE ma_don_hang = ?");
$stmt->bind_param("i", $ma_don_hang);
$stmt->execute();
$result = $stmt->get_result();
$don_hang = $result->fetch_assoc();

if (!$don_hang) {
    die('Không tìm thấy đơn hàng.');
}

$tong_tien = $don_hang['tong'];

// Lấy thông tin khách hàng
$ma_khach_hang = $don_hang['ma_khach_hang'];
$stmt = $conn->prepare("SELECT * FROM khachhang WHERE ma_khach_hang = ?");
$stmt->bind_param("i", $ma_khach_hang);
$stmt->execute();
$result = $stmt->get_result();
$khach_hang = $result->fetch_assoc();

if (!$khach_hang) {
    die('Không tìm thấy thông tin khách hàng.');
}

// Kiểm tra trạng thái đơn hàng
$trang_thai = $don_hang['trang_thai'];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán đơn hàng #<?php echo $ma_don_hang; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (Thêm dòng này để các icon hiển thị đúng) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom Styles (Same as home page) -->
    <style>
        body {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }


        .navbar {
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: bold;
        }
        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }
        .card-title {
            color: #ff6b6b;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #ff4b4b;
        }
        .footer {
            background-color: #333333;
            color: #ffffff;
            padding: 1.5rem 0;
            margin-top: auto;
        }
        .footer a {
            color: #ffcc33;
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="container my-5">
    <h1 class="text-center text-primary mb-4">Thanh toán đơn hàng #<?php echo $ma_don_hang; ?></h1>

    <?php if ($trang_thai == 'DA_THANH_TOAN' || $trang_thai == 'DA_XAC_NHAN' || $trang_thai == 'DANG_GIAO' || $trang_thai == 'DA_GIAO') { ?>
        <div class="alert alert-success text-center">
            Đơn hàng của bạn đã được thanh toán và đang được xử lý. Cảm ơn bạn đã mua hàng!
        </div>
        <?php
        // THông bo đã thanh toán
        $thong_bao = "Đơn hàng #$ma_don_hang của bạn đã được thanh toán thành công.";
        $stmt = $conn->prepare("INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status) VALUES (?, ?, ?, 'Chua doc')");
        $stmt->bind_param("iis", $ma_khach_hang, $ma_don_hang, $thong_bao);
        $stmt->execute();
    } elseif ($trang_thai == 'DA_HUY') { ?>
        <div class="alert alert-danger text-center">
            Đơn hàng của bạn đã bị hủy.
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center">
            Cảm ơn bạn đã đặt hàng! Vui lòng thanh toán theo hướng dẫn dưới đây.
        </div>

        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <h3>Quét mã QR để thanh toán</h3>
                <?php
                $qr_url = 'https://img.vietqr.io/image/mbbank-0000153686666-compact.jpg?amount=' . $tong_tien .'&addInfo=DH' . $ma_don_hang; ?>
                <img src="<?php echo $qr_url; ?>" alt="QR Code" class="img-fluid mb-3" style="max-width: 300px;">
                <p><div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Chờ thanh toán...</span>
                </div> Trạng thái: Chờ thanh toán....</p>
            </div>
            <div class="col-md-6">
                <h3>Thông tin chuyển khoản</h3>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">Ngân hàng:</th>
                        <td>MBBank</td>
                    </tr>
                    <tr>
                        <th scope="row">Chủ tài khoản:</th>
                        <td>Vũ Đức Đạt</td>
                    </tr>
                    <tr>
                        <th scope="row">Số tài khoản:</th>
                        <td>0000153686666</td>
                    </tr>
                    <tr>
                        <th scope="row">Số tiền:</th>
                        <td><?php echo number_format($tong_tien); ?> VNĐ</td>
                    </tr>
                    <tr>
                        <th scope="row">Nội dung chuyển khoản:</th>
                        <td>DH<?php echo $ma_don_hang; ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="alert alert-warning">
                    <strong>Lưu ý:</strong> Vui lòng ghi đúng nội dung chuyển khoản để hệ thống tự động xác nhận.
                </div>
            </div>
        </div>
    <?php } ?>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Kiểm tra trạng thái thanh toán bằng Ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var trang_thai = '<?php echo $trang_thai; ?>';
        function check_order_status() {
        if (trang_thai !== 'DA_THANH_TOAN' && trang_thai !== 'DA_XAC_NHAN' && trang_thai !== 'DANG_GIAO' && trang_thai !== 'DA_GIAO' && trang_thai !== 'DA_HUY') {
        $.ajax({
        type: "POST",
        data: {order_id: <?php echo $ma_don_hang; ?>},
        url: "check_order_status.php",
        dataType: "json",
        success: function (data) {
        if (data.trang_thai === "DA_THANH_TOAN") {
            // alert("Thanh toán thành công! Đơn hàng của bạn đang được xử lý.");
            $("#modal-title").text("Thông báo");
            $("#modal-body").text("Thanh toán thành công! Đơn hàng của bạn đang được xử lý.");
            $("#statusModal").modal("show");
            $("#statusModal").on('hidden.bs.modal', function () {
            trang_thai = 'DA_THANH_TOAN';
            location.reload();
    });
    } else if (data.trang_thai === "DA_HUY") {
            // alert("Đơn hàng của bạn đã bị hủy.");
            $("#modal-title").text("Thông báo");
            $("#modal-body").text("Đơn hàng của bạn đã bị hủy.");
            $("#statusModal").modal("show");
            $("#statusModal").on('hidden.bs.modal', function () {
            trang_thai = 'DA_HUY';
            location.reload();
    });
    }
    }
    });
    }
    }
        // Kiểm tra trạng thái đơn hàng mỗi 2 giây
        setInterval(check_order_status, 2000);
</script>

<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">
                <!--ajax -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; 2024 BookStore. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a>
        </p>
    </div>
</footer>

</body>
</html>
