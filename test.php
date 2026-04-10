<?php
session_start();
error_reporting(0);

// --- بيانات السحابة والـ API ---
$API_KEY_BIN = '$2a$10$HsgEopXEHj.LV8oAFpXB..ziTCTUK/9q6h/aHygbnFeW42h4B90Ge';
$BIN_ID = '69c4ad66c3097a1dd55f06d6';
// المفتاح الجديد من الصورة الأخيرة
$FOOTBALL_API_KEY = '895397d292e24b08cf4b107b68f52524'; 

// --- نظام الكاش للمباريات (للحفاظ على الـ 100 طلب) ---
$cache_file = 'matches_today.json';
$cache_time = 3600; // تحديث كل ساعة

function getMatchesData($key, $file, $time) {
    if (file_exists($file) && (time() - filemtime($file) < $time)) {
        return json_decode(file_get_contents($file), true);
    }
    
    // استخدام التاريخ فقط لأن باقتك مجانية ولا تدعم Next
    $today = date('Y-m-d');
    $ch = curl_init("https://v3.football.api-sports.io/fixtures?date=$today&timezone=Asia/Riyadh");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-apisports-key: $key"]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $result = json_decode($response, true);
    
    if (!empty($result['response'])) {
        file_put_contents($file, json_encode($result['response']));
        return $result['response'];
    }
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

// جلب البيانات وتصفية الدوريات المطلوبة
$all_matches = getMatchesData($FOOTBALL_API_KEY, $cache_file, $cache_time);
$target_leagues = [307, 140, 39, 135, 78, 61, 281, 17, 2, 3]; // الدوريات والبطولات التي حددتها
$filtered_matches = array_filter((array)$all_matches, function($m) use ($target_leagues) {
    return in_array($m['league']['id'], $target_leagues);
});

// باقي دوال الموقع الأصلية...
if(isset($_GET['check_notify'])) {
    $ch = curl_init("https://api.jsonbin.io/v3/b/" . $BIN_ID . "/latest");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Master-Key: " . $API_KEY_BIN, "X-Bin-Meta: false"]);
    echo curl_exec($ch); exit;
}

if (isset($_GET['fetch_visitors'])) {
    $visitors_file = 'online_visitors.txt';
    $data = file_exists($visitors_file) ? unserialize(file_get_contents($visitors_file)) : [];
    $data[session_id()] = time();
    foreach ($data as $id => $last) { if (time() - $last > 120) unset($data[$id]); }
    file_put_contents($visitors_file, serialize($data));
    echo count($data); exit; 
}

function getCloudData($bin, $key) {
    $ch = curl_init("https://api.jsonbin.io/v3/b/" . $bin . "/latest");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-Master-Key: " . $key, "X-Bin-Meta: false"]);
    return json_decode(curl_exec($ch), true);
}

$cloud = getCloudData($BIN_ID, $API_KEY_BIN);
$active_sections = array_filter($cloud['sections'] ?: [], function($s) { return $s['status'] == 'show'; });
date_default_timezone_set('Asia/Riyadh');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>بوابة الرياضة - d-service.pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ar', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <style>
        :root { --main: #e11d48; --bg: #050c14; --glass: rgba(255, 255, 255, 0.05); --sky: #0ea5e9; }
        body { margin: 0; font-family: 'Tajawal', sans-serif; background: var(--bg); color: #fff; padding-top: 160px; }
        .header-fixed { position: fixed; top: 0; width: 100%; max-width: 500px; z-index: 1000; background: rgba(5, 12, 20, 0.95); backdrop-filter: blur(20px); padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .main-container { width: 100%; max-width: 500px; margin: 0 auto; padding: 15px; }
        
        /* تصميم كرت المباراة */
        .match-card { background: var(--glass); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; padding: 15px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; position: relative; }
        .league-name { position: absolute; top: -8px; right: 15px; background: var(--sky); font-size: 8px; padding: 2px 10px; border-radius: 10px; font-weight: 900; }
        .team { flex: 1; text-align: center; font-size: 11px; font-weight: 900; }
        .team img { width: 30px; height: 30px; display: block; margin: 0 auto 5px; }
        .score-info { flex: 0.8; text-align: center; }
        .score { font-size: 20px; font-weight: 900; }
        .time { font-size: 10px; color: var(--sky); }

        .tabs { display: flex; gap: 8px; overflow-x: auto; padding: 10px; scrollbar-width: none; }
        .tab { min-width: 70px; background: var(--glass); padding: 10px 5px; border-radius: 12px; text-align: center; cursor: pointer; font-size: 9px; }
        .tab.active { background: var(--main); }
        
        .section { display: none; }
        .section.active { display: block; }
        
        /* إخفاء شريط الترجمة */
        .goog-te-banner-frame { display: none !important; }
        body { top: 0px !important; }
        #google_translate_element { display: none; }
    </style>
</head>
<body>
    <div id="google_translate_element"></div>

    <div class="header-fixed" style="left: 50%; transform: translateX(-50%);">
        <div class="tabs">
            <div class="tab active" onclick="showSec('matches', this)">المباريات</div>
            <?php foreach($active_sections as $s): ?>
                <div class="tab" onclick="showSec('<?= $s['key'] ?>', this)"><?= $s['name'] ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="main-container">
        <div id="sec-matches" class="section active">
            <h3 style="color:var(--sky); font-size:14px; margin-bottom:15px;">مباريات اليوم</h3>
            <?php if(empty($filtered_matches)): ?>
                <p style="text-align:center; opacity:0.5;">لا توجد مباريات هامة اليوم</p>
            <?php else: foreach($filtered_matches as $m): ?>
                <div class="match-card">
                    <div class="league-name"><?= $m['league']['name'] ?></div>
                    <div class="team"><img src="<?= $m['teams']['home']['logo'] ?>"><span><?= $m['teams']['home']['name'] ?></span></div>
                    <div class="score-info">
                        <div class="score"><?= $m['goals']['home'] ?? 0 ?> - <?= $m['goals']['away'] ?? 0 ?></div>
                        <div class="time"><?= date("H:i", $m['fixture']['timestamp']) ?></div>
                    </div>
                    <div class="team"><img src="<?= $m['teams']['away']['logo'] ?>"><span><?= $m['teams']['away']['name'] ?></span></div>
                </div>
            <?php endforeach; endif; ?>
        </div>

        <?php foreach($active_sections as $s): ?>
            <div id="sec-<?= $s['key'] ?>" class="section">
                <p style="text-align:center; padding:50px;">قريباً قنوات <?= $s['name'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function showSec(id, btn) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById('sec-' + id).classList.add('active');
            btn.classList.add('active');
        }
    </script>
</body>
</html>
