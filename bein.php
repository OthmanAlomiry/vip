<?php
// 1. بروكسي بسيط جداً لملف القائمة فقط
if (isset($_GET['get_playlist'])) {
    $url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";
    
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: VLC/3.0.18\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $content = @file_get_contents($url, false, $context);
    
    header("Content-Type: application/vnd.apple.mpegurl");
    header("Access-Control-Allow-Origin: *");
    echo $content;
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beIN Player PRO</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/dplayer@latest/dist/DPlayer.min.js"></script>
    <style>
        body { margin: 0; background: #000; display: flex; justify-content: center; align-items: center; height: 100vh; }
        #dplayer { width: 100%; max-width: 900px; height: 506px; }
    </style>
</head>
<body>

<div id="dplayer"></div>

<script>
    const dp = new DPlayer({
        container: document.getElementById('dplayer'),
        live: true,
        autoplay: true,
        video: {
            url: 'bein.php?get_playlist=1',
            type: 'customHls',
            customType: {
                customHls: function (video, player) {
                    const hls = new Hls({
                        // هذا الجزء يضيف الهيدرز لكل طلب فيديو (ts) لتجاوز الحماية
                        xhrSetup: function (xhr, url) {
                            xhr.setRequestHeader('User-Agent', 'VLC/3.0.18');
                        }
                    });
                    hls.loadSource(video.src);
                    hls.attachMedia(video);
                },
            },
        },
    });
</script>

</body>
</html>
