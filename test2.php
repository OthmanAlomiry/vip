<?php
session_start();
error_reporting(0);

// --- إعدادات الـ API والملفات عثمان ---
$FOOTBALL_API_KEY = '6b9915e3b84f54b3962e5817b9e26e5f'; // مفتاحك النشط من الصورة
$cache_file = 'matches_cache.json';
$cache_time = 3600; // تحديث كل ساعة للحفاظ على الـ 100 طلب

// --- مصفوفة الدوريات المطلوبة (بناءً على فحصك الأخير) ---
$target_leagues = [
    42,    // دوري أبطال أوروبا (Champions League)
    73,    // الدوري الأوروبي (Europa League)
    525,   // دوري أبطال آسيا للنخبة (AFC Champions League Elite)
    9470,  // دوري التحدي الآسيوي (AFC Challenge League)
    307,   // الدوري السعودي (Roshn Saudi League)
    39,    // الدوري الإنجليزي الممتاز
    140,   // الدوري الإسباني
    135,   // الدوري الإيطالي
    78,    // الدوري الألماني
    61     // الدوري الفرنسي
];

// --- دالة جلب البيانات بنظام الكاش عثمان ---
function fetchMatches($key, $file, $time) {
    if (file_exists($file) && (time() - filemtime($file) < $time)) {
        return json_decode(file_get_contents($file), true);
    }

    $today = date('Y-m-d');
    // نستخدم التاريخ فقط لأن الباقة المجانية لا تدعم بارامتر Next
    $url = "https://v3.football.api-sports.io/fixtures?date=$today&timezone=Asia/Riyadh";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-apisports-key: $key"]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $data = json_decode($response, true);

    if (!empty($data['response'])) {
        file_put_contents($file, json_encode($data['response']));
        return $data['response'];
    }
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

$all_matches = fetchMatches($FOOTBALL_API_KEY, $cache_file, $cache_time);

// تصفية المباريات للدوريات المحددة فقط عثمان
$filtered_matches = array_filter((array)$all_matches, function($m) use ($target_leagues) {
    return in_array($m['league']['id'], $target_leagues);
});

date_default_timezone_set('Asia/Riyadh');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول المباريات - الخدمة الرقمية</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root { --bg: #050c14; --sky: #0ea5e9; --glass: rgba(255, 255, 255, 0.05); }
        body { background: var(--bg); color: #fff; font-family: 'Tajawal', sans-serif; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; }
        .match-card { background: var(--glass); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 15px; margin-bottom: 12px; position: relative; }
        .league-tag { position: absolute; top: -8px; left: 15px; background: var(--sky); font-size: 9px; padding: 2px 10px; border-radius: 10px; font-weight: 900; }
        .teams { display: flex; align-items: center; justify-content: space-between; margin-top: 10px; }
        .team { flex: 1; text-align: center; font-size: 11px; }
        .team img { width: 35px; height: 35px; display: block; margin: 0 auto 5px; }
        .score-box { flex: 0.8; text-align: center; border-left: 1px solid rgba(255,255,255,0.1); border-right: 1px solid rgba(255,255,255,0.1); }
        .score { font-size: 20px; font-weight: 900; }
        .time { font-size: 11px; color: var(--sky); }
        /* إخفاء شريط ترجمة جوجل */
        .goog-te-banner-frame { display: none !important; }
        body { top: 0px !important; }
    </style>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ar', autoDisplay: false}, 'google_translate_element');
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>
<body>
    <div id="google_translate_element" style="display:none;"></div>
    
    <div class="container">
        <h2 style="border-right: 4px solid var(--sky); padding-right: 15px; font-size: 18px;">مباريات اليوم</h2>
        
        <?php if(empty($filtered_matches)): ?>
            <div style="text-align:center; opacity:0.5; padding:50px;">لا توجد مباريات هامة مجدولة اليوم.</div>
        <?php else: foreach($filtered_matches as $m): ?>
            <div class="match-card">
                <div class="league-tag"><?= $m['league']['name'] ?></div>
                <div class="teams">
                    <div class="team">
                        <img src="<?= $m['teams']['home']['logo'] ?>">
                        <span><?= $m['teams']['home']['name'] ?></span>
                    </div>
                    <div class="score-box">
                        <div class="score"><?= $m['goals']['home'] ?? 0 ?> - <?= $m['goals']['away'] ?? 0 ?></div>
                        <div class="time"><?= date("H:i", $m['fixture']['timestamp']) ?></div>
                    </div>
                    <div class="team">
                        <img src="<?= $m['teams']['away']['logo'] ?>">
                        <span><?= $m['teams']['away']['name'] ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; endif; ?>
    </div>
</body>
</html>
