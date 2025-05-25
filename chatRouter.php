<?php

require_once 'Controllers\ChatController.php';

class ChatRouter
{
    public function run()
    {
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];


        if ($uri === '/chat/respond' && $method === 'POST') {
            (new ChatController())->respond();
            exit;
        }

    }
}
