<?php
require_once 'JDBC.php';
require_once 'DAOInterface.php';
require_once 'model/donhang.php';

class DonHangDAO implements DAOInterface
{
    public function __construct() {}
    public function selectAll(): array
    {
        $conn = JDBC::getConnection();
        $sql = "SELECT * FROM donhang ORDER BY ngay_dat_hang DESC";
        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        $donHangs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $donHang = new DonHang(
                    $row['ma_don_hang'],
                    $row['ma_khach_hang'],
                    $row['tong'],
                    $row['ngay_dat_hang'],
                    $row['trang_thai'],
                    $row['dia_chi_nhan_hang'],
                    $row['giam_gia']
                );
                $donHangs[] = $donHang;
            }
        }

        JDBC::closeConnection($conn);
        return $donHangs;
    }

   
    public function insert($object): int
    {
        $conn = JDBC::getConnection();
        $sql = "INSERT INTO donhang (ma_khach_hang, tong, ngay_dat_hang, trang_thai, dia_chi_nhan_hang, giam_gia) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "idsisi",
            $object->getMaKhachHang(),
            $object->getTong(),
            $object->getNgayDatHang(),
            $object->getTrangThai(),
            $object->getDiaChiNhanHang(),
            $object->getGiamGia()
        );

        if ($stmt->execute()) {
            $insertedId = $conn->insert_id;
        } else {
            $insertedId = 0;
        }

        $stmt->close();
        JDBC::closeConnection($conn);
        return $insertedId;
    }

    public function update($object): int
    {
        $conn = JDBC::getConnection();
        $sql = "UPDATE donhang SET ma_khach_hang = ?, tong = ?, ngay_dat_hang = ?, trang_thai = ?, dia_chi_nhan_hang = ?, giam_gia = ? WHERE ma_don_hang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "idsisii",
            $object->getMaKhachHang(),
            $object->getTong(),
            $object->getNgayDatHang(),
            $object->getTrangThai(),
            $object->getDiaChiNhanHang(),
            $object->getGiamGia(),
            $object->getMaDonHang()
        );

        $success = $stmt->execute();
        $stmt->close();
        JDBC::closeConnection($conn);
        return $success ? 1 : 0;
    }

    public function delete($maDonHang): int
    {
        $conn = JDBC::getConnection();
        $sql = "DELETE FROM donhang WHERE ma_don_hang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $maDonHang);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }
    public function deleteById($maDonHang)
    {
        $conn = JDBC::getConnection();
        $sql = "DELETE FROM donhang WHERE ma_don_hang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $maDonHang);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }
    public function selectByMaKhachHang($maKhachHang): array
    {
        $conn = JDBC::getConnection();
        $sql = "SELECT * FROM donhang WHERE ma_khach_hang = ?  ORDER BY ngay_dat_hang DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $maKhachHang);
        $stmt->execute();
        $result = $stmt->get_result();

        $donHangs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $donHang = new DonHang(
                    $row['ma_don_hang'],
                    $row['ma_khach_hang'],
                    $row['tong'],
                    $row['ngay_dat_hang'],
                    $row['trang_thai'],
                    $row['dia_chi_nhan_hang'],
                    $row['giam_gia']
                );
                $donHangs[] = $donHang;
            }
        }

        $stmt->close();
        JDBC::closeConnection($conn);
        return $donHangs;
    }
    public function updateTrangThai($maDonHang, $trangThai)
    {
        $conn = JDBC::getConnection();
        $sql = "UPDATE donhang SET trang_thai = ? WHERE ma_don_hang = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $trangThai, $maDonHang);

        if ($stmt->execute()) {
            $stmt->close();
            JDBC::closeConnection($conn);
            return true;
        } else {
            $stmt->close();
            JDBC::closeConnection($conn);
            return false;
        }
    }
    public function selectById($id)
    {
        $conn = JDBC::getConnection();
        $sql = "SELECT * FROM donhang WHERE ma_don_hang = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Không thể chuẩn bị câu lệnh: " . $conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $donHang = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $donHang = new DonHang(
                $row['ma_don_hang'],
                $row['ma_khach_hang'],
                $row['tong'],
                $row['ngay_dat_hang'],
                $row['trang_thai'],
                $row['dia_chi_nhan_hang'],
                $row['giam_gia']
            );
        }

        $stmt->close();
        JDBC::closeConnection($conn);
        return $donHang;
    }

}
