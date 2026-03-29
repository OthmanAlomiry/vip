<?php
if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // 1. الحصول على أفضل سيرفر متاح للرفع من GoFile
    $getServer = json_decode(file_get_contents('https://api.gofile.io/getServer'), true);
    $server = $getServer['data']['server'];

    // 2. تجهيز عملية الرفع للسيرفر المختار
    $url = "https://$server.gofile.io/uploadFile";

    $post_fields = [
        'file' => new CURLFile($file, null, $fileName)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $result = json_decode($response, true);
    curl_close($ch);

    // 3. تنسيق الصفحة لعرض الرابط
    echo "<html><body style='background:#0f0f0f; color:#ffffff; font-family:sans-serif; text-align:center; padding-top:100px;'>";
    echo "<div style='display:inline-block; background:#1a1a1a; padding:40px; border-radius:20px; border: 1px solid #333; max-width:90%;'>";
    
    if (isset($result['status']) && $result['status'] == 'ok') {
        $downloadPage = $result['data']['downloadPage']; // هذا هو رابط التحميل
        
        echo "<h1 style='color:#00ff88;'>✅ تم الرفع بنجاح!</h1>";
        echo "<p style='font-size:18px;'>رابط تحميل الملف هو:</p>";
        echo "<input type='text' value='$downloadPage' style='width:100%; padding:15px; background:#000; color:#00ff00; border:1px solid #333; border-radius:8px; text-align:center;' readonly>";
        echo "<br><br>";
        echo "<a href='$downloadPage' target='_blank' style='display:inline-block; padding:12px 25px; background:#6200ee; color:white; text-decoration:none; border-radius:8px; font-weight:bold;'>انتقل لصفحة التحميل</a>";
        echo "<br><br><a href='index.php' style='color:#888; text-decoration:none; font-size:14px;'>← رفع ملف آخر</a>";
    } else {
        echo "<h1 style='color:#ff4444;'>❌ فشل الرفع</h1>";
        echo "<p>عذراً، حدث خطأ أثناء الاتصال بسيرفر الرفع.</p>";
        echo "<a href='index.php' style='color:#888;'>العودة للمحاولة</a>";
    }
    
    echo "</div></body></html>";
} else {
    header("Location: index.php");
}
?>
