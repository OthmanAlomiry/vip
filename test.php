<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9"; 
// لاحظ أن الـ Host مختلف قليلاً في هذا الـ API
$host = "free-api-live-football-data.p.rapidapi.com"; 

function getMatches($apiKey, $host) {
    $curl = curl_init();
    
    // الرابط الصحيح لجلب مباريات اليوم (الـ API المجاني الذي تشترك به)
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://free-api-live-football-data.p.rapidapi.com/football-current-matches",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: $host",
            "x-rapidapi-key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

$data = getMatches($apiKey, $host);

// للفحص: إذا لم تظهر مباريات، اطبع الرد لتعرف السبب
if (empty($data['response'])) {
    echo "الرد من الـ API: <pre>";
    print_r($data);
    echo "</pre>";
}
?>
