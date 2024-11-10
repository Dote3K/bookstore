<?php
require_once  "JDBC.php";
require_once 'DAOInterface.php';
require_once __DIR__ . '/../model/sach.php';
class sachDAO implements DAOinterface
{

    public function selectAll(): array
    {
        $ketQua = [];
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM sach";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $masach = $row['ma_sach'];
                $tensach = $row['ten_sach'];
                $tacgia = $row['ma_tac_gia'];
                $ma_nxb = $row['ma_nxb'];
                $matheloai = $row['ma_the_loai'];
                $gia_mua = $row['gia_mua'];
                $gia_ban = $row['gia_ban'];
                $so_luong = $row['so_luong'];
                $namxuatban = $row['nam_xuat_ban'];
                $mo_ta = $row['mo_ta'];
                $anh_bia = $row['anh_bia'];


                $ketQua[] = new sach($masach, $tensach, $tacgia, $ma_nxb, $matheloai, $gia_mua, $gia_ban, $so_luong, $namxuatban, $mo_ta, $anh_bia);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($maSach)
    {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM sach WHERE ma_sach = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maSach);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $ketQua = new sach(
                    $row['ma_sach'],
                    $row['ten_sach'],
                    $row['ma_tac_gia'],
                    $row['ma_nxb'],
                    $row['ma_the_loai'],
                    $row['gia_mua'],
                    $row['gia_ban'],
                    $row['so_luong'],
                    $row['nam_xuat_ban'],
                    $row['mo_ta'],
                    $row['anh_bia']
                );
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function insert($sach): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();
            $sql = "INSERT INTO sach (ma_sach, ten_sach, ma_tac_gia, ma_nxb, ma_the_loai, gia_mua, gia_ban, so_luong, nam_xuat_ban, mo_ta, anh_bia)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "issiiiiiiss",
                $sach->getMaSach(),
                $sach->getTenSach(),
                $sach->getMaTacGia(),
                $sach->getMaNXB(),
                $sach->getMaTheLoai(),
                $sach->getGiaMua(),
                $sach->getGiaBan(),
                $sach->getSoLuong(),
                $sach->getNamXuatBan(),
                $sach->getMoTa(),
                $sach->getAnhBia()
            );

            $stmt->execute();
            $ketQua = $stmt->affected_rows;
            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function insertAll(array $arr): int
    {
        $count = 0;
        foreach ($arr as $sach) {
            $count += $this->insert($sach);
        }
        return $count;
    }

    public function delete($maSach): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();
            $sql = "DELETE FROM sach WHERE ma_sach = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maSach);
            $stmt->execute();
            $ketQua = $stmt->affected_rows;
            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function deleteAll(array $arr): int
    {
        $count = 0;
        foreach ($arr as $sach) {
            $count += $this->delete($sach);
        }
        return $count;
    }

    public function update($sach): int
    {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();
            $sql = "UPDATE sach SET ten_sach = ?, ma_tac_gia = ?, ma_nxb = ?, ma_the_loai = ?, gia_mua = ?, gia_ban = ?, so_luong = ?, nam_xuat_ban = ?, mo_ta = ?, anh_bia = ?
                    WHERE ma_sach = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param(
                "ssiiiiiissi",
                $sach->getTenSach(),
                $sach->getMaTacGia(),
                $sach->getMaNXB(),
                $sach->getMaTheLoai(),
                $sach->getGiaMua(),
                $sach->getGiaBan(),
                $sach->getSoLuong(),
                $sach->getNamXuatBan(),
                $sach->getMoTa(),
                $sach->getAnhBia(),
                $sach->getMaSach()
            );

            $stmt->execute();
            $ketQua = $stmt->affected_rows;
            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function checkMaTacGia($maTacGia): bool
    {
        $ketQua = false;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM tacgia WHERE ma_tac_gia = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $maTacGia);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $ketQua = true;
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function timKiemSach($tukhoa)
    {
        $ketqua = [];
        try {
            $con = JDBC::getConnection();
            $sql = "SELECT sach.*, tacgia.ten AS ten_tac_gia
        FROM sach 
        JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
        WHERE sach.ten_sach LIKE ? OR tacgia.ten LIKE ?";

            $stmt = $con->prepare($sql);
            $keyword = "%$tukhoa%";
            $stmt->bind_param("ss", $keyword, $keyword);
            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()) {
                $ketqua[] = $row;
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $ketqua;
    }
    public function getBookById($maSach) {
        // Kết nối với cơ sở dữ liệu (đảm bảo đã có kết nối từ DBUtil.php hoặc nơi nào đó)
        $conn = JDBC::getConnection();
        $sql = "SELECT sach.*, tacgia.ten AS ten_tacgia, theloai.the_loai, nxb.ten AS ten_nxb
        FROM sach
        JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
        JOIN theloai ON sach.ma_the_loai = theloai.ma_the_loai
        JOIN nxb ON sach.ma_nxb = nxb.ma_nxb
        WHERE sach.ma_sach = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $maSach); // Binds the ma_sach as an integer parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về thông tin sách dưới dạng mảng
        } else {
            return null; // Nếu không tìm thấy sách, trả về null
        }
    }
}