<?php
// 1. منطق البروكسي: إذا طلب المشغل الرابط مع وجود متغير stream في الرابط
if (isset($_GET['stream'])) {
    $url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";

    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: VLC/3.0.18 LibVLC/3.0.18\r\n" . // إيهام السيرفر أنه مشغل VLC
                        "Accept: */*\r\n"
        ]
    ];

    $context = stream_context_create($options);
    $content = file_get_contents($url, false, $context);

    if ($content !== false) {
        header("Content-Type: application/vnd.apple.mpegurl");
        header("Access-Control-Allow-Origin: *"); // لفك حظر المتصفح CORS
        echo $content;
    }
    exit; // إنهاء التنفيذ هنا عند طلب البث فقط
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشغل beIN - d-service</title>
    
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    
    <style>
        body { 
            background-color: #0b0b0b; 
            color: white; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            height: 100vh; 
            margin: 0; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .player-container {
            width: 90%;
            max-width: 800px;
            border: 2px solid #333;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        }
        h2 { margin-bottom: 20px; color: #ffcc00; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    </style>
</head>
<body>

    <h2>beIN Sports Live</h2>

    <div class="player-container">
        <video id="my-video" 
               class="video-js vjs-default-skin vjs-big-play-centered vjs-16-9" 
               controls 
               preload="auto" 
               data-setup='{}'>
            <source src="bein.php?stream=true" type="application/x-mpegURL">
            <p class="vjs-no-js">يرجى تحديث المتصفح لدعم تشغيل الفيديو.</p>
        </video>
    </div>

    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
</body>
</html>
