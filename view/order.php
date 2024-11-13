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
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Thanh toán đơn hàng #<?php echo $ma_don_hang; ?></title>
    <!-- Thêm CSS và JS cần thiết -->
</head>
<body>
<?php include 'header.php'; ?>

<div class="container my-5">
    <h1 class="text-center">Thanh toán đơn hàng #<?php echo $ma_don_hang; ?></h1>

    <?php if ($trang_thai == 'DA_THANH_TOAN' || $trang_thai == 'DA_XAC_NHAN' || $trang_thai == 'DANG_GIAO' || $trang_thai == 'DA_GIAO') { ?>
        <p class="text-center text-success">Đơn hàng của bạn đã được thanh toán và đang được xử lý. Cảm ơn bạn đã mua hàng!</p>
    <?php } elseif ($trang_thai == 'DA_HUY') { ?>
        <p class="text-center text-danger">Đơn hàng của bạn đã bị hủy.</p>
    <?php } else { ?>
        <p class="text-center">Cảm ơn bạn đã đặt hàng! Vui lòng thanh toán theo hướng dẫn dưới đây.</p>

        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <h3>Quét mã QR để thanh toán</h3>
                <?php
                // Tạo URL QR code

                $qr_url = 'https://img.vietqr.io/image/mbbank-0000153686666-compact.jpg?amount=' . $tong_tien .'&addInfo=DH' . $ma_don_hang; ?>
                <img src="<?php echo $qr_url; ?>" alt="QR Code" class="img-fluid">
                <p>Trạng thái: <span id="payment-status">Chờ thanh toán...</span></p>
            </div>
            <div class="col-md-6">
                <h3>Thông tin chuyển khoản</h3>
                <table class="table">
                    <tr>
                        <th>Ngân hàng:</th>
                        <td>MBBank</td>
                    </tr>
                    <tr>
                        <th>Chủ tài khoản:</th>
                        <td>Vũ Đức Đạt</td>
                    </tr>
                    <tr>
                        <th>Số tài khoản:</th>
                        <td>0000153686666</td>
                    </tr>
                    <tr>
                        <th>Số tiền:</th>
                        <td><?php echo number_format($tong_tien); ?>đ</td>
                    </tr>
                    <tr>
                        <th>Nội dung chuyển khoản:</th>
                        <td>DH<?php echo $ma_don_hang; ?></td>
                    </tr>
                </table>
                <p>Lưu ý: Vui lòng ghi đúng nội dung chuyển khoản để hệ thống tự động xác nhận.</p>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Kiểm tra trạng thái thanh toán bằng Ajax -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var trang_thai = '<?php echo $trang_thai; ?>';

    function check_order_status() {
        if (trang_thai != 'DA_THANH_TOAN' && trang_thai != 'DA_XAC_NHAN' && trang_thai != 'DANG_GIAO' && trang_thai != 'DA_GIAO' && trang_thai != 'DA_HUY') {
            $.ajax({
                type: "POST",
                data: {order_id: <?php echo $ma_don_hang; ?>},
                url: "check_order_status.php",
                dataType: "json",
                success: function (data) {
                    if (data.trang_thai === "DA_THANH_TOAN") {
                        $("#payment-status").text("Đã thanh toán");
                        trang_thai = 'DA_THANH_TOAN';
                        alert("Thanh toán thành công! Đơn hàng của bạn đang được xử lý.");
                        // Bạn có thể chuyển hướng hoặc cập nhật giao diện tại đây
                        location.reload();
                    } else if (data.trang_thai === "DA_HUY") {
                        $("#payment-status").text("Đơn hàng đã bị hủy");
                        trang_thai = 'DA_HUY';
                        alert("Đơn hàng của bạn đã bị hủy.");
                        location.reload();
                    }
                }
            });
        }
    }

    // Kiểm tra trạng thái đơn hàng mỗi 5 giây
    setInterval(check_order_status, 5000);
</script>

</body>
</html>
