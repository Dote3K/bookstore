<?php
require_once 'C:/Users/Acer/Documents/GitHub/bookstore/DAO/doanhthu_DAO.php';

class doanhthufunction {
    private $DAO;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function __construct($db) {
        $this->DAO = new doanhthuDAO($db);
=======
    public function __construct($conn) {
        $this->doanhthuDAO = new doanhthuDAO($conn);
>>>>>>> 597d457140ad2cbb3a5897917d0a74529418d322
=======
    public function __construct($conn) {
        $this->doanhthuDAO = new doanhthuDAO($conn);
>>>>>>> 597d457140ad2cbb3a5897917d0a74529418d322
=======
    public function __construct($conn) {
        $this->doanhthuDAO = new doanhthuDAO($conn);
>>>>>>> 597d457140ad2cbb3a5897917d0a74529418d322
    }

    public function doanhThuNgay($date) {
        return $this->DAO->getDoanhThuNgay($date);
    }

    public function chiTietDoanhThuThang($month, $year) {
        return $this->DAO->getChiTietDoanhThuThang($month, $year);
    }
    public function doanhThuThang($month, $year) {
        return $this->DAO->getDoanhThuThang($month, $year);
    }

    public function chiTietDoanhThuNam($yearonly) {
        return $this->DAO->getChiTietDoanhThuNam($yearonly);
    }
    public function doanhThuNam($yearonly) {
        return $this->DAO->getDoanhThuNam($yearonly);
    }
    public function bestSellerNgay($date){
        return $this->DAO->getBestSellerNgay($date);
    }
    public function bestSellerThang($month, $year) {
        return $this->DAO->getBestSellerThang($month, $year);
    }
    public function bestSellerNam($yearonly) {
        return $this->DAO->getBestSellerNam($yearonly);
    }
}
?>
