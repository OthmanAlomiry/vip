<?php
// منع توقف السكربت بسبب طول وقت التنفيذ
set_time_limit(0);
// مسح الذاكرة المؤقتة للإخراج ليظهر لك الرقم فوراً دون انتظار نهاية السكربت
ob_implicit_flush(true);
ob_end_flush();

$baseUrl = "http://ibo.lynxiptv.com/live/276983819492/Dm00SSnT73/";
$extension = ".m3u8";

echo "<h2>نتائج الفحص (الأرقام الصحيحة فقط):</h2>";
echo "<div id='results' style='font-family: monospace; line-height: 1.6;'>";

$foundCount = 0;

for ($i = 0; $i <= 9999; $i++) {
    $url = $baseUrl . $i . $extension;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true); // طلب الرأس فقط لتوفير البيانات
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1); // مهلة ثانية واحدة لكل محاولة لزيادة السرعة
    
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // إذا كان الرد 200 (موجودة) أو 302 (تحويل) فهي تعمل
    if ($httpCode == 200 || $httpCode == 302) {
        $foundCount++;
        // طباعة الرقم الصحيح فوراً في المتصفح
        echo "<span style='color: white; background: green; padding: 2px 8px; margin: 2px; border-radius: 4px; display: inline-block;'>";
        echo "رقم الشغال: <b>$i</b>";
        echo "</span> ";
        
        // حفظ الرقم في ملف نصي للرجوع إليه لاحقاً
        file_put_contents('valid_numbers.txt', $i . PHP_EOL, FILE_APPEND);
    }

    // إضافة "نبض" بسيط لتعرف أن السكربت لا يزال يعمل (اختياري)
    if ($i % 100 == 0) {
        echo "<br><small style='color:gray;'>تم فحص $i رقم حتى الآن...</small><br>";
    }
}

echo "</div>";
echo "<h3>اكتمل الفحص! إجمالي القنوات الشغالة: $foundCount</h3>";
?>