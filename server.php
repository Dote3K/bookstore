<?php

if (php_sapi_name() === 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    // Nếu file tồn tại, serve tĩnh luôn
    if (is_file($file)) {
        return false;
    }
}
// Ngược lại, chuyển hết về index.php
require_once __DIR__ . '/index.php';
?>