<?php
require_once '../checker/kiemtra_login.php';
require '../connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_sach = isset($_POST['ma_sach']) ? (int)$_POST['ma_sach'] : 0;
    $so_luong = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 1;

    if ($ma_sach > 0 && $so_luong > 0) {
        $stmt = $conn->prepare("SELECT ten_sach, gia_ban, anh_bia FROM sach WHERE ma_sach = ? AND so_luong > 0");
        $stmt->bind_param("i", $ma_sach);
        $stmt->execute();
        $result = $stmt->get_result();
        $san_pham = $result->fetch_assoc();

        if ($san_pham) {
            // tạo giỏ hàng nếu chưa cso
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // nếu đãc có sản phẩm trogn giỏ hàng thì +1
            if (isset($_SESSION['cart'][$ma_sach])) {
                $_SESSION['cart'][$ma_sach]['so_luong'] += $so_luong;
            } else {
                // thêm mới sản phẩm vào giỏ hàng
                $_SESSION['cart'][$ma_sach] = [
                    'ten_sach' => $san_pham['ten_sach'],
                    'gia_ban' => $san_pham['gia_ban'],
                    'anh_bia' => $san_pham['anh_bia'],
                    'so_luong' => $so_luong
                ];
            }

            $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng!";
            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart' => $_SESSION['cart']
            ]);
        } else {

            //$_SESSION['error'] = "Sản phẩm không tồn tại hoặc đã hết hàng!";
            echo json_encode([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại hoặc đã hết hàng!'
            ]);
        }

        $stmt->close();
    } else {
        //$_SESSION['error'] = "Dữ liệu không hợp lệ!";
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ!'
        ]);
    }
}

//header('Location: ../index.php');
exit;
?>
