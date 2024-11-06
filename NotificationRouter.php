<?php
require_once 'controllers/notificationController.php';

$controller = new notificationController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'notificationUser':
            $controller->notificationUser();
            break;

        case 'getUnreadNotifications':
            $controller->getUnreadNotifications();
            break;

        default:
            echo "Invalid action!";
            break;
    }
} else {
    echo "No action specified!";
}
?>
