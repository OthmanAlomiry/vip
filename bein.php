<?php
// إعدادات البث
$original_m3u8 = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";
$base_url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/";

// منع استهلاك الذاكرة وتحديد وقت التنفيذ
ini_set('memory_limit', '512M');
set_time_limit(0);

if (isset($_GET['ts'])) {
    // جلب قطعة الفيديو وتمريرها مباشرة
    $ts_url = $_GET['ts'];
    header("Content-Type: video/mp2t");
    header("Access-Control-Allow-Origin: *");
    
    $opts = ["http" => ["header" => "User-Agent: VLC/3.0.18\r\n"]];
    $context = stream_context_create($opts);
    
    // استخدام readfile لنقل البيانات بسرعة من السيرفر للمتصفح
    @readfile($ts_url, false, $context);
    exit;
}

if (isset($_GET['playlist'])) {
    // جلب ملف الـ m3u8 وتعديل الروابط
    $opts = ["http" => ["header" => "User-Agent: VLC/3.0.18\r\n"]];
    $context = stream_context_create($opts);
    $data = file_get_contents($original_m3u8, false, $context);
    
    header("Content-Type: application/vnd.apple.mpegurl");
    header("Access-Control-Allow-Origin: *");

    // تعديل الروابط لتمر عبر هذا الملف
    $lines = explode("\n", $data);
    foreach ($lines as &$line) {
        $line = trim($line);
        if ($line && $line[0] !== '#') {
            $full_url = (strpos($line, 'http') === false) ? $base_url . $line : $line;
            $line = "bein.php?ts=" . urlencode($full_url);
        }
    }
    echo implode("\n", $lines);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>beIN Smart Live</title>
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    <style>
        body { margin: 0; background: #000; overflow: hidden; }
        .video-js { width: 100vw; height: 100vh; }
    </style>
</head>
<body>
    <video id="player" class="video-js vjs-default-skin vjs-big-play-centered" controls autoplay preload="auto">
        <source src="bein.php?playlist=true" type="application/x-mpegURL">
    </video>
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
</body>
</html>
