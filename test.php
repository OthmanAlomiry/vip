<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; 
$host = "free-api-live-football-data.p.rapidapi.com"; 

function getLiveMatches($apiKey, $host) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        // الرابط الصحيح المتوافق مع اشتراكك
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

// عرض النتائج للتجربة
echo "<h2>مباريات اليوم المتاحة:</h2>";
if (!empty($data['response']['matches'])) {
    foreach ($data['response']['matches'] as $match) {
        echo "<div style='padding:10px; border-bottom:1px solid #ccc;'>";
        echo $match['home_team_name'] . " VS " . $match['away_team_name'];
        echo " | النتيجة: " . $match['score'];
        echo "</div>";
    }
} else {
    echo "لم يتم العثور على مباريات. الرد الكامل من السيرفر: <pre>";
    print_r($data);
    echo "</pre>";
}
?>
