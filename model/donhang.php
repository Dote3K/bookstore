<?php

class DonHang {
    private $maDonHang; 
    private $maKhachHang;
    private $tongTruocVat; 
    private $vat;
    private $tong;
    private $ngayDatHang; 
    private $trangThai;
    private $diaChiNhanHang;
    private $giamGia; 

    // Constructor
    
    public function __construct($maDonHang, $maKhachHang,
                                $tong, $ngayDatHang, $trangThai, 
                                $diaChiNhanHang,$giamGia) {
        $this->maDonHang = $maDonHang;
        $this->maKhachHang = $maKhachHang;
        $this->tong = $tong;
        $this->ngayDatHang = $ngayDatHang ?? date('Y-m-d H:i:s'); // Thay đổi ngày đặt hàng nếu không có
        $this->trangThai = $trangThai;
        $this->diaChiNhanHang = $diaChiNhanHang;
        $this->giamGia = $giamGia;
    }
    public function calculateTong() {
        $this->tong = $this->tongTruocVat * (1 + $this->vat / 100) - $this->giamGia;
    }

    // Getter và Setter cho maDonHang
    public function getMaDonHang() {
        return $this->maDonHang;
    }

    public function setMaDonHang($maDonHang) {
        $this->maDonHang = $maDonHang;
    }

    // Getter và Setter cho maKhachHang
    public function getMaKhachHang() {
        return $this->maKhachHang;
    }

    public function setMaKhachHang($maKhachHang) {
        $this->maKhachHang = $maKhachHang;
    }

    // Getter và Setter cho tong
    public function getTong() {
        return $this->tong;
    }

    public function setTong($tong) {
        $this->tong = $tong;
    }

    // Getter và Setter cho ngayDatHang
    public function getNgayDatHang() {
        return $this->ngayDatHang;
    }

    public function setNgayDatHang($ngayDatHang) {
        $this->ngayDatHang = $ngayDatHang;
    }

    // Getter và Setter cho trangThai
    public function setTrangThai(TrangThaiDonHang $trangThai): void {
        $this->trangThai = $trangThai;
    }

    public function getTrangThai(){
        return $this->trangThai;
    }

    // Getter và Setter cho diaChiNhanHang
    public function getDiaChiNhanHang() {
        return $this->diaChiNhanHang;
    }

    public function setDiaChiNhanHang($diaChiNhanHang) {
        $this->diaChiNhanHang = $diaChiNhanHang;
    }

    // Getter và Setter cho giamGia
    public function getGiamGia() {
        return $this->giamGia;
    }

    public function setGiamGia($giamGia) {
        $this->giamGia = $giamGia;
    }
}
?>
