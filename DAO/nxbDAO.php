<?php
  require_once  "JDBC.php";
require_once 'DAOInterface.php';
class NhaXuatBanDAO implements DAOinterface {

    public function selectAll(): array {
        $ketQua = [];
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM nxb";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $maNxb = $row['ma_nxb'];
                $ten = $row['ten'];
                $diaChi = $row['dia_chi'];
                $sdt = $row['sdt'];
                $email = $row['email'];

                $ketQua[] = new NhaXuatBan($maNxb, $ten, $diaChi, $sdt, $email);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function selectById($maNxb) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM nxb WHERE ma_nxb = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maNxb);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $ten = $row['ten'];
                $diaChi = $row['dia_chi'];
                $sdt = $row['sdt'];
                $email = $row['email'];
                $ketQua = new NhaXuatBan($maNxb, $ten, $diaChi, $sdt, $email);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    public function insert($nhaXuatBan): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO nxb (ten, dia_chi, sdt, email) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssss", $nhaXuatBan->getTen(), $nhaXuatBan->getDiaChi(), $nhaXuatBan->getSdt(), $nhaXuatBan->getEmail());

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

    public function delete($maNxb): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM nxb WHERE ma_nxb = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $maNxb);

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

    public function update($nhaXuatBan): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE nxb SET ten = ?, dia_chi = ?, sdt = ?, email = ? WHERE ma_nxb = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssi", $nhaXuatBan->getTen(), $nhaXuatBan->getDiaChi(), $nhaXuatBan->getSdt(), $nhaXuatBan->getEmail(), $nhaXuatBan->getMaNxb());

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