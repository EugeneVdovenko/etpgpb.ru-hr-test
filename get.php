<?php
echo json_encode([
    'status' => 'ok',
    'data' => [
        ['date' => '01.01.2000', 'time' => '13:50', 'ip' => '192.168.1.1', 'from' => 'http://ya.ru', 'to' => 'http://my.com'],
        ['date' => '02.01.2000', 'time' => '11:30', 'ip' => '192.168.1.2', 'from' => 'http://rambler.ru', 'to' => 'http://mail.ru'],
    ],
], JSON_UNESCAPED_UNICODE);
