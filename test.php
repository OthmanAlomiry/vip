<?php
$apiKey = "49e271c73amsh02ca0a4d3f5b237p145598jsn7c1cee0f8ec9";
$host = "free-api-live-football-data.p.rapidapi.com";

function getMatches($apiKey, $host) {
    $curl = curl_init();
    
    // الرابط الذي يعمل حالياً في هذا الـ API هو 'football-get-all-leagues' 
    // أو البحث عن مباريات دوري محدد لجلب النتائج
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://free-api-live-football-data.p.rapidapi.com/football-get-all-leagues",
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
        .debug-box { background: #000; color: #0f0; text-align: left; padding: 15px; border: 1px solid #0f0; overflow: auto; }
    </style>
</head>
<body>
    <h2>فحص الدوريات والمباريات المتاحة</h2>
    
    <div class="debug-box">
        <pre><?php print_r($data); ?></pre>
    </div>
</body>
</html>
