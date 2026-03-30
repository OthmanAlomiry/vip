<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمة الرقمية | مركز الرفع الاحترافي</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #bb86fc;
            --secondary: #03dac6;
            --bg: #0a0c14;
            --card-bg: rgba(22, 27, 34, 0.8);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text: #e6edf3;
        }

        * { box-sizing: border-box; }

        body { 
            background-color: var(--bg); 
            color: var(--text); 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* --- الخلفية المتحركة --- */
        .bg-animate {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: radial-gradient(circle at center, #161b22 0%, #0a0c14 100%);
        }

        .shape {
            position: absolute;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            filter: blur(80px);
            border-radius: 50%;
            opacity: 0.15;
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(100px, 100px) scale(1.2); }
        }

        /* --- المحتوى الرئيسي --- */
        .features-header {
            text-align: center;
            margin-bottom: 30px;
            z-index: 1;
        }
        .features-header h1 { 
            font-size: clamp(1.5rem, 5vw, 2.2rem); 
            margin-bottom: 10px;
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .features-header p { color: var(--secondary); font-size: 0.9rem; letter-spacing: 1px; }

        .card { 
            background: var(--card-bg); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: clamp(20px, 5vw, 40px);
            border-radius: 28px; 
            box-shadow: 0 25px 50px rgba(0,0,0,0.5); 
            text-align: center; 
            width: 100%;
            max-width: 450px; 
            border: 1px solid var(--glass-border);
            z-index: 1;
        }

        .file-input-wrapper {
            border: 2px dashed rgba(255,255,255,0.2);
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 25px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255,255,255,0.03);
        }
        .file-input-wrapper:hover { 
            border-color: var(--primary); 
            background: rgba(187, 134, 252, 0.08);
            transform: scale(1.02);
        }

        #file-name { font-size: 0.9rem; color: #8b949e; margin-top: 15px; word-break: break-all; }

        button { 
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #000; 
            border: none; 
            padding: 16px; 
            font-weight: 800; 
            border-radius: 14px; 
            cursor: pointer; 
            transition: 0.3s; 
            width: 100%;
            font-size: 1.1rem;
            text-transform: uppercase;
        }
        button:hover:not(:disabled) { 
            transform: translateY(-3px); 
            box-shadow: 0 12px 24px rgba(3, 218, 198, 0.3); 
        }
        button:disabled { opacity: 0.6; cursor: not-allowed; }

        .progress-container {
            display: none;
            margin-top: 25px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            height: 10px;
            overflow: hidden;
        }
        #progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            box-shadow: 0 0 15px var(--secondary);
            transition: width 0.3s ease;
        }
        #percent { font-size: 0.85rem; color: var(--secondary); margin-top: 8px; font-weight: bold; }

        .history-container {
            width: 100%;
            max-width: 500px;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 25px;
            margin-top: 40px;
            border: 1px solid var(--glass-border);
            z-index: 1;
        }
        .history-title { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--glass-border); padding-bottom: 15px; margin-bottom: 20px; }
        .history-item {
            background: rgba(255,255,255,0.03);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid transparent;
            transition: 0.3s;
        }
        .history-item:hover { border-color: var(--glass-border); background: rgba(255,255,255,0.05); }

        .file-size-badge {
            background: rgba(3, 218, 198, 0.1);
            color: var(--secondary);
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 10px;
            margin-right: 5px;
        }

        .actions a, .copy-btn { 
            color: var(--secondary); 
            text-decoration: none; 
            cursor: pointer; 
            font-weight: 600;
            font-size: 0.85rem;
        }
        .clear-btn { background: rgba(248, 81, 73, 0.1); border: 1px solid #f85149; color: #f85149; padding: 6px 14px; border-radius: 10px; cursor: pointer; font-size: 0.8rem; }

        @media (max-width: 480px) {
            body { padding: 15px; }
            .card { border-radius: 20px; }
            .history-container { margin-top: 25px; }
        }
    </style>
</head>
<body>

    <div class="bg-animate">
        <div class="shape" style="width: 300px; height: 300px; top: -100px; left: -100px;"></div>
        <div class="shape" style="width: 250px; height: 250px; bottom: 10%; right: -50px; animation-delay: -5s;"></div>
    </div>

    <div class="features-header">
        <h1>الخدمة الرقمية لرفع الملفات</h1>
        <p><i class="fas fa-bolt"></i> رابط مباشر • <i class="fas fa-eye-slash"></i> بدون إعلانات • <i class="fas fa-user-shield"></i> آمن</p>
    </div>

    <div class="card">
        <form id="upload-form">
            <div class="file-input-wrapper" onclick="document.getElementById('file-input').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size: 50px; color: var(--primary); filter: drop-shadow(0 0 10px var(--primary));"></i>
                <div id="file-name">اسحب الملف هنا أو اضغط للاختيار</div>
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
            <span><i class="fas fa-history"></i> ملفاتك المرفوعه تظهر فقط لك</span>
            <button class="clear-btn" onclick="clearHistory()">مسح السجل</button>
        </div>
        <div id="historyList"></div>
    </div>

    <script>
        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function showName() {
            const input = document.getElementById('file-input');
            if (input.files.length > 0) {
                const size = formatBytes(input.files[0].size);
                document.getElementById('file-name').innerHTML = `<strong>تم اختيار:</strong><br>${input.files[0].name}<br><span style="font-size:11px; color:var(--secondary)">الحجم: ${size}</span>`;
            }
        }

        function startUpload() {
            const fileInput = document.getElementById('file-input');
            if (fileInput.files.length === 0) { alert("من فضلك اختر ملفاً أولاً!"); return; }

            const fileSize = formatBytes(fileInput.files[0].size);
            const formData = new FormData();
            formData.append("fileToUpload", fileInput.files[0]);

            const xhr = new XMLHttpRequest();
            const btn = document.getElementById('upload-btn');
            const progCont = document.getElementById('prog-cont');
            const progBar = document.getElementById('progress-bar');
            const percentTxt = document.getElementById('percent');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الرفع...';
            progCont.style.display = "block";

            xhr.upload.addEventListener("progress", (e) => {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progBar.style.width = percent + "%";
                    percentTxt.innerText = percent + "% مكتمل";
                }
            });

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const response = xhr.responseText.trim();
                        if (response.startsWith("https")) {
                            saveToHistory(fileInput.files[0].name, response, fileSize);
                            alert("✅ تم الرفع بنجاح!");
                            location.reload(); 
                        } else {
                            alert("❌ فشل الرفع: " + response);
                            resetBtn(btn, progCont);
                        }
                    } else {
                        alert("❌ حدث خطأ في الاتصال بالسيرفر.");
                        resetBtn(btn, progCont);
                    }
                }
            };

            xhr.open("POST", "upload.php", true);
            xhr.send(formData);
        }

        function resetBtn(btn, prog) {
            btn.disabled = false;
            btn.innerText = "ابدأ الرفع السحابي";
            prog.style.display = "none";
        }

        function saveToHistory(name, url, size) {
            let history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            history.push({ name: name, url: url, size: size, time: new Date().toLocaleTimeString('ar-SA') });
            localStorage.setItem('uploadHistory', JSON.stringify(history));
        }

        function displayHistory() {
            const history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            if (history.length > 0) {
                document.getElementById('historyBox').style.display = 'block';
                document.getElementById('historyList').innerHTML = history.reverse().map(item => `
                    <div class="history-item">
                        <div style="font-size: 13px; max-width: 55%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                            <i class="far fa-file-alt"></i> ${item.name} 
                            <span class="file-size-badge">${item.size || 'N/A'}</span>
                        </div>
                        <div class="actions">
                            <a href="${item.url}" target="_blank">فتح</a> | 
                            <span class="copy-btn" onclick="copy('${item.url}')">نسخ</span>
                        </div>
                    </div>
                `).join('');
            }
        }

        function copy(url) {
            navigator.clipboard.writeText(url);
            alert('تم نسخ الرابط بنجاح!');
        }

        function clearHistory() {
            if(confirm('هل أنت متأكد من مسح جميع الروابط؟')) {
                localStorage.removeItem('uploadHistory');
                location.reload();
            }
        }
        window.onload = displayHistory;
    </script>
</body>
</html>
