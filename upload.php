<?php
if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // 1. الحصول على السيرفر المتاح باستخدام الطريقة الجديدة
    $ch = curl_init('https://api.gofile.io/contents/getUploadServer');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $serverData = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (isset($serverData['data']['server'])) {
        $server = $serverData['data']['server'];
        $url = "https://$server.gofile.io/contents/uploadfile";

        // 2. عملية الرفع
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

        // 3. عرض النتيجة
        echo "<html><body style='background:#0f0f0f; color:#ffffff; font-family:sans-serif; text-align:center; padding-top:100px;'>";
        echo "<div style='display:inline-block; background:#1a1a1a; padding:40px; border-radius:20px; border: 1px solid #333; max-width:90%;'>";

        if (isset($result['status']) && $result['status'] == 'ok') {
            $downloadPage = $result['data']['downloadPage'];
            echo "<h1 style='color:#00ff88;'>✅ تم الرفع بنجاح!</h1>";
            echo "<p style='font-size:18px;'>رابط تحميل الملف هو:</p>";
            echo "<input type='text' value='$downloadPage' style='width:100%; padding:15px; background:#000; color:#00ff00; border:1px solid #333; border-radius:8px; text-align:center;' readonly>";
            echo "<br><br>";
            echo "<a href='$downloadPage' target='_blank' style='display:inline-block; padding:12px 25px; background:#6200ee; color:white; text-decoration:none; border-radius:8px; font-weight:bold;'>انتقل لصفحة التحميل</a>";
        } else {
            echo "<h1 style='color:#ff4444;'>❌ فشل الرفع</h1>";
            echo "<p>السبب: " . ($result['status'] ?? 'خطأ في السيرفر') . "</p>";
        }
        echo "<br><br><a href='index.php' style='color:#888;'>← رفع ملف آخر</a>";
        echo "</div></body></html>";
    } else {
        echo "عذراً، فشل الحصول على سيرفر متاح حالياً. حاول مجدداً بعد قليل.";
    }
} else {
    header("Location: index.php");
}
?>
