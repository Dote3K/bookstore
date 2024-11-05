<?php
require_once '../../connect.php';

// Xử lý đơn hàng
function processOrder($conn, $maKhachHang, $gioHang, $tongTien)
{
    // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
    $conn->autocommit(false);

    try {
        // Tạo đơn hàng mới
        $query = 'INSERT INTO donhang (ma_khach_hang, tong, trang_thai) VALUES (?, ?, "Đang chờ")';
        $stmt = $conn->prepare($query);
        $stmt->bind_param("id", $maKhachHang, $tongTien); // i: int, d: double
        $stmt->execute();

        // Lấy ID của bản ghi vừa được thêm vào sau khi insert
        $maDonHang = $conn->insert_id;

        // Chuẩn bị câu truy vấn cho chi tiết đơn hàng
        $query = 'INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong, gia) VALUES (?, ?, ?, ?)';
        $stmt = $conn->prepare($query);

        // Thêm từng sản phẩm vào chi tiết đơn hàng
        foreach ($gioHang as $sanPham) {
            // Kiểm tra tính hợp lệ của từng sản phẩm
            if (isset($sanPham['ma_sach'], $sanPham['so_luong'], $sanPham['gia'])) {
                $stmt->bind_param("iiid", $maDonHang, $sanPham['ma_sach'], $sanPham['so_luong'], $sanPham['gia']);
                $stmt->execute();
            } else {
                throw new Exception("Thông tin sản phẩm không đầy đủ.");
            }
        }

        // Xác nhận transaction
        $conn->commit();
        return $maDonHang;
    } catch (Exception $e) {
        //Hủy transacion nếu có lỗi
        $conn->rollback();
        echo "Lỗi khi xử lý đơn hàng: " . $e->getMessage();
        return false;
    } finally {
        // Bật lại autocommit
        $conn->autocommit(true);
    }
}
