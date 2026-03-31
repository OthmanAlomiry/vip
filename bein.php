<?php
// --- إعدادات البروكسي ---
if (isset($_GET['stream'])) {
    $url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: VLC/3.0.18 LibVLC/3.0.18\r\n" .
                        "Accept: */*\r\n" .
                        "Connection: close\r\n",
            "ignore_errors" => true // للسماح بمعرفة نوع الخطأ من السيرفر
        ]
    ];

    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);

    // إذا فشل جلب المحتوى تماماً
    if ($content === false) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "خطأ: تعذر الاتصال بسيرفر البث.";
        exit;
    }

    // إرسال الهيدرز الصحيحة للمتصفح
    header("Content-Type: application/vnd.apple.mpegurl");
    header("Access-Control-Allow-Origin: *");
    header("Cache-Control: no-cache");
    echo $content;
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beIN Player - v2</title>
    
    <script src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    
    <style>
        body { background-color: #000; color: #fff; margin: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; }
        #player { width: 100%; max-width: 800px; }
        .info { margin-top: 15px; color: #777; font-size: 12px; }
    </style>
</head>
<body>

    <h3 style="color: #00e676;">البث المباشر المطور</h3>

    <div id="player"></div>

    <div class="info">المجال الحالي: up.d-service.pro</div>

    <script>
        var player = new Clappr.Player({
            source: "bein.php?stream=true",
            parentId: "#player",
            mimeType: "application/x-mpegURL",
            autoPlay: true,
            height: "100%",
            width: "100%",
            preload: 'auto',
            mediacontrol: {seekbar: "#00e676", buttons: "#00e676"},
            hlsMinimumLiveBufferLength: 2,
        });
    </script>
</body>
</html>
