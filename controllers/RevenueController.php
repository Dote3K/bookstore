<?php
include __DIR__ . '/../models/RevenueModel.php';

class RevenueController {
    private $model;

    public function __construct($db) {
        $this->model = new RevenueModel($db);
    }

    public function showDailyRevenue($date) {
        return $this->model->getDailyRevenue($date);
    }

    public function showMonthlyRevenue($month, $year) {
        return $this->model->getMonthlyRevenue($month, $year);
    }
    public function showMonthlyRevenueTotal($month, $year) {
        return $this->model->getMonthlyRevenueTotal($month, $year);
    }

    public function showYearlyRevenue($yearonly) {
        return $this->model->getYearlyRevenue($yearonly);
    }
    public function showYearlyRevenueTotal($yearonly) {
        return $this->model->getYearlyRevenueTotal($yearonly);
    }
}
?>
