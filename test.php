<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; 
$host = "api-football-v1.p.rapidapi.com";

function getMatchesByDate($leagueId, $date, $apiKey, $host) {
    $curl = curl_init();
    // جربنا موسم 2025 لأنه الموسم الحالي (2025-2026)
    $url = "https://api-football-v1.p.rapidapi.com/v3/fixtures?league=$leagueId&season=2025&date=$date";

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: $host",
            "x-rapidapi-key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// جلب تواريخ (أمس، اليوم، غداً)
$dates = [
    "أمس" => date("Y-m-d", strtotime("-1 day")),
    "اليوم" => date("Y-m-d"),
    "غداً" => date("Y-m-d", strtotime("+1 day"))
];

$allMatches = [];
foreach ($dates as $label => $day) {
    $res = getMatchesByDate(307, $day, $apiKey, $host); // 307 للدوري السعودي
    if (!empty($res['response'])) {
        $allMatches[$label] = $res['response'];
    }
}
?>

<?php foreach ($dates as $label => $day): ?>
    <h3 style="color: #ffcc00; border-bottom: 1px solid #444; padding: 10px;"><?= $label ?> (<?= $day ?>)</h3>
    <?php if (isset($allMatches[$label])): ?>
        <?php foreach ($allMatches[$label] as $m): ?>
            <div style="background: #222; margin: 5px; padding: 10px; border-radius: 5px;">
                <span><?= $m['teams']['home']['name'] ?></span> 
                <b style="color: #00ff00;"> <?= $m['goals']['home'] ?> - <?= $m['goals']['away'] ?> </b>
                <span><?= $m['teams']['away']['name'] ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #666; padding-right: 15px;">لا توجد مباريات مسجلة في هذا التاريخ.</p>
    <?php endif; ?>
<?php endforeach; ?>
