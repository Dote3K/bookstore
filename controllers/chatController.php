<?php

require_once 'DAO/sachDAO.php';

class ChatController
{
    public function respond()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $message = trim($input['message'] ?? '');
        if (!$message) {
            http_response_code(400);
            echo json_encode(['error' => 'No message provided']);
            exit;
        }

        $witToken = 'Bearer 6YVN77FOFXYWDRXXEEHJE3VD3BGDLT4U';
        $witUrl = 'https://api.wit.ai/message?v=20230501&q=' . urlencode($message);

        $ch = curl_init($witUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $witToken
            ],
        ]);
        $res = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code === 200 && $res) {
            $data = json_decode($res, true);
            file_put_contents(__DIR__ . '/wit_debug.json', json_encode($data, JSON_PRETTY_PRINT));
            $intent = $data['intents'][0]['name'] ?? 'unknown';
            $confidence = $data['intents'][0]['confidence'] ?? 0;

            if ($confidence < 0.6) {
                $reply = 'Tôi chưa rõ ý bạn, bạn nói lại được không?';
            } else {
                $bookName = '';
                foreach ($data['entities'] as $key => $val) {
                    if (str_starts_with($key, 'book_name')) {
                        $bookName = $val[0]['value'] ?? '';
                        break;
                    }
                }
                $sachDAO = new sachDAO();

                switch ($intent) {
                    case 'greeting':
                        $reply = 'Xin chào! Tôi có thể giúp gì cho bạn?';
                        break;
                    case 'deptrai':
                        $reply = "bạn đẹp trai vãi ò";
                        break;
                    case 'ask_price':
                    case 'search_book':
                        if (!$bookName) {
                            $reply = 'Bạn vui lòng cho biết tên sách cụ thể nhé.';
                            break;
                        }
                        $books = $sachDAO->searchBooks($bookName);
                        if (!empty($books)) {
                            $book = $books[0];
                            if ($intent === 'ask_price') {
                                $reply = "Giá của sách \"{$book['ten_sach']}\" là " . number_format($book['gia_ban'], 0, ',', '.') . " VNĐ.";
                            } else {
                                $reply = "Tôi đã tìm thấy sách \"{$book['ten_sach']}\". Bạn muốn xem chi tiết không?";
                            }
                        } else {
                            $reply = "Xin lỗi, tôi không tìm thấy sách có tên \"$bookName\".";
                        }
                        break;
                    default:
                        $reply = "Tôi chưa hiểu rõ ý bạn. Bạn có thể nói rõ hơn không?";
                }
            }
        } else {
            $reply = 'Xin lỗi, tôi không thể kết nối Wit.ai.';
        }

        echo json_encode(['reply' => $reply]);
    }
}
