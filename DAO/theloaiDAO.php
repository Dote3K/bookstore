<?php
require_once 'DAOInterface.php';
require_once  "JDBC.php";
require_once 'theloai.php';
class TheLoaiDAO implements DAOinterface {

    // Select all records
    public function selectAll(): array {
        $ketQua = [];
        try {
            // Step 1: Connect to the database
            $con = JDBC::getConnection();

            // Step 2: Prepare SQL statement
            $sql = "SELECT * FROM theloai";
            $stmt = $con->prepare($sql);

            // Step 3: Execute SQL query
            $stmt->execute();
            $result = $stmt->get_result(); // Dùng get_result() để lấy kết quả

            // Step 4: Loop through the result set
            while ($row = $result->fetch_assoc()) {
                $maTheLoai = $row['ma_the_loai'];
                $theLoai = $row['the_loai'];

                $ketQua[] = new TheLoai($maTheLoai, $theLoai);
            }

            // Step 5: Close the connection
            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    // Select a record by ID
    public function selectById($t) {
        $ketQua = null;
        try {
            $con = JDBC::getConnection();

            $sql = "SELECT * FROM theloai WHERE ma_the_loai = ?";
            $stmt = $con->prepare($sql);

            // Set parameter and execute
            $stmt->bind_param("s", $t->getMaTheLoai());
            $stmt->execute();

            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $maTheLoai = $row['ma_the_loai'];
                $theLoai = $row['the_loai'];
                $ketQua = new TheLoai($maTheLoai, $theLoai);
            }

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    // Insert a new record
    public function insert($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "INSERT INTO theloai (ma_the_loai, the_loai) VALUES (?, ?)";
            $stmt = $con->prepare($sql);

            // Bind values
            $stmt->bind_param("ss", $t->getMaTheLoai(), $t->getTheLoai());

            // Execute the query
            $ketQua = $stmt->execute();

            echo "Executed: $sql\n";
            echo "Rows affected: " . $stmt->affected_rows . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    // Insert multiple records
    public function insertAll(array $arr): int {
        $count = 0;
        foreach ($arr as $theLoai) {
            $count += $this->insert($theLoai);
        }
        return $count;
    }

    // Delete a record by ID
    public function delete($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "DELETE FROM theloai WHERE ma_the_loai = ?";
            $stmt = $con->prepare($sql);

            // Bind value
            $stmt->bind_param("s", $t->getMaTheLoai());

            // Execute the query
            $ketQua = $stmt->execute();

            echo "Executed: $sql\n";
            echo "Rows affected: " . $stmt->affected_rows . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }

    // Delete multiple records
    public function deleteAll(array $arr): int {
        $count = 0;
        foreach ($arr as $theLoai) {
            $count += $this->delete($theLoai);
        }
        return $count;
    }

    // Update a record
    public function update($t): int {
        $ketQua = 0;
        try {
            $con = JDBC::getConnection();

            $sql = "UPDATE theloai SET the_loai = ? WHERE ma_the_loai = ?";
            $stmt = $con->prepare($sql);

            // Bind values
            $stmt->bind_param("ss", $t->getTheLoai(), $t->getMaTheLoai());

            // Execute the query
            $ketQua = $stmt->execute();

            echo "Executed: $sql\n";
            echo "Rows affected: " . $stmt->affected_rows . "\n";

            JDBC::closeConnection($con);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $ketQua;
    }
}
?>