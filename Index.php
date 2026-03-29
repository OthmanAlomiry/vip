<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رفع ملفات - Render</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; background: #121212; color: white; }
        .upload-box { border: 2px dashed #444; padding: 30px; border-radius: 10px; display: inline-block; }
        input[type="file"] { margin: 20px 0; }
        button { background: #6200ee; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="upload-box">
        <h2>اختر ملفاً لرفعه</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <br>
            <button type="submit" name="submit">رفع الملف الآن</button>
        </form>
    </div>
</body>
</html>
