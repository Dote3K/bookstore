    <?php
    class JDBC{
        public static function getConnection(){
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bookstore";
            $conn = new mysqli($servername,$username,$password,$dbname);
            if($conn ->connect_error){
                die("kết nối thất bại".$conn ->connect_error);
            }
            return $conn;
        }
        public static function closeConnection($conn) {
            if ($conn != null) {
                $conn->close();
            }
        }

        public static function printInfo($conn) {
            if ($conn != null) {
                echo "Tên cơ sở dữ liệu: " . $conn->server_info . "<br>";
                echo "Phiên bản máy chủ MySQL: " . $conn->server_version . "<br>";
            }
        }
    }
    ?>