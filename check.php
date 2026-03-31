<?php
// إعدادات البيئة لضمان استمرار العمل
set_time_limit(0); 
ob_implicit_flush(true);
ob_end_flush();

$baseUrl = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/";
$extension = ".m3u8";

// تحديد نطاق البحث في الـ 60 ألف
$start = 60000;
$end   = 69999;

echo "<body style='background:#121212; color:#e0e0e0; font-family:sans-serif;'>";
echo "<h2>🔎 جاري فحص نطاق الـ 60 ألف (6xxxx)</h2>";
echo "<p>الأرقام التي تظهر باللون الأخضر هي القنوات الشغالة فعلياً:</p>";
echo "<hr>";

$countFound = 0;

for ($i = $start; $i <= $end; $i++) {
    $url = $baseUrl . $i . $extension;

    // استخدام cURL مع إعدادات متقدمة لتجنب الحظر
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1); // فحص سريع (ثانية واحدة)
    
    // إيهام السيرفر أننا برنامج VLC أو جهاز Android
    curl_setopt($ch, CURLOPT_USERAGENT, "VLC/3.0.11 LibVLC/3.0.11");

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // إذا استجاب السيرفر بـ 200 فهذا يعني أن الرقم صحيح
    if ($httpCode == 200) {
        $countFound++;
        echo "<div style='background:#2e7d32; color:#fff; padding:10px; margin:5px; border-radius:5px; display:inline-block;'>";
        echo "✅ تم العثور: <b>$i</b>";
        echo "</div>";
        
        // حفظ الأرقام في ملف نصي فوراً
        file_put_contents('working_6xxxx.txt', $i . " - " . $url . PHP_EOL, FILE_APPEND);
    }

    // تحديث الحالة كل 100 رقم لتعرف أين وصل الفحص
    if ($i % 100 == 0) {
        echo "<div style='color:#777; font-size:12px;'>جاري فحص الرقم: $i ...</div>";
        // دفع المخرجات للمتصفح فوراً
        flush();
    }
}

echo "<hr><h3>✅ اكتمل الفحص! تم العثور على $countFound قناة في هذا النطاق.</h3>";
echo "</body>";
?>