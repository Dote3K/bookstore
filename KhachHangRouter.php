<?php
require_once 'controllers/KhachHangController.php';

$controller = new KhachHangController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            $controller->register();
            break;

        case 'login':
            $controller->login();
            break;
        case 'logout':
            $controller->logout();
            break;
        default:
            echo "Invalid action!";
            break;
    }
} else {
    echo "No action specified!";
}
