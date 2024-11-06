<?php
  require_once "JDBC.php";
require_once 'DAOInterface.php';
class KhachHangDAO implements DAOinterface {
    
    public function selectAll(): array {
        $ketQua = [];
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM khachhang";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $maKhachHang = $row['ma_khach_hang'];
                $tenDangNhap = $row['ten_dang_nhap'];
                $matKhau = $row['mat_khau'];
                $hoVaTen = $row['ho_va_ten'];
                $gioiTinh = $row['gioi_tinh'];
                $ngaySinh = $row['ngay_sinh'];
                $diaChi = $row['dia_chi'];
                $diaChiNhanHang = $row['dia_chi_nhan_hang'];
                $soDienThoai = $row['so_dien_thoai'];
                $email = $row['email'];
                $dangKyNhanBanTin = $row['dang_ky_nhan_ban_tin'];
                $vaiTro = $row['vai_tro'];
                $gioHang = $row['gio_hang'];

                $ketQua[] = new khachhang($maKhachHang, $tenDangNhap, $matKhau, $hoVaTen, $gioiTinh, $ngaySinh, $diaChi, $diaChiNhanHang, $soDienThoai, $email, $dangKyNhanBanTin, $vaiTro, $gioHang);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($maKhachHang) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM khachhang WHERE ma_khach_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maKhachHang);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $tenDangNhap = $row['ten_dang_nhap'];
                $matKhau = $row['mat_khau'];
                $hoVaTen = $row['ho_va_ten'];
                $gioiTinh = $row['gioi_tinh'];
                $ngaySinh = $row['ngay_sinh'];
                $diaChi = $row['dia_chi'];
                $diaChiNhanHang = $row['dia_chi_nhan_hang'];
                $soDienThoai = $row['so_dien_thoai'];
                $email = $row['email'];
                $dangKyNhanBanTin = $row['dang_ky_nhan_ban_tin'];
                $vaiTro = $row['vai_tro'];
                $gioHang = $row['gio_hang'];

                $ketQua = new khachhang($maKhachHang, $tenDangNhap, $matKhau, $hoVaTen, $gioiTinh, $ngaySinh, $diaChi, $diaChiNhanHang, $soDienThoai, $email, $dangKyNhanBanTin, $vaiTro, $gioHang);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }
    public function findByUsername($tenDangNhap) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();
            $sql = "SELECT * FROM khachhang WHERE ten_dang_nhap = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $tenDangNhap);
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $ketQua = new khachhang(
                    $row['ma_khach_hang'],
                    $row['ten_dang_nhap'],
                    $row['mat_khau'], // Mật khẩu đã được mã hóa từ database
                    $row['ho_va_ten'],
                    $row['gioi_tinh'],
                    $row['ngay_sinh'],
                    $row['dia_chi'],
                    $row['dia_chi_nhan_hang'],
                    $row['so_dien_thoai'],
                    $row['email'],
                    $row['dang_ky_nhan_ban_tin'],
                    $row['vai_tro'],    
                    $row['gio_hang']
                );
            }
            
            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
        
        return $ketQua;
    }

    public function insert($khachHang): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO khachhang (ten_dang_nhap, mat_khau, ho_va_ten, gioi_tinh, ngay_sinh, dia_chi, dia_chi_nhan_hang, so_dien_thoai, email, dang_ky_nhan_ban_tin, vai_tro, gio_hang) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssssssssss", $khachHang->getTenDangNhap(), $khachHang->getMatKhau(), $khachHang->getHoVaTen(), $khachHang->getGioiTinh(), $khachHang->getNgaySinh(), $khachHang->getDiaChi(), $khachHang->getDiaChiNhanHang(), $khachHang->getSoDienThoai(), $khachHang->getEmail(), $khachHang->getDangKyNhanBanTin(), $khachHang->getVaiTro(), $khachHang->getGioHang());

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

    public function delete($maKhachHang): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM khachhang WHERE ma_khach_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maKhachHang);

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

    public function update($khachHang): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE khachhang SET ten_dang_nhap = ?, mat_khau = ?, ho_va_ten = ?, gioi_tinh = ?, ngay_sinh = ?, dia_chi = ?, dia_chi_nhan_hang = ?, so_dien_thoai = ?, email = ?, dang_ky_nhan_ban_tin = ?, vai_tro = ?, gio_hang = ? WHERE ma_khach_hang = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssssssssssi", $khachHang->getTenDangNhap(), $khachHang->getMatKhau(), $khachHang->getHoVaTen(), $khachHang->getGioiTinh(), $khachHang->getNgaySinh(), $khachHang->getDiaChi(), $khachHang->getDiaChiNhanHang(), $khachHang->getSoDienThoai(), $khachHang->getEmail(), $khachHang->getDangKyNhanBanTin(), $khachHang->getVaiTro(), $khachHang->getGioHang(), $khachHang->getMaKhachHang());

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
