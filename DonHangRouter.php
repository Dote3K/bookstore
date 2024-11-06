<?php
require_once 'controllers/DonHangController.php';

$controller = new DonHangController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'list':
            $controller->list();
            break;

        case 'listOrderUser':
            $controller->listOrderUser();
            break;
        case 'delete':
            $controller->delete();
            break;

        case 'updateStatus':
            $controller->updateStatus();
            break;


        default:
            echo "Invalid action!";
            break;
    }
} else {
    echo "No action specified!";
}
