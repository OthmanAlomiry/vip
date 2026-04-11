<?php
// إعدادات الاتصال بناءً على اشتراكك في الصورة الأخيرة
$apiKey = "b09af4bf6a130dc461d8c8a549df779f"; // مفتاحك الجديد من الصورة رقم 23
$host = "v3.football.api-sports.io"; // الهوست الخاص بـ API-Sports

function getSaudiMatches($apiKey, $host) {
    $curl = curl_init();
    $today = date("Y-m-d"); // تاريخ اليوم: 2026-04-11

    curl_setopt_array($curl, [
        // طلب مباريات الدوري السعودي (ID: 307) لموسم 2025 بتاريخ اليوم
        CURLOPT_URL => "https://v3.football.api-sports.io/fixtures?league=307&season=2025&date=$today",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-apisports-key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

$data = getSaudiMatches($apiKey, $host);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اختبار جلب مباريات اليوم</title>
    <style>
        body { background-color: #121212; color: white; font-family: Arial, sans-serif; padding: 20px; }
        .match { background: #1e1e1e; padding: 15px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #333; }
        .status { color: #ffcc00; font-size: 0.8em; }
        .score { color: #00ff00; font-weight: bold; margin: 0 15px; }
        .debug-box { background: #000; color: #0f0; padding: 10px; font-family: monospace; font-size: 12px; overflow: auto; max-height: 300px; border: 1px solid #0f0; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>نتائج اختبار الدوري السعودي ⚽</h1>

    <?php if (!empty($data['response'])): ?>
        <?php foreach ($data['response'] as $fixture): ?>
            <div class="match">
                <strong><?php echo $fixture['teams']['home']['name']; ?></strong>
                <span class="score">
                    <?php echo $fixture['goals']['home'] ?? 0; ?> - <?php echo $fixture['goals']['away'] ?? 0; ?>
                </span>
                <strong><?php echo $fixture['teams']['away']['name']; ?></strong>
                <div class="status">الحالة: <?php echo $fixture['fixture']['status']['long']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>لم يتم العثور على مباريات اليوم في الدوري السعودي عبر الـ API.</p>
    <?php endif; ?>

    <hr>
    <h3>بيانات الفحص (Debug Data):</h3>
    <div class="debug-box">
        <p>مفتاح الـ API المستخدم: <?php echo $apiKey; ?></p>
        <p>تاريخ اليوم المبحوث عنه: <?php echo date("Y-m-d"); ?></p>
        <p>الرد الكامل من السيرفر:</p>
        <pre><?php print_r($data); ?></pre>
    </div>

</body>
</html>
