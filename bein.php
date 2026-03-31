<?php
/**
 * beIN Smart Proxy Player v3.0
 * Optimized for Speed & CORS Bypass
 */

// --- إعدادات البروكسي والتحكم في التدفق ---
if (isset($_GET['stream'])) {
    // الرابط الأساسي لملف الـ m3u8
    $url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";
    
    // إذا كان الطلب لقطعة فيديو (.ts) نغير الرابط للرابط المرسل
    if (isset($_GET['ts'])) {
        $url = $_GET['ts'];
    }

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: VLC/3.0.18 LibVLC/3.0.18\r\n" .
                        "Accept: */*\r\n" .
                        "Connection: keep-alive\r\n",
            "timeout" => 10
        ]
    ];
    $context = stream_context_create($options);

    // حالة 1: طلب ملف الـ m3u8 (الفهرس)
    if (!isset($_GET['ts'])) {
        $content = @file_get_contents($url, false, $context);
        if ($content === false) {
            header("HTTP/1.1 500 Internal Error");
            die("خطأ في جلب بيانات البث.");
        }

        header("Content-Type: application/vnd.apple.mpegurl");
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-cache, must-revalidate");

        // المسار الأساسي لتحويل الروابط النسبية
        $base = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/";
        
        // معالجة الروابط داخل الملف لتعمل عبر البروكسي
        $lines = explode("\n", $content);
        $output = "";
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line && $line[0] !== '#') {
                if (strpos($line, 'http') === false) {
                    $full_ts_url = $base . $line;
                } else {
                    $full_ts_url = $line;
                }
                // توجيه رابط الـ ts ليعود لنفس هذا الملف
                $output .= "bein.php?stream=true&ts=" . urlencode($full_ts_url) . "\n";
            } else {
                $output .= $line . "\n";
            }
        }
        echo $output;
        exit;
    } 
    // حالة 2: طلب قطعة فيديو (.ts) - نستخدم النقل المباشر لتسريع الفتح
    else {
        header("Content-Type: video/mp2t");
        header("Access-Control-Allow-Origin: *");
        // قراءة الملف وإرساله فوراً للمتصفح دون تخزينه في الذاكرة
        @readfile($url, false, $context);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beIN Live Stream - Smart Proxy</title>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    
    <style>
        body, html {
            margin: 0; padding: 0; width: 100%; height: 100%;
            background-color: #000;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        #player {
            width: 100%;
            height: 100%;
            max-width: 1200px;
            aspect-ratio: 16 / 9;
            box-shadow: 0 0 50px rgba(0, 230, 118, 0.2);
        }
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
            actualLiveTime: true,
            preload: 'auto',
            playback: {
                playInline: true,
                hlsjsConfig: {
                    // إعدادات لتقليل التأخير (Latency)
                    enableWorker: true,
                    lowLatencyMode: true,
                    backBufferLength: 60
                }
            },
            watermark: "https://i.imgur.com/your_logo.png", // يمكنك وضع شعارك هنا
            position: 'top-right',
        });
    </script>

</body>
</html>
