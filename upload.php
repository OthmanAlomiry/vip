<?php
if (isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // رفع الملف لـ Catbox
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
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200 && strpos($response, 'https://') !== false) {
        // --- تحديث العداد العالمي عند النجاح من السيرفر مباشرة ---
        // استبدل 'd-service-pro-unique-key' بأي كلمة سر خاصة بك
        $countUrl = "https://api.countapi.xyz/hit/d-service-pro-v1/uploads";
        @file_get_contents($countUrl); 
        // -------------------------------------------------------
        
        echo trim($response);
    } else {
        echo "خطأ: " . strip_tags($response);
    }
}
?>
