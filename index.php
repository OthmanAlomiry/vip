<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الرفع السحابي</title>
    <style>
        body { background: #121212; color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: #1e1e1e; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); text-align: center; width: 350px; }
        h2 { margin-bottom: 20px; color: #bb86fc; }
        input[type="file"] { margin: 20px 0; display: block; width: 100%; }
        button { background: #03dac6; color: #000; border: none; padding: 12px 25px; font-weight: bold; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        button:hover { background: #018786; }
    </style>
</head>
<body>
    <div class="card">
        <h2>رفع ملف جديد</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" required>
            <button type="submit" name="submit">ابدأ الرفع السحابي</button>
        </form>
        <p style="font-size: 12px; color: #666; margin-top: 20px;">الملفات تُحفظ بشكل دائم على Cloudinary</p>
    </div>
</body>
</html>
