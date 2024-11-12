<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'DAO/donhangDAO.php';
require_once 'DAO/notificationsDAO.php';
require_once 'model/TrangThaiDonHang.php';
require_once 'model/notifications.php';
require_once 'model/enumNotification.php';
class DonHangController
{
    private $donHangDAO;

    public function __construct()
    {
        $this->donHangDAO = new DonHangDAO();
    }

    public function list()
    {

        $donHangs = $this->donHangDAO->selectAll();

        require  'view/listOrderAll.php';
        include 'admin/sidebar.php';
    }
    public function listOrderUser()
    {
        session_start();

        if (!isset($_SESSION['ma_khach_hang'])) {
            echo "Bạn cần đăng nhập để xem danh sách đơn hàng.";
            return;
        }
        $maKhachHang = $_SESSION['ma_khach_hang'];
        $donHangs = $this->donHangDAO->selectByMaKhachHang($maKhachHang);

        require 'view/listOrderUser.php';
    }


    public function delete()
    {
        session_start();

        if (!isset($_POST['maDonHang'])) {
            echo "Mã đơn hàng không tồn tại.";
            return;
        }
        $maDonHang = $_POST['maDonHang'];
        $result = $this->donHangDAO->deleteById($maDonHang);

        if ($result) {
            echo "Đơn hàng đã được xóa thành công.";
        } else {
            echo "Xóa đơn hàng không thành công.";
        }
        header("Location: listOrderUserRouter.php");
        exit();
        require '../view/listOrderUser.php';
    }


    public function updateStatus()
    {
        session_start();

        if (!isset($_POST['maDonHang']) || !isset($_POST['trangThai'])) {
            echo "Thông tin không hợp lệ.";
            return;
        }


        $maDonHang = $_POST['maDonHang'];
        $trangThaiMoi = TrangThaiDonHang::from($_POST['trangThai']);

        $donHang = $this->donHangDAO->selectById($maDonHang);
        $trangThaiHienTai = $donHang->getTrangThai();

        $allowedTransitions = [
            TrangThaiDonHang::DANG_CHO->value => TrangThaiDonHang::DA_XAC_NHAN->value,
            TrangThaiDonHang::DA_XAC_NHAN->value => TrangThaiDonHang::DANG_GIAO->value,
            TrangThaiDonHang::DANG_GIAO->value => TrangThaiDonHang::DA_GIAO->value,
        ];

        if (isset($allowedTransitions[$trangThaiHienTai]) && $allowedTransitions[$trangThaiHienTai] === $trangThaiMoi->value) {
            $result = $this->donHangDAO->updateTrangThai($maDonHang, $trangThaiMoi->value);
            if ($result) {
                $message = "Đơn hàng có mã $maDonHang đang trong trạng thái $trangThaiMoi->value ";
                $notification = new Notification(
                    null,
                    $donHang->getMaKhachHang(),
                    $maDonHang,
                    $message,
                    EnumNotification::UNREAD
                );
                $notificationDAO = new NotificationDAO();
                $notificationResult = $notificationDAO->insert($notification);
                echo $notificationResult ? "Cập nhật trạng thái và gửi thông báo thành công." : "Cập nhật trạng thái thành công nhưng gửi thông báo không thành công.";
            }
        } else {
            echo "Không thể chuyển trạng thái từ '$trangThaiHienTai' sang '$trangThaiMoi->value'.";
        }

        header("Location: DonHangRouter.php?action=list");
        exit();
        require 'view/listOrderAll.php';
    }
    
}
