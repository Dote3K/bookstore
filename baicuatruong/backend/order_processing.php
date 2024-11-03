<?php
require_once 'db.php';

// Xử lý đơn hàng
function processOrder($db, $customerId, $cartItems, $totalCost)
{
    try {
        // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
        $db->beginTransaction();

        // Tạo đơn hàng mới
        $query = 'INSERT INTO donhang (ma_khach_hang, tong, trang_thai) VALUES (:customerId, :totalCost, "Đang chờ")';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':customerId', $customerId);
        $stmt->bindValue(':totalCost', $totalCost);
        $stmt->execute();

        // Lấy ID của bản ghi vừa được thêm vào sau khi insert
        $orderId = $db->lastInsertId();

        // Chuẩn bị câu truy vấn cho chi tiết đơn hàng
        $query = 'INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong, gia) VALUES (:orderId, :bookId, :quantity, :price)';
        $stmt = $db->prepare($query);

        // Thêm từng sản phẩm vào chi tiết đơn hàng
        foreach ($cartItems as $item) {
            // Kiểm tra tính hợp lệ của từng sản phẩm
            if (isset($item['ma_sach'], $item['so_luong'], $item['gia'])) {
                $stmt->bindValue(':orderId', $orderId);
                $stmt->bindValue(':bookId', $item['ma_sach']);
                $stmt->bindValue(':quantity', $item['so_luong']);
                $stmt->bindValue(':price', $item['gia']);
                $stmt->execute();
            } else {
                throw new Exception("Thông tin sản phẩm không đầy đủ.");
            }
        }

        // Xác nhận transaction
        $db->commit();
        return $orderId;
    } catch (Exception $e) {
        // Hủy bỏ transaction nếu có lỗi
        $db->rollBack();
        echo "Lỗi khi xử lý đơn hàng: " . $e->getMessage();
        return false;
    }
}
