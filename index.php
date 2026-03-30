<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمة الرقمية | رفع سريع</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #bb86fc;
            --secondary: #03dac6;
            --bg: #0f111a;
            --card: #161b22;
            --text-muted: #8b949e;
        }

        body { 
            background: var(--bg); 
            color: #c9d1d9; 
            font-family: 'Segoe UI', Roboto, sans-serif; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }

        /* عبارة التميز */
        .features-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .features-header h1 { color: white; margin-bottom: 5px; font-size: 24px; }
        .features-header p { color: var(--secondary); font-size: 14px; font-weight: bold; }

        .card { 
            background: var(--card); 
            padding: 30px; 
            border-radius: 24px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.5); 
            text-align: center; 
            width: 100%;
            max-width: 420px; 
            border: 1px solid rgba(255,255,255,0.1);
        }

        .file-input-wrapper {
            border: 2px dashed #30363d;
            padding: 30px 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: 0.3s;
            background: rgba(255,255,255,0.02);
        }
        .file-input-wrapper:hover { border-color: var(--primary); background: rgba(187, 134, 252, 0.05); }

        #file-name { font-size: 14px; color: var(--text-muted); margin-top: 10px; }

        button { 
            background: var(--primary); 
            color: #000; 
            border: none; 
            padding: 15px; 
            font-weight: bold; 
            border-radius: 12px; 
            cursor: pointer; 
            transition: 0.3s; 
            width: 100%;
            font-size: 16px;
        }
        button:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(187, 134, 252, 0.3); }
        button:disabled { background: #444; cursor: not-allowed; }

        /* شريط التحميل */
        .progress-container {
            display: none;
            margin-top: 20px;
            background: #30363d;
            border-radius: 10px;
            height: 12px;
            overflow: hidden;
        }
        #progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.2s;
        }
        #percent { font-size: 12px; color: var(--secondary); margin-top: 5px; font-weight: bold; }

        /* السجل */
        .history-container {
            width: 100%;
            max-width: 500px;
            background: var(--card);
            border-radius: 20px;
            padding: 20px;
            margin-top: 30px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .history-title { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #30363d; padding-bottom: 15px; margin-bottom: 15px; }
        .history-item {
            background: #0d1117;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .actions a, .copy-btn { color: var(--secondary); text-decoration: none; cursor: pointer; border: none; background: none; font-size: 13px; font-family: inherit; }
        .clear-btn { background: none; border: 1px solid #f85149; color: #f85149; padding: 5px 10px; border-radius: 8px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>

    <div class="features-header">
        <h1>الخدمة الرقمية لرفع الملفات</h1>
        <p>برابط مباشر • بدون إعلانات • بدون تسجيل دخول</p>
    </div>

    <div class="card">
        <form id="upload-form">
            <div class="file-input-wrapper" onclick="document.getElementById('file-input').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: var(--primary);"></i>
                <div id="file-name">اضغط هنا لاختيار الملف</div>
                <input type="file" id="file-input" name="fileToUpload" style="display: none;" onchange="showName()">
            </div>
            
            <button type="button" id="upload-btn" onclick="startUpload()">ابدأ الرفع السحابي</button>
            
            <div class="progress-container" id="prog-cont">
                <div id="progress-bar"></div>
            </div>
            <div id="percent"></div>
        </form>
    </div>

    <div class="history-container" id="historyBox" style="display: none;">
        <div class="history-title">
            <span><i class="fas fa-list-ul"></i> ملفاتك الأخيرة</span>
            <button class="clear-btn" onclick="clearHistory()">مسح</button>
        </div>
        <div id="historyList"></div>
    </div>

    <script>
        function showName() {
            const input = document.getElementById('file-input');
            document.getElementById('file-name').innerText = input.files[0].name;
        }

        function startUpload() {
            const fileInput = document.getElementById('file-input');
            if (fileInput.files.length === 0) { alert("من فضلك اختر ملفاً!"); return; }

            const formData = new FormData();
            formData.append("fileToUpload", fileInput.files[0]);
            formData.append("submit", "true");

            const xhr = new XMLHttpRequest();
            const btn = document.getElementById('upload-btn');
            const progCont = document.getElementById('prog-cont');
            const progBar = document.getElementById('progress-bar');
            const percentTxt = document.getElementById('percent');

            // تفعيل شريط التحميل وتعطيل الزر
            btn.disabled = true;
            btn.innerText = "جاري الرفع...";
            progCont.style.display = "block";

            // مراقبة التقدم
            xhr.upload.addEventListener("progress", (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progBar.style.width = percent + "%";
                    percentTxt.innerText = percent + "% مكتمل";
                }
            });

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // استقبال الرد (يجب أن يعيد PHP الرابط فقط)
                    const response = xhr.responseText.trim();
                    if (response.startsWith("https")) {
                        saveToHistory(fileInput.files[0].name, response);
                        alert("تم الرفع بنجاح!");
                        location.reload(); 
                    } else {
                        alert("فشل الرفع: " + response);
                        btn.disabled = false;
                        btn.innerText = "ابدأ الرفع السحابي";
                    }
                }
            };

            xhr.open("POST", "upload.php", true);
            xhr.send(formData);
        }

        function saveToHistory(name, url) {
            let history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            history.push({ name: name, url: url });
            localStorage.setItem('uploadHistory', JSON.stringify(history));
        }

        function displayHistory() {
            const history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            if (history.length > 0) {
                document.getElementById('historyBox').style.display = 'block';
                document.getElementById('historyList').innerHTML = history.reverse().map(item => `
                    <div class="history-item">
                        <div style="font-size: 13px; max-width: 60%; overflow: hidden;">${item.name}</div>
                        <div class="actions">
                            <a href="${item.url}" target="_blank">فتح</a> | 
                            <span class="copy-btn" onclick="navigator.clipboard.writeText('${item.url}'); alert('تم النسخ!');">نسخ</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        function clearHistory() { localStorage.removeItem('uploadHistory'); location.reload(); }
        window.onload = displayHistory;
    </script>
</body>
</html>
