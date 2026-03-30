<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مركز الرفع الذكي | Smart Upload</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg: #0f172a;
            --card: #1e293b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: white;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* صندوق الرفع الاحترافي */
        .container {
            width: 100%;
            max-width: 500px;
            background: var(--card);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }

        h2 { color: #f8fafc; margin-bottom: 25px; font-weight: 600; }

        .drop-zone {
            border: 2px dashed #475569;
            padding: 40px 20px;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
        }

        .drop-zone:hover { border-color: var(--primary); background: rgba(99, 102, 241, 0.05); }

        input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0; left: 0;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon { font-size: 40px; color: var(--primary); margin-bottom: 10px; }

        button {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            transition: 0.3s;
        }

        button:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4); }

        /* جدول الملفات المحفوظة */
        .history-section {
            width: 100%;
            max-width: 800px;
            background: var(--card);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .history-header {
            padding: 15px 20px;
            background: rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table { width: 100%; border-collapse: collapse; text-align: right; }
        th, td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        th { background: rgba(0,0,0,0.2); color: #94a3b8; font-size: 14px; }
        
        .copy-btn {
            background: #334155;
            color: #cbd5e1;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .copy-btn:hover { background: var(--primary); color: white; }

        .file-link { color: var(--primary); text-decoration: none; font-size: 14px; }
        .file-link:hover { text-decoration: underline; }

        .empty-msg { padding: 30px; color: #64748b; font-style: italic; }
    </style>
</head>
<body>

    <div class="container">
        <h2><i class="fas fa-cloud-upload-alt"></i> ارفع ملفك الآن</h2>
        
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="drop-zone">
                <i class="fas fa-file-export upload-icon"></i>
                <p id="file-name">اسحب الملف هنا أو اضغط للاختيار</p>
                <input type="file" name="fileToUpload" id="fileToUpload" required onchange="updateFileName()">
            </div>
            <button type="submit" name="submit">ابدأ الرفع الآمن</button>
        </form>
    </div>

    <div class="history-section">
        <div class="history-header">
            <span><i class="fas fa-history"></i> ملفاتك المرفوعة سابقاً</span>
            <button onclick="clearHistory()" style="width: auto; padding: 5px 10px; background: #ef4444; font-size: 12px; margin: 0;">مسح السجل</button>
        </div>
        <table id="historyTable">
            <thead>
                <tr>
                    <th>اسم الملف</th>
                    <th>الرابط المباشر</th>
                    <th>أدوات</th>
                </tr>
            </thead>
            <tbody id="historyBody">
                </tbody>
        </table>
        <div id="emptyMsg" class="empty-msg">لا توجد ملفات مرفوعة حالياً.</div>
    </div>

    <script>
        // عرض اسم الملف المختار
        function updateFileName() {
            const input = document.getElementById('fileToUpload');
            const nameDisplay = document.getElementById('file-name');
            nameDisplay.innerText = input.files[0] ? input.files[0].name : "اسحب الملف هنا أو اضغط للاختيار";
        }

        // وظيفة جلب وعرض التاريخ من LocalStorage
        function loadHistory() {
            const history = JSON.parse(localStorage.getItem('myUploads') || '[]');
            const body = document.getElementById('historyBody');
            const msg = document.getElementById('emptyMsg');

            if (history.length === 0) {
                msg.style.display = 'block';
                body.innerHTML = '';
                return;
            }

            msg.style.display = 'none';
            body.innerHTML = history.reverse().map((item, index) => `
                <tr>
                    <td>${item.name}</td>
                    <td><a href="${item.url}" target="_blank" class="file-link">${item.url.substring(0, 30)}...</a></td>
                    <td>
                        <button class="copy-btn" onclick="copyLink('${item.url}')">نسخ</button>
                    </td>
                </tr>
            `).join('');
        }

        // وظيفة نسخ الرابط
        function copyLink(url) {
            navigator.clipboard.writeText(url);
            alert('تم نسخ الرابط إلى الحافظة!');
        }

        // مسح التاريخ
        function clearHistory() {
            if(confirm('هل أنت متأكد من مسح سجل الروابط؟')) {
                localStorage.removeItem('myUploads');
                loadHistory();
            }
        }

        // تحميل التاريخ عند فتح الصفحة
        window.onload = loadHistory;
    </script>
</body>
</html>
