<?php
require_once 'DAO/khachhangDAO.php';
require_once 'model/khachhang.php';
require_once 'DAO/JDBC.php';
require_once 'DAO/notificationsDAO.php';
session_start();

class KhachHangController {
    private $khachHangDAO;
    public function __construct() {
        $this->khachHangDAO = new KhachHangDAO();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDangNhap = $_POST['ten_dang_nhap'];
            $matKhau = $_POST['mat_khau'];
            $hoVaTen = $_POST['ho_va_ten'];
            $gioiTinh = $_POST['gioi_tinh'];
            $ngaySinh = $_POST['ngay_sinh'];
            $diaChi = $_POST['dia_chi'];
            $diaChiNhanHang = $_POST['dia_chi_nhan_hang'];
            $soDienThoai = $_POST['so_dien_thoai'];
            $email = $_POST['email'];
            $dangKyNhanBanTin = isset($_POST['dang_ky_nhan_ban_tin']) ? 1 : 0;
            $vaiTro = 'khachhang';
            $gioHang = null;
    
            $khachHang = new khachhang(null, $tenDangNhap, $matKhau, $hoVaTen, 
                $gioiTinh, $ngaySinh, $diaChi, $diaChiNhanHang, $soDienThoai, 
                $email, $dangKyNhanBanTin, $vaiTro, $gioHang);
            $khachHang->setMatKhauMaHoa($matKhau);
            
            if ($this->khachHangDAO->insert($khachHang) > 0) {
                header("Location: loginRouter.php");
                exit();
            } else {
                $_SESSION['error'] = "Đăng ký không thành công!";
                header("Location: view/register.php");
            }
        }
        require '../view/register.php';
    }
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenDangNhap = isset($_POST['ten_dang_nhap']) ? trim($_POST['ten_dang_nhap']) : '';
            $matKhau = isset($_POST['mat_khau']) ? trim($_POST['mat_khau']) : '';
    
            if (empty($tenDangNhap) || empty($matKhau)) {
                $_SESSION['error'] = "Tên đăng nhập và mật khẩu không được để trống!";
                header("Location: view/login.php");
                exit();
            }
    
            try {
                $khachHang = $this->khachHangDAO->findByUsername($tenDangNhap);
                
                if ($khachHang && password_verify($matKhau, $khachHang->getMatKhau())) {
                    // Đặt session cho mã khách hàng
                    $_SESSION['ma_khach_hang'] = $khachHang->getMaKhachHang();
                    $_SESSION['tenDangNhap'] = $khachHang->getTenDangNhap();
                    $_SESSION['vai_tro'] = $khachHang->getVaiTro();
                    
                    header("Location: view/home.php");
                    exit();
                }
    
                $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
                header("Location: view/login.php");
                exit();
                
            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $_SESSION['error'] = "Có lỗi xảy ra trong quá trình đăng nhập!";
                header("Location: view/login.php");
                exit();
            }
        }
        require 'view/login.php';
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: view/home.php");
        exit();
    }
    
}


?>
