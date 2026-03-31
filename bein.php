<?php
// --- إعدادات البروكسي الذكي ---
if (isset($_GET['stream'])) {
    // الرابط الأساسي
    $url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";
    
    // إذا كان الطلب لقطعة فيديو (ملف .ts)
    if (isset($_GET['ts'])) {
        $url = $_GET['ts'];
    }

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: VLC/3.0.18 LibVLC/3.0.18\r\n" .
                        "Accept: */*\r\n"
        ]
    ];

    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);

    if ($content === false) {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    // إذا كان الملف هو قائمة التشغيل (m3u8)، سنقوم بتعديل الروابط داخله
    if (!isset($_GET['ts'])) {
        header("Content-Type: application/vnd.apple.mpegurl");
        header("Access-Control-Allow-Origin: *");
        
        // استخراج المسار الأساسي (Base URL) لتحويل الروابط النسبية إلى كاملة
        $base = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/";
        
        // تعديل كل سطر لا يبدأ بـ # (أي روابط الفيديو)
        $lines = explode("\n", $content);
        foreach ($lines as &$line) {
            $line = trim($line);
            if ($line && $line[0] !== '#') {
                // تحويل رابط الفيديو ليمر عبر نفس هذا الملف (bein.php)
                if (strpos($line, 'http') === false) {
                    $full_ts_url = $base . $line;
                } else {
                    $full_ts_url = $line;
                }
                $line = "bein.php?stream=true&ts=" . urlencode($full_ts_url);
            }
        }
        echo implode("\n", $lines);
    } else {
        // إذا كان ملف فيديو .ts، نرسله كما هو
        header("Content-Type: video/mp2t");
        header("Access-Control-Allow-Origin: *");
        echo $content;
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beIN Smart Player</title>
    <script src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    <style>
        body { background: #000; margin: 0; display: flex; align-items: center; justify-content: center; height: 100vh; overflow: hidden; }
        #player { width: 100%; height: 100%; max-width: 1000px; max-height: 562px; border: 1px solid #222; }
    </style>
</head>
<body>

    <div id="player"></div>

    <script>
        var player = new Clappr.Player({
            source: "bein.php?stream=true",
            parentId: "#player",
            autoPlay: true,
            width: '100%',
            height: '100%',
            mimeType: "application/x-mpegURL",
            hlsjsConfig: {
                enableWorker: true
            }
        });
    </script>
</body>
</html>
