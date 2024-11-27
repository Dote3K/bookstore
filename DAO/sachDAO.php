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

            $sql = "SELECT sach.*, tacgia.ten AS ten_tac_gia, theloai.the_loai, nxb.ten AS ten_nxb
        FROM sach
        JOIN tacgia ON sach.ma_tac_gia = tacgia.ma_tac_gia
        JOIN theloai ON sach.ma_the_loai = theloai.ma_the_loai
        JOIN nxb ON sach.ma_nxb = nxb.ma_nxb
        WHERE sach.so_luong > 0";
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
                $ten_tac_gia = $row['ten_tac_gia'];
                $ten_nxb = $row['ten_nxb'];
                $the_loai = $row['the_loai'];


                $ketQua[] = new sach($masach, $tensach, $tacgia, $ma_nxb, $matheloai, $gia_mua, $gia_ban, $so_luong, $namxuatban, $mo_ta, $anh_bia, $ten_tac_gia, $ten_nxb, $the_loai);
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
                    $row['anh_bia'],
                    $row['ten_tac_gia'],
                    $row['ten_nxb'],
                    $row['the_loai']
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

   
    public function getBookById($maSach)
    {
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
    public function selectByPage($start, $end)
    {
        $conn = JDBC::getConnection();
        $sql = "SELECT * from sach ORDER BY ma_sach LIMIT ?,?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $start, $end);
        $stmt->execute();
        $result = $stmt->get_result();

        $sachs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sach = new sach(
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
                $sachs[] = $sach;
            }
        }
        $stmt->close();
        JDBC::closeConnection($conn);
        return $sachs;
    }
    public function getTotalBook()
    {
        $total = 0;
        $conn = JDBC::getConnection();
        $sql = "SELECT COUNT(*) as total FROM sach";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total = $row['total']; 
        }
    
        $stmt->close();
        JDBC::closeConnection($conn);
        return $total; 
    }
    public function searchBooks($keyword, $start = 0, $limit = 12) {
    $conn = JDBC::getConnection();
    $sql = "
        SELECT 
            s.ma_sach,
            s.ten_sach, 
            s.anh_bia,
            s.gia_ban,
            tg.ten AS ten_tac_gia, 
            tl.the_loai 
        FROM sach s
        JOIN tacgia tg ON s.ma_tac_gia = tg.ma_tac_gia
        JOIN theloai tl ON s.ma_the_loai = tl.ma_the_loai
        WHERE 
            s.ten_sach LIKE ? OR 
            tg.ten LIKE ? OR 
            tl.the_loai LIKE ?
        LIMIT ?, ?
    ";

    try {
        $stmt = $conn->prepare($sql);
        
        $searchKeyword = "%" . $keyword . "%";
        $stmt->bind_param("sssii", $searchKeyword, $searchKeyword, $searchKeyword, $start, $limit);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        $books = [];
        
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        
        $stmt->close();
        $conn->close();
        
        return $books;
    } catch (Exception $e) {
        error_log("Search Books Error: " . $e->getMessage());
        return [];
    }
}
}
