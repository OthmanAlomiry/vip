<?php
// 1. بيانات البوت والـ ID الخاص بك
$botToken = "8663411481:AAExc2PmgStALcN_qg9cNqi_vTpdiBT4GFg";
$chatId = "8497361514"; 

if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // 2. رابط إرسال المستندات لتليجرام
    $url = "https://api.telegram.org/bot$botToken/sendDocument";

    // 3. تجهيز الملف للإرسال
    $post_fields = [
        'chat_id'  => $chatId,
        'document' => new CURLFile($file, null, $fileName),
        'caption'  => "✅ تم رفع ملف جديد من موقعك: $fileName"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch);
    $result = json_decode($response, true);
    curl_close($ch);

    // 4. تنسيق النتيجة للمستخدم
    echo "<html><body style='background:#0f0f0f; color:#ffffff; font-family:sans-serif; text-align:center; padding-top:100px;'>";
    echo "<div style='display:inline-block; background:#1a1a1a; padding:40px; border-radius:20px; border: 1px solid #333;'>";
    
    if (isset($result['ok']) && $result['ok']) {
        echo "<h1 style='color:#00ff88;'>🚀 تم الرفع بنجاح!</h1>";
        echo "<p style='font-size:18px;'>تفقد تطبيق تليجرام الآن، ستجد الملف وصلك.</p>";
        echo "<a href='index.php' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#6200ee; color:white; text-decoration:none; border-radius:8px;'>رفع ملف آخر</a>";
    } else {
        echo "<h1 style='color:#ff4444;'>❌ فشل الرفع</h1>";
        echo "<p>السبب: " . ($result['description'] ?? 'خطأ في الاتصال') . "</p>";
        echo "<a href='index.php' style='color:#888;'>العودة للمحاولة</a>";
    }
    
    echo "</div></body></html>";
}
?>
