<?php
// إعدادات الـ API من الصورة التي أرفقتها
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; // مفتاحك الخاص
$host = "api-football-v1.p.rapidapi.com";

// دالة لجلب البيانات باستخدام cURL
function getMatches($leagueId, $apiKey, $host) {
    $curl = curl_init();
    $today = date("Y-m-d");

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/fixtures?league=$leagueId&season=2025&date=$today",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: $host",
            "x-rapidapi-key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// معرفات الدوريات (307 للدوري السعودي، 39 للدوري الإنجليزي الممتاز)
$saudiMatches = getMatches(307, $apiKey, $host);
$euroMatches = getMatches(39, $apiKey, $host);

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تجربة جلب المباريات - D-Service</title>
    <style>
        body { font-family: sans-serif; background: #1a1a1a; color: white; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .league-title { background: #333; padding: 10px; border-radius: 5px; margin-top: 20px; color: #ffcc00; }
        .match-card { background: #222; border: 1px solid #444; padding: 15px; margin: 10px 0; display: flex; justify-content: space-between; align-items: center; border-radius: 8px; }
        .team { display: flex; align-items: center; gap: 10px; width: 40%; }
        .team img { width: 30px; height: 30px; }
        .score { font-weight: bold; font-size: 1.2em; color: #00ff00; }
        .time { font-size: 0.8em; color: #aaa; }
    </style>
</head>
<body>

<div class="container">
    <h1>نتائج مباريات اليوم ⚽</h1>

    <h2 class="league-title">🇸🇦 الدوري السعودي (Roshn League)</h2>
    <?php if (!empty($saudiMatches['response'])): ?>
        <?php foreach ($saudiMatches['response'] as $m): ?>
            <div class="match-card">
                <div class="team">
                    <img src="<?= $m['teams']['home']['logo'] ?>" alt="">
                    <span><?= $m['teams']['home']['name'] ?></span>
                </div>
                <div class="score">
                    <?= $m['goals']['home'] ?? '?' ?> - <?= $m['goals']['away'] ?? '?' ?>
                    <div class="time"><?= date("H:i", strtotime($m['fixture']['date'])) ?></div>
                </div>
                <div class="team" style="justify-content: flex-end;">
                    <span><?= $m['teams']['away']['name'] ?></span>
                    <img src="<?= $m['teams']['away']['logo'] ?>" alt="">
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لا توجد مباريات مجدولة اليوم في الدوري السعودي.</p>
    <?php endif; ?>

    <h2 class="league-title">🏴󠁧󠁢󠁥󠁮󠁧󠁿 الدوري الإنجليزي (Premier League)</h2>
    <?php if (!empty($euroMatches['response'])): ?>
        <?php foreach ($euroMatches['response'] as $m): ?>
            <div class="match-card">
                <div class="team">
                    <img src="<?= $m['teams']['home']['logo'] ?>" alt="">
                    <span><?= $m['teams']['home']['name'] ?></span>
                </div>
                <div class="score">
                    <?= $m['goals']['home'] ?? '?' ?> - <?= $m['goals']['away'] ?? '?' ?>
                    <div class="time"><?= date("H:i", strtotime($m['fixture']['date'])) ?></div>
                </div>
                <div class="team" style="justify-content: flex-end;">
                    <span><?= $m['teams']['away']['name'] ?></span>
                    <img src="<?= $m['teams']['away']['logo'] ?>" alt="">
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لا توجد مباريات مجدولة اليوم في الدوري الإنجليزي.</p>
    <?php endif; ?>

</div>

</body>
</html>
