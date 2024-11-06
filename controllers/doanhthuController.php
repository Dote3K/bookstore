<?php
include __DIR__ .  '/../DAO/doanhthu_DAO.php';

class doanhthufunction {
    private $model;

    public function __construct($db) {
        $this->model = new doanhthuDAO($db);
    }

    public function doanhThuNgay($date) {
        return $this->model->getDoanhThuNgay($date);
    }

    public function chiTietDoanhThuThang($month, $year) {
        return $this->model->getChiTietDoanhThuThang($month, $year);
    }
    public function doanhThuThang($month, $year) {
        return $this->model->getDoanhThuThang($month, $year);
    }

    public function chiTietDoanhThuNam($yearonly) {
        return $this->model->getChiTietDoanhThuNam($yearonly);
    }
    public function doanhThuNam($yearonly) {
        return $this->model->getDoanhThuNam($yearonly);
    }
    public function bestSellerNgay($date){
        return $this->model->getBestSellerNgay($date);
    }
    public function bestSellerThang($month, $year) {
        return $this->model->getBestSellerThang($month, $year);
    }
    public function bestSellerNam($yearonly) {
        return $this->model->getBestSellerNam($yearonly);
    }
}
?>
