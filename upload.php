<?php
if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // رابط الرفع لخدمة Catbox
    $url = "https://catbox.moe/user/api.php";

    // تجهيز البيانات لإرسالها
    $post_fields = [
        'reqtype' => 'fileupload',
        'fileToUpload' => new CURLFile($file, null, $fileName)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // تجاوز التحقق من SSL لضمان العمل على Render
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch); // سيعيد الرابط المباشر كـ نص (Text)
    curl_close($ch);

    echo "<html><body style='background:#0f0f0f; color:#ffffff; font-family:sans-serif; text-align:center; padding-top:100px;'>";
    echo "<div style='display:inline-block; background:#1a1a1a; padding:40px; border-radius:20px; border: 1px solid #333; max-width:90%;'>";

    // التحقق إذا كانت النتيجة تبدأ بـ http (يعني نجح الرفع)
    if (strpos($response, 'https://') !== false) {
        $downloadLink = trim($response);
        echo "<h1 style='color:#00ff88;'>🚀 تم الرفع بنجاح!</h1>";
        echo "<p style='font-size:18px;'>الرابط المباشر للملف هو:</p>";
        echo "<input type='text' value='$downloadLink' style='width:100%; padding:15px; background:#000; color:#00ff00; border:1px solid #333; border-radius:8px; text-align:center;' readonly>";
        echo "<br><br>";
        echo "<a href='$downloadLink' target='_blank' style='display:inline-block; padding:12px 25px; background:#6200ee; color:white; text-decoration:none; border-radius:8px; font-weight:bold;'>فتح الملف الآن</a>";
    } else {
        echo "<h1 style='color:#ff4444;'>❌ فشل الرفع</h1>";
        echo "<p>حدث خطأ: " . htmlspecialchars($response) . "</p>";
    }
    
    echo "<br><br><a href='index.php' style='color:#888; text-decoration:none;'>← رفع ملف آخر</a>";
    echo "</div></body></html>";
} else {
    header("Location: index.php");
}
?>
