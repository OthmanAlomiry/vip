<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشغل البث المباشر</title>
    
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    
    <style>
        body { background-color: #1a1a1a; color: white; text-align: center; font-family: sans-serif; }
        .container { margin-top: 50px; }
        .video-js { margin: 0 auto; border: 2px solid #444; border-radius: 8px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>مشغل IPTV المباشر</h2>
        
        <?php
            // الرابط الخاص بك
            $stream_url = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/67397.m3u8";
        ?>

        <video id="my-video" class="video-js vjs-default-skin vjs-big-play-centered" 
               controls preload="auto" width="800" height="450" data-setup='{}'>
            <source src="<?php echo $stream_url; ?>" type="application/x-mpegURL">
            <p class="vjs-no-js">
                للمشاهدة، يرجى تفعيل JavaScript وتحديث المتصفح.
            </p>
        </video>
    </div>

    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>
</body>
</html>
