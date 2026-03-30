<?php
// تأكد أن السيرفر يستقبل الملف
if (isset($_FILES['fileToUpload'])) {
    
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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // إذا نجح الرفع (يرجع رابط يبدأ بـ https)
    if ($httpCode == 200 && strpos($response, 'https://') !== false) {
        // نعيد الرابط فقط كما يطلبه كود الـ JavaScript الجديد
        echo trim($response);
    } else {
        // في حال الفشل نعيد رسالة الخطأ
        echo "خطأ من السيرفر: " . strip_tags($response);
    }
} else {
    echo "لا يوجد ملف مختار";
}
?>
