<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; // مفتاحك من الصورة
$host = "free-api-live-football-data.p.rapidapi.com"; // الهوست الصحيح

function getMatches($apiKey, $host) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        // هذا هو الرابط الذي سيعمل معك لجلب كافة مباريات اليوم
        CURLOPT_URL => "https://free-api-live-football-data.p.rapidapi.com/football-get-all-matches",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: $host",
            "x-rapidapi-key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) return null;
    return json_decode($response, true);
}

$data = getMatches($apiKey, $host);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>مباريات اليوم</title>
    <style>
        body { background-color: #121212; color: white; font-family: sans-serif; text-align: center; }
        .match-card { background: #1e1e1e; margin: 10px; padding: 15px; border-radius: 8px; border: 1px solid #333; }
        .league-name { color: #ffcc00; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>نتائج مباريات اليوم ⚽</h1>
    
    <?php if (isset($data['response']['matches']) && !empty($data['response']['matches'])): ?>
        <?php foreach ($data['response']['matches'] as $match): ?>
            <div class="match-card">
                <div class="league-name"><?php echo $match['league_name']; ?></div>
                <div>
                    <strong><?php echo $match['home_team_name']; ?></strong> 
                    <span style="color: #00ff00; padding: 0 10px;"><?php echo $match['score']; ?></span> 
                    <strong><?php echo $match['away_team_name']; ?></strong>
                </div>
                <div style="font-size: 0.8em; color: #888;"><?php echo $match['status']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لا توجد مباريات جارية حالياً أو استهلكت حد الطلبات المجاني.</p>
    <?php endif; ?>
</body>
</html>
