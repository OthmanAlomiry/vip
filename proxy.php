<?php
// جلب الرابط من المعامل url
$url = $_GET['url'];

if (!$url) {
    die("No URL provided");
}

// إعدادات الطلب لجعل السيرفر يعتقد أننا متصفح عادي أو مشغل VLC
$options = [
    "http" => [
        "header" => "User-Agent: VLC/3.0.18 LibVLC/3.0.18\r\n"
    ]
];

$context = stream_context_create($options);
$content = file_get_contents($url, false, $context);

// إخبار المتصفح أن هذا ملف بث m3u8
header("Content-Type: application/vnd.apple.mpegurl");
header("Access-Control-Allow-Origin: *"); // لفك حظر CORS

echo $content;
