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
            padding: 20px 20px 120px 20px; 
            overflow-x: hidden;
            position: relative;
        }

        /* الخلفية المتحركة */
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

        .features-header { text-align: center; margin-bottom: 30px; z-index: 1; }
        .features-header h1 { 
            font-size: clamp(1.5rem, 5vw, 2.2rem); 
            background: linear-gradient(to right, #fff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card { 
            background: var(--card-bg); 
            backdrop-filter: blur(12px);
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
            transition: 0.4s;
            background: rgba(255,255,255,0.03);
        }
        .file-input-wrapper:hover { border-color: var(--primary); background: rgba(187, 134, 252, 0.08); }

        button { 
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #000; border: none; padding: 16px; font-weight: 800; border-radius: 14px; 
            cursor: pointer; transition: 0.3s; width: 100%; font-size: 1.1rem;
        }
        button:disabled { opacity: 0.6; }

        .progress-container {
            display: none; margin-top: 25px; background: rgba(255,255,255,0.1);
            border-radius: 20px; height: 10px; overflow: hidden;
        }
        #progress-bar {
            width: 0%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s;
        }

        /* العداد السحابي */
        .upload-counter {
            margin-top: 25px; font-size: 13px; color: var(--secondary);
            background: rgba(255, 255, 255, 0.05); padding: 10px 20px;
            border-radius: 50px; display: inline-flex; align-items: center; gap: 10px;
            border: 1px solid var(--glass-border);
        }

        .history-container {
            width: 100%; max-width: 500px; background: var(--card-bg);
            backdrop-filter: blur(10px); border-radius: 24px; padding: 25px;
            margin-top: 40px; border: 1px solid var(--glass-border); z-index: 1;
        }
        .history-item {
            background: rgba(255,255,255,0.03); padding: 15px; border-radius: 15px;
            margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;
        }
        .preview-box { width: 40px; height: 40px; border-radius: 8px; margin-left: 10px; overflow: hidden; background: #333; display: flex; align-items: center; justify-content: center; }
        .preview-box img { width: 100%; height: 100%; object-fit: cover; }

        .social-footer {
            margin-top: 50px; display: flex; gap: 20px; z-index: 10;
            background: var(--card-bg); padding: 15px 30px; border-radius: 50px;
            border: 1px solid var(--glass-border); backdrop-filter: blur(10px);
        }
        .social-footer a { font-size: 1.5rem; transition: 0.3s; }
        .social-footer a:hover { transform: translateY(-5px); }

        #qr-modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 100; justify-content: center; align-items: center;
        }
        .qr-content { background: white; padding: 20px; border-radius: 20px; text-align: center; color: black; }
    </style>
</head>
<body>

    <div class="bg-animate">
        <div class="shape" style="width: 300px; height: 300px; top: -100px; left: -100px;"></div>
        <div class="shape" style="width: 250px; height: 250px; bottom: 10%; right: -50px;"></div>
    </div>

    <div class="features-header">
        <h1>الخدمة الرقمية لرفع الملفات</h1>
        <p><i class="fas fa-bolt"></i> رابط مباشر • <i class="fas fa-eye-slash"></i> بدون إعلانات • <i class="fas fa-user-shield"></i> آمن</p>
    </div>

    <div class="card">
        <form id="upload-form">
            <div class="file-input-wrapper" onclick="document.getElementById('file-input').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size: 50px; color: var(--primary);"></i>
                <div id="file-name">اسحب الملف هنا أو اضغط للاختيار</div>
                <input type="file" id="file-input" name="fileToUpload" style="display: none;" onchange="showName()">
            </div>
            <button type="button" id="upload-btn" onclick="startUpload()">ابدأ الرفع السحابي</button>
            <div class="progress-container" id="prog-cont">
                <div id="progress-bar"></div>
            </div>
            <div id="percent" style="font-size: 12px; margin-top: 5px; color: var(--secondary);"></div>
        </form>

        <div class="upload-counter">
            <i class="fas fa-rocket"></i>
            <span>إجمالي الرفوعات: </span>
            <img src="https://api.countapi.xyz/visual/hit/d-service-pro-final/uploads?color=03dac6&font_size=14" alt="counter">
        </div>
    </div>

    <div class="history-container" id="historyBox" style="display: none;">
        <div class="history-title" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
            <span><i class="fas fa-history"></i> ملفاتك الأخيرة</span>
            <button onclick="clearHistory()" style="background:none; border:1px solid #f85149; color:#f85149; border-radius:8px; cursor:pointer; padding:2px 8px;">مسح</button>
        </div>
        <div id="historyList"></div>
    </div>

    <div class="social-footer">
        <a href="https://snapchat.com/t/HFoklmi4" target="_blank" style="color:#FFFC00"><i class="fab fa-snapchat"></i></a>
        <a href="https://t.me/d_s_pro" target="_blank" style="color:#0088cc"><i class="fab fa-telegram"></i></a>
        <a href="https://wa.me/966505571164" target="_blank" style="color:#25D366"><i class="fab fa-whatsapp"></i></a>
        <a href="https://x.com/d_service_pro?s=21" target="_blank" style="color:#fff"><i class="fab fa-twitter"></i></a>
    </div>

    <div id="qr-modal" onclick="this.style.display='none'">
        <div class="qr-content" onclick="event.stopPropagation()">
            <h3>كود QR للتحميل</h3>
            <div id="qrcode"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024, sizes = ['Bytes', 'KB', 'MB', 'GB'], i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function showName() {
            const input = document.getElementById('file-input');
            if (input.files.length > 0) {
                document.getElementById('file-name').innerHTML = `<strong>${input.files[0].name}</strong><br>${formatBytes(input.files[0].size)}`;
            }
        }

        function startUpload() {
            const fileInput = document.getElementById('file-input');
            if (fileInput.files.length === 0) return alert("اختر ملفاً!");

            const formData = new FormData();
            formData.append("fileToUpload", fileInput.files[0]);

            const xhr = new XMLHttpRequest();
            const btn = document.getElementById('upload-btn');
            const progCont = document.getElementById('prog-cont');
            const progBar = document.getElementById('progress-bar');

            btn.disabled = true; btn.innerHTML = 'جاري الرفع...';
            progCont.style.display = "block";

            xhr.upload.addEventListener("progress", (e) => {
                const percent = Math.round((e.loaded / e.total) * 100);
                progBar.style.width = percent + "%";
                document.getElementById('percent').innerText = percent + "%";
            });

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response.startsWith("https")) {
                        saveToHistory(fileInput.files[0].name, response, formatBytes(fileInput.files[0].size));
                        alert("✅ تم بنجاح!");
                        location.reload(); 
                    } else {
                        alert("❌ فشل: " + response);
                        btn.disabled = false; btn.innerText = "ابدأ الرفع";
                    }
                }
            };
            xhr.open("POST", "upload.php", true);
            xhr.send(formData);
        }

        function saveToHistory(name, url, size) {
            let history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            history.push({ name: name, url: url, size: size, time: new Date().toLocaleTimeString('ar-SA') });
            localStorage.setItem('uploadHistory', JSON.stringify(history));
        }

        function showQR(url) {
            const qrDiv = document.getElementById('qrcode');
            qrDiv.innerHTML = ""; new QRCode(qrDiv, { text: url, width: 150, height: 150 });
            document.getElementById('qr-modal').style.display = 'flex';
        }

        function displayHistory() {
            const history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            if (history.length > 0) {
                document.getElementById('historyBox').style.display = 'block';
                document.getElementById('historyList').innerHTML = history.reverse().map(item => `
                    <div class="history-item">
                        <div style="display:flex; align-items:center; max-width:65%;">
                            <div class="preview-box">${item.name.match(/\.(jpg|jpeg|png|gif|webp)$/i) ? `<img src="${item.url}">` : '<i class="fas fa-file"></i>'}</div>
                            <div style="overflow:hidden; font-size:12px;">
                                <div style="white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">${item.name}</div>
                                <span style="color:var(--secondary); font-size:10px;">${item.size} • ${item.time}</span>
                            </div>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <a href="${item.url}" target="_blank" style="color:var(--secondary)"><i class="fas fa-external-link-alt"></i></a>
                            <span onclick="showQR('${item.url}')" style="color:var(--primary); cursor:pointer;"><i class="fas fa-qrcode"></i></span>
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
