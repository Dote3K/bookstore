
<?php
/*class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "bookstore";

    public function connect() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        return $conn;
    }
}*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

