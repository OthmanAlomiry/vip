<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>beIN Sports Live - Cloudflare Powered</title>
    
    <link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />
    
    <style>
        body, html { 
            margin: 0; padding: 0; width: 100%; height: 100%; 
            background-color: #000; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .video-js {
            width: 100% !important;
            height: 100% !important;
        }
        /* تحسين شكل زر التشغيل */
        .vjs-big-play-centered .vjs-big-play-button {
            background-color: rgba(0, 230, 118, 0.5);
            border-radius: 50%;
            width: 2em; height: 2em; line-height: 2em; margin-top: -1em; margin-left: -1em;
        }
    </style>
</head>
<body>

    <video id="my-video" 
           class="video-js vjs-default-skin vjs-big-play-centered" 
           controls 
           autoplay 
           preload="auto" 
           playsinline>
        <source src="https://still-surf-2ef3.othman1405.workers.dev" type="application/x-mpegURL">
        <p class="vjs-no-js">يرجى تحديث المتصفح لمشاهدة البث.</p>
    </video>

    <script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

    <script>
        // إعدادات إضافية لضمان التشغيل التلقائي وتقليل التأخير
        var player = videojs('my-video', {
            liveui: true,
            fluid: true,
            html5: {
                vhs: {
                    overrideNative: true
                },
                nativeVideoTracks: false,
                nativeAudioTracks: false,
                nativeTextTracks: false
            }
        });

        // محاولة التشغيل التلقائي في حالة كتم الصوت (سياسة المتصفحات)
        player.ready(function() {
            var promise = player.play();
            if (promise !== undefined) {
                promise.catch(function(error) {
                    console.log("Auto-play was prevented. Waiting for user interaction.");
                });
            }
        });
    </script>
</body>
</html>
