<?php
if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // رابط الرفع لخدمة Catbox
    $url = "https://catbox.moe/user/api.php";

    $post_fields = [
        'reqtype' => 'fileupload',
        'fileToUpload' => new CURLFile($file, null, $fileName)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // إعدادات إضافية لضمان العمل على Render
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // انتظار الاتصال 30 ثانية
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // تعريف السيرفر كمتصفح

    $response = curl_exec($ch);
    $error = curl_error($ch); // جلب نص الخطأ إن وجد
    curl_close($ch);

    // التحقق من النتيجة
    if (strpos($response, 'https://') !== false) {
        $downloadLink = trim($response);
        
        // حفظ في الـ LocalStorage والعودة
        echo "
        <script>
            let history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            history.push({ name: '$fileName', url: '$downloadLink', date: new Date().toLocaleString() });
            localStorage.setItem('uploadHistory', JSON.stringify(history));
            window.location.href = 'index.php?status=success';
        </script>";
    } else {
        // في حال فشل الرفع، سنعرض رسالة توضح السبب بدلاً من "حدث خطأ" فقط
        echo "<html><body style='background:#121212; color:white; text-align:center; padding-top:50px; font-family:sans-serif;'>";
        echo "<h2 style='color:#ff4444;'>❌ فشل الرفع</h2>";
        echo "<p>رد السيرفر: " . htmlspecialchars($response) . "</p>";
        if($error) echo "<p>خطأ تقني: $error</p>";
        echo "<br><a href='index.php' style='color:#03dac6;'>العودة للمحاولة</a>";
        echo "</body></html>";
    }
} else {
    header("Location: index.php");
}
?>
