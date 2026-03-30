<?php
if (isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

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
        // --- تحديث العداد المحلي عند النجاح ---
        $counterFile = 'counter.txt';
        if (file_exists($counterFile)) {
            $currentCount = (int)file_get_contents($counterFile);
            file_put_contents($counterFile, $currentCount + 1);
        }
        // ------------------------------------
        echo trim($response);
    } else {
        echo "خطأ: " . strip_tags($response);
    }
}
?>
