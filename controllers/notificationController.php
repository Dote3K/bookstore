<?php
require_once 'DAO/JDBC.php';
require_once 'DAO/notificationsDAO.php';
require_once 'model/notifications.php';

class notificationController
{
    private $notificationsDAO;
    public function __construct()
    {
        $this->notificationsDAO = new NotificationDAO();
    }
    public function notificationUser()
    {
        session_start();
        if (!isset($_SESSION['ma_khach_hang'])) {
            echo "Bạn cần đăng nhập để xem danh sách thông báo.";
            return;
        }
        $maKhachHang = $_SESSION['ma_khach_hang'];
        $notifications = $this->notificationsDAO->selectById($maKhachHang);
        $this->notificationsDAO->markAsRead($maKhachHang);

        require 'view/listNotification.php';
    }

    public function getUnreadNotifications()
    {
        session_start();
        header('Content-Type: application/json');

        if (isset($_SESSION['ma_khach_hang'])) {
            $maKhachHang = $_SESSION['ma_khach_hang'];
            $unreadCount = $this->notificationsDAO->getUnreadNotificationCount($maKhachHang);
            $response = ['count' => $unreadCount];
            echo json_encode($response);
        } else {
            echo json_encode(['count' => 0]);
        }
    }
}
