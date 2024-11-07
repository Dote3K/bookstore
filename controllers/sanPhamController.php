<?php
require_once 'DAO/sachDAO.php';

class sanPhamController {
    private $sachController;

    public function __construct() {
        $this->sachController = new sachDAO();
    }

    public function homeProduct() {
        $sachs = $this->sachController->selectAll();
        require 'view/home.php';
    }
}
