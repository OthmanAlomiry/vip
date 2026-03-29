<?php
// بيانات حسابك في Cloudinary
$cloud_name = "dc5xrlhge"; 
$api_key = "257341821972327";
$api_secret = "CV1xiqMRuDCm0ueCjBhGnsVZ8ss";

if (isset($_POST["submit"])) {
    $file = $_FILES['fileToUpload']['tmp_name'];

    // رابط الرفع (تم ضبطه ليرفع أي نوع ملف تلقائياً)
    $url = "https://api.cloudinary.com/v1_1/$cloud_name/auto/upload";

    // تجهيز البيانات
    $data = [
        'file'          => new CURLFile($file),
        'upload_preset' => 'ml_default', // تأكد أنك فعلت هذا الخيار في إعدادات Cloudinary كما شرحت لك سابقاً
        'api_key'       => $api_key,
    ];

    // إرسال الطلب عبر CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $result = json_decode($response, true);
    curl_close($ch);

    // عرض النتيجة للمستخدم
    echo "<html><body style='background:#121212; color:white; font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh;'>";
    echo "<div style='background:#1e1e1e; padding:30px; border-radius:15px; text-align:center; border: 1px solid #333;'>";
    
    if (isset($result['secure_url'])) {
        echo "<h2 style='color:#4CAF50;'>✅ تم الرفع بنجاح!</h2>";
        echo "<p>رابط الملف الدائم:</p>";
        echo "<input type='text' value='".$result['secure_url']."' style='width:100%; padding:10px; background:#000; color:#00ff00; border:none; border-radius:5px;' readonly><br><br>";
        echo "<a href='".$result['secure_url']."' target='_blank' style='background:#6200ee; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>فتح الملف الآن</a>";
    } else {
        echo "<h2 style='color:#f44336;'>❌ فشل الرفع</h2>";
        echo "<p>السبب: " . ($result['error']['message'] ?? 'تأكد من إعداد Upload Preset في Cloudinary') . "</p>";
        echo "<a href='index.php' style='color:#aaa;'>العودة للمحاولة مرة أخرى</a>";
    }
    
    echo "</div></body></html>";
}
?>
