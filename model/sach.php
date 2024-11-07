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

    // Constructor
    public function __construct(
        $maSanPham,
        $tenSanPham,
        $tacGia,
        $nhaXuatBan,
        $theLoai,
        $giamua,
        $giaBan,
        $soLuong,
        $namXuatBan,
        $moTa,
        $themAnh
    ) {
        $this->maSanPham = $maSanPham;
        $this->tenSanPham = $tenSanPham;
        $this->tacGia = $tacGia;
        $this->nhaXuatBan = $nhaXuatBan;
        $this->theLoai = $theLoai;
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
}
?>
