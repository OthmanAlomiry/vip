<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; // مفتاحك من الصورة رقم 5
$host = "free-api-live-football-data.p.rapidapi.com";

function getLiveMatches($apiKey, $host) {
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

$data = getLiveMatches($apiKey, $host);

// عرض النتائج
if (!empty($data['response']['matches'])) {
    foreach ($data['response']['matches'] as $match) {
        echo "<div style='background:#1e1e1e; color:white; margin:10px; padding:15px; border-radius:8px;'>";
        echo "<b>" . $match['home_team_name'] . "</b> " . $match['score'] . " <b>" . $match['away_team_name'] . "</b>";
        echo "<br><small>البطولة: " . $match['league_name'] . "</small>";
        echo "</div>";
    }
} else {
    echo "لا توجد مباريات حالياً أو استهلكت الـ 100 طلب المجانية.";
}
?>
