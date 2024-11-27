<?php
include __DIR__ .  '/../DAO/doanhthu_DAO.php';

class doanhthufunction {
    private $DAO;

        public function __construct($conn) {
            $this->doanhthuDAO = new doanhthuDAO($conn);
        }

        public function doanhThuNgay($date) {
            return $this->doanhthuDAO->getDoanhThuNgay($date);
        }

        public function chiTietDoanhThuThang($month, $year) {
            return $this->doanhthuDAO->getChiTietDoanhThuThang($month, $year);
        }
        public function doanhThuThang($month, $year) {
            return $this->doanhthuDAO->getDoanhThuThang($month, $year);
        }

        public function chiTietDoanhThuNam($yearonly) {
            return $this->doanhthuDAO->getChiTietDoanhThuNam($yearonly);
        }
        public function doanhThuNam($yearonly) {
            return $this->doanhthuDAO->getDoanhThuNam($yearonly);
        }
        public function bestSellerNgay($date){
            return $this->doanhthuDAO->getBestSellerNgay($date);
        }
        public function bestSellerThang($month, $year) {
            return $this->doanhthuDAO->getBestSellerThang($month, $year);
        }
        public function bestSellerNam($yearonly) {
            return $this->doanhthuDAO->getBestSellerNam($yearonly);
        }
    }
?>