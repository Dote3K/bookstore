<?php

class khachhang {
    private $maKhachHang; // ma_khach_hang
    private $tenDangNhap; // ten_dang_nhap
    private $matKhau; // mat_khau
    private $hoVaTen; // ho_va_ten
    private $gioiTinh; // gioi_tinh
    private $ngaySinh; // ngay_sinh
    private $diaChi; // dia_chi
    private $diaChiNhanHang; // dia_chi_nhan_hang
    private $soDienThoai; // so_dien_thoai
    private $email; // email
    private $dangKyNhanBanTin; // dang_ky_nhan_ban_tin
    private $vaiTro; // vai_tro
    private $gioHang; // gio_hang

    // Constructor

    public function __construct($maKhachHang, $tenDangNhap, $matKhau, $hoVaTen,
                          $gioiTinh, $ngaySinh, $diaChi,
                          $diaChiNhanHang, $soDienThoai,
                          $email, $dangKyNhanBanTin, $vaiTro,
                          $gioHang) {
    $this->maKhachHang = $maKhachHang;
    $this->tenDangNhap = $tenDangNhap;
    $this->matKhau = $matKhau; 
    $this->hoVaTen = $hoVaTen;
    $this->gioiTinh = $gioiTinh;
    $this->ngaySinh = $ngaySinh;
    $this->diaChi = $diaChi;
    $this->diaChiNhanHang = $diaChiNhanHang;
    $this->soDienThoai = $soDienThoai;
    $this->email = $email;
    $this->dangKyNhanBanTin = $dangKyNhanBanTin;
    $this->vaiTro = $vaiTro;
    $this->gioHang = $gioHang;
}


    public function getMaKhachHang() {
        return $this->maKhachHang;
    }

    public function setMaKhachHang($maKhachHang) {
        $this->maKhachHang = $maKhachHang;
    }


    public function getTenDangNhap() {
        return $this->tenDangNhap;
    }

    public function setTenDangNhap($tenDangNhap) {
        $this->tenDangNhap = $tenDangNhap;
    }

    public function setMatKhauMaHoa($matKhau) {
        $this->matKhau = password_hash($matKhau, PASSWORD_BCRYPT);
    }

    public function getMatKhau() {
        return $this->matKhau;
    }

    public function getHoVaTen() {
        return $this->hoVaTen;
    }

    public function setHoVaTen($hoVaTen) {
        $this->hoVaTen = $hoVaTen;
    }


    public function getGioiTinh() {
        return $this->gioiTinh;
    }

    public function setGioiTinh($gioiTinh) {
        $this->gioiTinh = $gioiTinh;
    }


    public function getNgaySinh() {
        return $this->ngaySinh;
    }

    public function setNgaySinh($ngaySinh) {
        $this->ngaySinh = $ngaySinh;
    }

    public function getDiaChi() {
        return $this->diaChi;
    }

    public function setDiaChi($diaChi) {
        $this->diaChi = $diaChi;
    }


    public function getDiaChiNhanHang() {
        return $this->diaChiNhanHang;
    }

    public function setDiaChiNhanHang($diaChiNhanHang) {
        $this->diaChiNhanHang = $diaChiNhanHang;
    }


    public function getSoDienThoai() {
        return $this->soDienThoai;
    }

    public function setSoDienThoai($soDienThoai) {
        $this->soDienThoai = $soDienThoai;
    }


    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }


    public function getDangKyNhanBanTin() {
        return $this->dangKyNhanBanTin;
    }

    public function setDangKyNhanBanTin($dangKyNhanBanTin) {
        $this->dangKyNhanBanTin = $dangKyNhanBanTin;
    }

    public function getVaiTro() {
        return $this->vaiTro;
    }

    public function setVaiTro($vaiTro) {
        $this->vaiTro = $vaiTro;
    }

    public function getGioHang() {
        return $this->gioHang;
    }

    public function setGioHang($gioHang) {
        $this->gioHang = $gioHang;
    }
}
?>
