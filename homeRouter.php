<?php
require_once 'controllers/sanPhamController.php';

session_start();
$controller = new sanPhamController();
$controller->homeProduct();
?>
