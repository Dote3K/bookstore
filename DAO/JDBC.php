    <?php


    define('DB_HOST', 'localhost');
    define('DB_NAME', 'bookstore');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    class JDBC
    {
        public static function getConnection()
        {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }
            return $conn;
        }

        public static function closeConnection($conn)
        {
            if ($conn !== null) {
                $conn->close();
            }
        }

        public static function printInfo($conn)
        {
            if ($conn !== null) {
                echo "Server info: " . $conn->server_info . "<br>";
                echo "MySQL version: " . $conn->server_version . "<br>";
            }
        }
    }
    ?>