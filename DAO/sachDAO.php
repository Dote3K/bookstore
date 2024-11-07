<?php
require_once  "JDBC.php";
require_once 'DAOInterface.php';
require_once 'model/sach.php';
class sachDAO implements DAOinterface {

    public function selectAll(): array {
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
                $namxuatban= $row['nam_xuat_ban'];
                $mo_ta = $row['mo_ta'];
                $anh_bia = $row['anh_bia'];


                $ketQua[] = new sach($masach ,$tensach, $tacgia ,$ma_nxb, $matheloai, $gia_mua, $gia_ban,$so_luong ,$namxuatban, $mo_ta,$anh_bia );
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($t) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM tacgia WHERE ma_tac_gia = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $t->getMaTacGia());
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $maTacGia = $row['ma_tac_gia'];
                $tenTacGia = $row['ten_tac_gia'];
                $ngaySinh = $row['ngay_sinh'];
                $tieuSu = $row['tieu_su'];
                $ketQua = new TacGia($maTacGia, $tenTacGia, $ngaySinh, $tieuSu);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function insert($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO tacgia (ma_tac_gia, ten_tac_gia, ngay_sinh, tieu_su) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssss", $t->getMaTacGia(), $t->getTenTacGia(), $t->getNgaySinh(), $t->getTieuSu());

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

    public function insertAll(array $arr): int {
        $count = 0;
        foreach ($arr as $tacGia) {
            $count += $this->insert($tacGia);
        }
        return $count;
    }

    public function delete($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM tacgia WHERE ma_tac_gia = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $t->getMaTacGia());

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

    public function deleteAll(array $arr): int {
        $count = 0;
        foreach ($arr as $tacGia) {
            $count += $this->delete($tacGia);
        }
        return $count;
    }

    public function update($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE tacgia SET ten_tac_gia = ?, ngay_sinh = ?, tieu_su = ? WHERE ma_tac_gia = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssss", $t->getTenTacGia(), $t->getNgaySinh(), $t->getTieuSu(), $t->getMaTacGia());

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

    public function checkMaTacGia($maTacGia): bool {
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
}
?>
