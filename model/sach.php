<?php
class sach {
    private $maSanPham;
    private $tenSanPham;
    private $tacGia;
    private $nhaXuatBan;
    private $namXuatBan;
    private $giamua;
    private $giaBan;
    private $soLuong;
    private $theLoai;
    private $moTa;
    private $themAnh;
    private $ten_tac_gia;
    private $ten_nxb;
    private $the_loai;


    // Constructor
    public function __construct(
        $maSanPham,
        $tenSanPham,
        $ten_tac_gia,
        $ten_nxb,
        $the_loai,
        $giamua,
        $giaBan,
        $soLuong,
        $namXuatBan,
        $moTa,
        $themAnh,
    ) {
        $this->maSanPham = $maSanPham;
        $this->tenSanPham = $tenSanPham;
        $this->ten_tac_gia = $ten_tac_gia;
        $this->ten_nxb = $ten_nxb;
        $this->the_loai = $the_loai;
        $this->giamua = $giamua;
        $this->giaBan = $giaBan;
        $this->soLuong = $soLuong;
        $this->namXuatBan = $namXuatBan;
        $this->moTa = $moTa;
        $this->themAnh = $themAnh;
    }

    // Getter và Setter
    public function getMaSanPham() {
        return $this->maSanPham;
    }

    public function setMaSanPham($maSanPham) {
        $this->maSanPham = $maSanPham;
    }

    public function getTenSanPham() {
        return $this->tenSanPham;
    }

    public function setTenSanPham($tenSanPham) {
        $this->tenSanPham = $tenSanPham;
    }

    public function getTacGia() {
        return $this->tacGia;
    }

    public function setTacGia($tacGia) {
        $this->tacGia = $tacGia;
    }

    public function getNhaXuatBan() {
        return $this->nhaXuatBan;
    }

    public function setNhaXuatBan($nhaXuatBan) {
        $this->nhaXuatBan = $nhaXuatBan;
    }

    public function getNamXuatBan() {
        return $this->namXuatBan;
    }

    public function setNamXuatBan($namXuatBan) {
        $this->namXuatBan = $namXuatBan;
    }

    public function getMua() {
        return $this->giamua;
    }

    public function setGiaGoc($giamua) {
        $this->giamua = $giamua;
    }

    public function getGiaBan() {
        return $this->giaBan;
    }

    public function setGiaBan($giaBan) {
        $this->giaBan = $giaBan;
    }

    public function getSoLuong() {
        return $this->soLuong;
    }

    public function setSoLuong($soLuong) {
        $this->soLuong = $soLuong;
    }

    public function getTheLoai() {
        return $this->theLoai;
    }

    public function setTheLoai($theLoai) {
        $this->theLoai = $theLoai;
    }

    public function getMoTa() {
        return $this->moTa;
    }

    public function setMoTa($moTa) {
        $this->moTa = $moTa;
    }

    public function getThemAnh() {
        return $this->themAnh;
    }

    public function setThemAnh($themAnh) {
        $this->themAnh = $themAnh;
    }
    public function getTen_tac_gia() {
        return $this->ten_tac_gia;
    }
    public function setTen_tac_gia($ten_tac_gia) {
        $this->ten_tac_gia = $ten_tac_gia;
    }
    public function getTen_nxb() {
        return $this->ten_nxb;
    }
    public function setTen_nxb($ten_nxb) {
        $this->ten_nxb = $ten_nxb;
    }
    public function getThe_loai() {
        return $this->the_loai;
    }
}
?>
