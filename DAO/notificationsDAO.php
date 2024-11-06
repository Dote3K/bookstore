<?php
require_once "JDBC.php";
require_once 'DAOInterface.php';
require_once 'model/notifications.php';
require_once 'model/enumNotification.php';
class NotificationDAO implements DAOinterface
{

    public function selectAll(): array
    {
        $ketQua = [];
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM notifications";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $maKhachHang = $row['ma_khach_hang'];
                $maDonHang = $row['ma_don_hang'];
                $message = $row['message'];
                $status = $row['status'];
                $createdAt = $row['created_at'];

                $ketQua[] = new Notification($id, $maKhachHang, $maDonHang, $message, $status, $createdAt);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($maKhachHang): array
    {

        $con = JDBC::getConnection();

        $sql = "SELECT * FROM notifications WHERE ma_khach_hang = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $maKhachHang);
        $stmt->execute();
        $result = $stmt->get_result();

        $notifications = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notification = new Notification(
                    $row['id'],
                    $row['ma_khach_hang'],
                    $row['ma_don_hang'],
                    $row['message'],
                    $row['status'],
                    $row['created_at']
                );
                $notifications[] = $notification;
            }
        }

        $stmt->close();
        JDBC::closeConnection($con);

        return $notifications;
    }

    public function insert($notification): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO notifications (ma_khach_hang, ma_don_hang, message, status, created_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $maKhachHang = $notification->getMaKhachHang();
            $maDonHang = $notification->getMaDonHang();
            $message = $notification->getMessage();
            $status = $notification->getStatus()->getValue();
            $createdAt = $notification->getCreatedAt();
            $stmt->bind_param("iissi", $maKhachHang, $maDonHang, $message, $status, $createdAt);
            $stmt->execute();
            $ketQua = $stmt->affected_rows;

            echo "Executed: $sql\n";
            echo "Rows affected: " . $ketQua . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }


    public function update($notification): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE notifications SET ma_khach_hang = ?, ma_don_hang = ?, message = ?, status = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iissi", $notification->getMaKhachHang(), $notification->getMaDonHang(), $notification->getMessage(), $notification->getStatus(), $notification->getId());

            $stmt->execute();
            $ketQua = $stmt->affected_rows;

            echo "Executed: $sql\n";
            echo "Rows affected: " . $ketQua . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }
    public function delete($id): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM notifications WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $id);

            $stmt->execute();
            $ketQua = $stmt->affected_rows;

            echo "Executed: $sql\n";
            echo "Rows affected: " . $ketQua . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }
    public function getUnreadNotificationCount($maKhachHang)
{
    $count = 0;
    try {
        $con = JDBC::getConnection();
        $sql = "SELECT COUNT(*) as count FROM notifications WHERE ma_khach_hang = ? AND status = ?";
        $stmt = $con->prepare($sql);
        $status = enumNotification::UNREAD->getValue();
        $stmt->bind_param("is", $maKhachHang, $status);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $count = $row['count'];
        }

        JDBC::closeConnection($con);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }

    return $count;
}


    public function markAsRead($maKhachHang)
    {
        try {
            $con = JDBC::getConnection();
            $sql = "UPDATE notifications SET status = ? WHERE ma_khach_hang = ?";
            $stmt = $con->prepare($sql);
            $status = EnumNotification::READ->getValue();
            $stmt->bind_param("si", $status, $maKhachHang);
            $stmt->execute();

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}
