<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; 
$host = "free-api-live-football-data.p.rapidapi.com"; 

function getFootballData($apiKey, $host) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        // هذا هو الرابط الصحيح والمباشر لجلب مباريات اليوم في هذا الـ API
        CURLOPT_URL => "https://free-api-live-football-data.p.rapidapi.com/football-get-livescores",
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

$data = getFootballData($apiKey, $host);

if (isset($data['response']['live'])) {
    echo "<h2>المباريات المتاحة الآن:</h2>";
    foreach ($data['response']['live'] as $match) {
        echo "<div style='background:#f4f4f4; margin:10px; padding:15px; border-radius:8px;'>";
        echo "<b>" . $match['home_name'] . "</b> " . $match['score'] . " <b>" . $match['away_name'] . "</b>";
        echo "<br><small>الدوري: " . $match['league_name'] . "</small>";
        echo "</div>";
    }
} else {
    echo "الرد من الـ API (للفحص): <pre>";
    print_r($data);
    echo "</pre>";
}
?>
