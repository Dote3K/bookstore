<?php
require_once 'DAO/sachDAO.php';

class sanPhamController {
    private $sachController;

    public function __construct() {
        $this->sachController = new sachDAO();
    }

    public function homeProduct() {
        $current = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $pageSize =9;

        $start = ($current-1) * $pageSize;

        $sachs = $this->sachController->selectByPage($start,$pageSize);

        $totalBook = $this->sachController->getTotalBook();

        $totalPages = ceil($totalBook / $pageSize);

        require 'view/home.php';
    }
    
   
}
