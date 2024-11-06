<?php
  require_once  "JDBC.php";
  require_once 'DAOInterface.php';
class ChiTietDonHangDAO implements DAOinterface {

    public function selectAll(): array {
        $ketQua = [];
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM chitietdonhang";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            echo $sql;
            while ($row = $result->fetch_assoc()) {
                $maChiTiet = $row['ma_chi_tiet_don_hang'];
                $maDonHang = $row['ma_don_hang'];
                $maSach = $row['ma_sach'];
                $soLuong = $row['so_luong'];

                $ketQua[] = new ChiTietDonHang($maChiTiet, $maDonHang, $maSach, $soLuong);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($maChiTiet) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM chitietdonhang WHERE ma_chi_tiet_don_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maChiTiet);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $maDonHang = $row['ma_don_hang'];
                $maSach = $row['ma_sach'];
                $soLuong = $row['so_luong'];
                $ketQua = new ChiTietDonHang($maChiTiet, $maDonHang, $maSach, $soLuong);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function insert($chiTietDonHang): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO chitietdonhang (ma_don_hang, ma_sach, so_luong) VALUES (?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iii", $chiTietDonHang->getMaDonHang(), $chiTietDonHang->getMaSach(), $chiTietDonHang->getSoLuong());

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

    public function delete($maChiTiet): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM chitietdonhang WHERE ma_chi_tiet_don_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maChiTiet);

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

    public function update($chiTietDonHang): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE chitietdonhang SET ma_don_hang = ?, ma_sach = ?, so_luong = ? WHERE ma_chi_tiet_don_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("iiii", $chiTietDonHang->getMaDonHang(), $chiTietDonHang->getMaSach(), $chiTietDonHang->getSoLuong(), $chiTietDonHang->getMaChiTiet());

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
}
?>
