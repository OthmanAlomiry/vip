<?php
// إعدادات الكاش والمفتاح عثمان
$cache_file = 'matches_today.json';
$cache_time = 3600; // تحديث كل ساعة للحفاظ على الـ 100 طلب
$API_KEY = '895397d292e24b08cf4b107b68f52524';

// معرفات الدوريات كما ظهرت في فحصك الأخير عثمان
$target_leagues = [
    42,    // Champions League (دوري أبطال أوروبا)
    73,    // Europa League (الدوري الأوروبي)
    525,   // AFC Champions League Elite (نخبة آسيا)
    9470,  // AFC Challenge League
    307,   // الدوري السعودي (تأكد من ظهوره في الفحص)
    39,    // الدوري الإنجليزي
    140,   // الدوري الإسباني
    135,   // الدوري الإيطالي
    78,    // الدوري الألماني
    61     // الدوري الفرنسي
];

function getMatchesToday($key, $file, $time) {
    if (file_exists($file) && (time() - filemtime($file) < $time)) {
        return json_decode(file_get_contents($file), true);
    }

    $today = date('Y-m-d');
    // استخدام بارامتر date فقط لأن باقتك مجانية ولا تدعم Next
    $url = "https://v3.football.api-sports.io/fixtures?date=$today&timezone=Asia/Riyadh";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-apisports-key: $key"]);
    $res = curl_exec($ch);
    $data = json_decode($res, true);

    if (!empty($data['response'])) {
        file_put_contents($file, json_encode($data['response']));
        return $data['response'];
    }
    return [];
}

$matches = getMatchesToday($API_KEY, $cache_file, $cache_time);

// تصفية المباريات حسب الدوريات المختارة عثمان
$my_matches = array_filter((array)$matches, function($m) use ($target_leagues) {
    return in_array($m['league']['id'], $target_leagues);
});
?>

<div id="matches-section">
    <?php if (empty($my_matches)): ?>
        <p style="text-align:center; padding:20px; opacity:0.5;">لا توجد مباريات هامة مجدولة اليوم.</p>
    <?php else: ?>
        <?php foreach ($my_matches as $match): ?>
            <div class="match-card">
                <div class="league-label"><?php echo $match['league']['name']; ?></div>
                <div class="teams-flex">
                    <div class="team">
                        <img src="<?php echo $match['teams']['home']['logo']; ?>" width="30">
                        <span><?php echo $match['teams']['home']['name']; ?></span>
                    </div>
                    <div class="score">
                        <?php echo ($match['goals']['home'] ?? 0) . " - " . ($match['goals']['away'] ?? 0); ?>
                    </div>
                    <div class="team">
                        <span><?php echo $match['teams']['away']['name']; ?></span>
                        <img src="<?php echo $match['teams']['away']['logo']; ?>" width="30">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
