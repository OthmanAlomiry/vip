<?php
if (isset($_POST["submit"]) && isset($_FILES['fileToUpload'])) {
    
    $file = $_FILES['fileToUpload']['tmp_name'];
    $fileName = $_FILES['fileToUpload']['name'];

    // نستخدم خدمة Catbox لأنها تعطي رابطاً مباشراً وسهلة جداً
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
    curl_close($ch);

    if (strpos($response, 'https://') !== false) {
        $downloadLink = trim($response);
        
        // كود سحري لحفظ الرابط في متصفح المستخدم ثم العودة للصفحة الرئيسية
        echo "
        <script>
            let history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            history.push({ name: '$fileName', url: '$downloadLink', date: new Date().toLocaleString() });
            localStorage.setItem('uploadHistory', JSON.stringify(history));
            window.location.href = 'index.php?status=success';
        </script>";
    } else {
        echo "حدث خطأ: " . $response;
    }
}
?>
