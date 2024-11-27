<?php
require_once 'controllers/searchController.php';

session_start();
$controller = new searchController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'search':
            $controller->search();
            break;

        default:
            echo "Invalid action!";
            break;
    }
} else {
    echo "No action specified!";
}
?>
