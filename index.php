<?php
require_once __DIR__ . '/connect.php';
session_start();

// Autoload
spl_autoload_register(function ($class) {
    foreach (
        [
            __DIR__ . '/controllers/' . $class . '.php',
            __DIR__ . '/DAO/'         . $class . '.php'
        ] as $file
    ) {
        if (is_readable($file)) {
            require $file;
            return;
        }
    }
});


$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($requestUri === '/chat/respond') {
    require_once __DIR__ . '/ChatRouter.php';
    (new ChatRouter())->run();
    exit;
}


require_once 'controllers/sanPhamController.php';
$ctrl = new sanPhamController();
$ctrl->homeProduct();
