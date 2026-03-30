<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الرفع الذكي | Smart Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #bb86fc;
            --secondary: #03dac6;
            --bg: #121212;
            --card: #1e1e1e;
        }

        body { 
            background: var(--bg); 
            color: white; 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }

        /* تنسيق بطاقة الرفع */
        .card { 
            background: var(--card); 
            padding: 30px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
            text-align: center; 
            width: 100%;
            max-width: 400px; 
            margin-bottom: 30px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        h2 { margin-bottom: 25px; color: var(--primary); }

        .file-input-wrapper {
            border: 2px dashed #444;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-input-wrapper:hover { border-color: var(--secondary); background: rgba(3, 218, 198, 0.05); }

        input[type="file"] { margin-bottom: 10px; width: 100%; cursor: pointer; }

        button { 
            background: var(--secondary); 
            color: #000; 
            border: none; 
            padding: 14px 30px; 
            font-weight: bold; 
            border-radius: 10px; 
            cursor: pointer; 
            transition: 0.3s; 
            width: 100%;
            font-size: 16px;
        }

        button:hover { background: #018786; transform: translateY(-2px); }

        /* تنسيق سجل الملفات */
        .history-container {
            width: 100%;
            max-width: 600px;
            background: var(--card);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .history-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .history-list { list-style: none; padding: 0; margin: 0; }

        .history-item {
            background: #252525;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .file-info { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 60%; }

        .actions a { color: var(--secondary); text-decoration: none; margin-left: 10px; }
        
        .copy-btn {
            background: #444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 11px;
        }

        .copy-btn:hover { background: var(--primary); color: black; }

        .clear-btn { background: none; border: 1px solid #ff4444; color: #ff4444; padding: 4px 8px; border-radius: 5px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>

    <div class="card">
        <h2><i class="fas fa-cloud-upload-alt"></i> رفع ملف جديد</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="file-input-wrapper">
                <input type="file" name="fileToUpload" required>
            </div>
            <button type="submit" name="submit">ابدأ الرفع السحابي</button>
        </form>
        <p style="font-size: 11px; color: #888; margin-top: 15px;">يتم تخزين روابطك محلياً في المتصفح</p>
    </div>

    <div class="history-container" id="historyBox" style="display: none;">
        <div class="history-title">
            <span><i class="fas fa-history"></i> آخر الملفات المرفوعة</span>
            <button class="clear-btn" onclick="clearHistory()">مسح السجل</button>
        </div>
        <div id="historyList" class="history-list"></div>
    </div>

    <script>
        // وظيفة لعرض السجل من localStorage
        function displayHistory() {
            const history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            const container = document.getElementById('historyBox');
            const list = document.getElementById('historyList');

            if (history.length > 0) {
                container.style.display = 'block';
                list.innerHTML = history.map((item, index) => `
                    <div class="history-item">
                        <div class="file-info">
                            <i class="fas fa-file"></i> ${item.name}
                        </div>
                        <div class="actions">
                            <a href="${item.url}" target="_blank">فتح</a>
                            <button class="copy-btn" onclick="copyToClipboard('${item.url}')">نسخ الرابط</button>
                        </div>
                    </div>
                `).reverse().join(''); // عرض الأحدث أولاً
            } else {
                container.style.display = 'none';
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('تم نسخ الرابط!');
            });
        }

        function clearHistory() {
            if (confirm('هل تريد مسح سجل الروابط؟')) {
                localStorage.removeItem('uploadHistory');
                displayHistory();
            }
        }

        // تشغيل العرض عند فتح الصفحة
        window.onload = displayHistory;
    </script>
</body>
</html>
