<?php
include 'doanhthu_DAO.php';

class doanhthufunction {
    private $model;

    public function __construct($db) {
        $this->model = new doanhthuDAO($db);
    }

    public function doanhThuNgay($date) {
        return $this->model->getDoanhThuNgay($date);
    }

    public function doanhThuThang($month, $year) {
        return $this->model->getDoanhThuThang($month, $year);
    }
    public function chiTietDoanhThuThang($month, $year) {
        return $this->model->getChiTietDoanhThuThang($month, $year);
    }

    public function doanhThuNam($yearonly) {
        return $this->model->getDoanhThuNam($yearonly);
    }
    public function chiTietDoanhThuNam($yearonly) {
        return $this->model->chiTietDoanhThuNam($yearonly);
    }
}
?>
