<?php

class chitietdonhang {
    private $maChiTietDonHang; // ma_chi_tiet_don_hang
    private $maDonHang; // ma_don_hang
    private $maSach; // ma_sach
    private $soLuong; // so_luong

    // Constructor
    public function __construct($maChiTietDonHang, $maDonHang, $maSach, $soLuong) {
        $this->maChiTietDonHang = $maChiTietDonHang;
        $this->maDonHang = $maDonHang;
        $this->maSach = $maSach;
        $this->soLuong = $soLuong;
    }

    // Getter và Setter cho maChiTietDonHang
    public function getMaChiTietDonHang() {
        return $this->maChiTietDonHang;
    }

    public function setMaChiTietDonHang($maChiTietDonHang) {
        $this->maChiTietDonHang = $maChiTietDonHang;
    }

    // Getter và Setter cho maDonHang
    public function getMaDonHang() {
        return $this->maDonHang;
    }

    public function setMaDonHang($maDonHang) {
        $this->maDonHang = $maDonHang;
    }

    // Getter và Setter cho maSach
    public function getMaSach() {
        return $this->maSach;
    }

    public function setMaSach($maSach) {
        $this->maSach = $maSach;
    }

    // Getter và Setter cho soLuong
    public function getSoLuong() {
        return $this->soLuong;
    }

    public function setSoLuong($soLuong) {
        $this->soLuong = $soLuong;
    }
}
?>
