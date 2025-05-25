<?php

require_once __DIR__ . '/connect.php';

session_start();

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


require_once __DIR__ . '/ChatRouter.php';
(new ChatRouter())->run();

require_once __DIR__ . '/controllers/sanPhamController.php';
$ctrl = new sanPhamController();
$ctrl->homeProduct();
