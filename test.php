<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9";
$host = "free-api-live-football-data.p.rapidapi.com";

function getMatches($apiKey, $host) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://free-api-live-football-data.p.rapidapi.com/football-get-all-matches",
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

$data = getMatches($apiKey, $host);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { background: #121212; color: white; font-family: sans-serif; text-align: center; padding: 20px; }
        .card { background: #1e1e1e; margin: 10px auto; padding: 15px; border-radius: 10px; max-width: 500px; border: 1px solid #333; }
        .status { color: #ffcc00; font-size: 0.8em; }
        .debug { background: #000; color: #0f0; text-align: left; padding: 10px; font-family: monospace; }
    </style>
</head>
<body>

    <h2>⚽ نتائج مباريات اليوم</h2>

    <?php 
    // التأكد من وجود رسالة خطأ بخصوص عدد الطلبات
    if (isset($data['message']) && strpos($data['message'], 'quota') !== false) {
        echo "<div class='card' style='border-color: red;'>";
        echo "⚠️ انتهت حصة الطلبات المجانية (100 طلب) لهذا الشهر.";
        echo "</div>";
    } 
    elseif (!empty($data['response']['matches'])) {
        foreach ($data['response']['matches'] as $match) {
            echo "<div class='card'>";
            echo "<div><strong>{$match['home_team_name']}</strong> {$match['score']} <strong>{$match['away_team_name']}</strong></div>";
            echo "<div class='status'>{$match['league_name']} - {$match['status']}</div>";
            echo "</div>";
        }
    } else {
        echo "<p>لا توجد مباريات حالياً في النظام.</p>";
    }
    ?>

    <hr>
    <div class="debug">
        <p>فحص الرد الخام:</p>
        <pre><?php print_r($data); ?></pre>
    </div>
</body>
</html>
