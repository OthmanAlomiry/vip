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

        /* تنسيق عداد الرفع الحقيقي */
        .upload-counter {
            margin-top: 20px;
            font-size: 12px;
            color: var(--secondary);
            background: rgba(3, 218, 198, 0.05);
            padding: 8px 15px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(3, 218, 198, 0.2);
            font-weight: bold;
        }

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

        .preview-box {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            margin-left: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            overflow: hidden;
            flex-shrink: 0;
        }
        .preview-box img { width: 100%; height: 100%; object-fit: cover; }
        .preview-box i { font-size: 18px; }

        .file-size-badge {
            background: rgba(3, 218, 198, 0.1);
            color: var(--secondary);
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 9px;
            margin-top: 4px;
            display: inline-block;
        }

        .actions { display: flex; gap: 8px; align-items: center; }
        .actions a, .copy-btn, .qr-btn { 
            color: var(--secondary); 
            text-decoration: none; 
            cursor: pointer; 
            font-weight: 600;
            font-size: 0.8rem;
        }
        .qr-btn { color: var(--primary); }

        .social-footer {
            margin-top: 50px;
            display: flex;
            gap: 20px;
            z-index: 10;
            background: var(--card-bg);
            padding: 15px 30px;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }
        .social-footer a {
            color: white;
            font-size: 1.5rem;
            transition: 0.3s ease;
        }
        .social-footer a.snapchat:hover { color: #FFFC00; transform: translateY(-5px); }
        .social-footer a.telegram:hover { color: #0088cc; transform: translateY(-5px); }
        .social-footer a.whatsapp:hover { color: #25D366; transform: translateY(-5px); }
        .social-footer a.twitter:hover { color: #fff; transform: translateY(-5px); }

        #qr-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }
        .qr-content {
            background: white;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            color: black;
        }
        .qr-content h3 { margin-bottom: 10px; font-size: 14px; }

        .clear-btn { background: rgba(248, 81, 73, 0.1); border: 1px solid #f85149; color: #f85149; padding: 6px 14px; border-radius: 10px; cursor: pointer; font-size: 0.8rem; }

        @media (max-width: 480px) {
            body { padding: 15px 15px 100px 15px; }
            .card { border-radius: 20px; }
            .history-container { margin-top: 25px; }
            .social-footer { gap: 15px; padding: 10px 20px; }
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

        <div class="upload-counter">
            <i class="fas fa-file-upload"></i>
            <span>إجمالي عمليات الرفع: <span id="total-uploads">...</span></span>
        </div>
    </div>

    <div class="history-container" id="historyBox" style="display: none;">
        <div class="history-title">
            <span><i class="fas fa-history"></i> ملفاتك المرفوعه تظهر فقط لك</span>
            <button class="clear-btn" onclick="clearHistory()">مسح السجل</button>
        </div>
        <div id="historyList"></div>
    </div>

    <div class="social-footer">
        <a href="https://snapchat.com/t/HFoklmi4" target="_blank" class="snapchat"><i class="fab fa-snapchat"></i></a>
        <a href="https://t.me/d_s_pro" target="_blank" class="telegram"><i class="fab fa-telegram"></i></a>
        <a href="https://wa.me/966505571164" target="_blank" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
        <a href="https://x.com/d_service_pro?s=21" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
    </div>

    <div id="qr-modal" onclick="this.style.display='none'">
        <div class="qr-content" onclick="event.stopPropagation()">
            <h3>كود QR للتحميل</h3>
            <div id="qrcode"></div>
            <p style="font-size: 10px; margin-top: 10px; color: #666;">اضغط في أي مكان للإغلاق</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        // مفتاح العداد الخاص بك (فريد لموقعك)
        const COUNT_API_URL = "https://api.countapi.xyz/hit/d-service.pro/uploads";

        async function updateUploadCounter(increase = false) {
            try {
                // إذا كان increase صحيحاً سنقوم بزيادة العداد، وإلا سنجلب القيمة فقط
                const endpoint = increase ? COUNT_API_URL : "https://api.countapi.xyz/get/d-service.pro/uploads";
                const response = await fetch(endpoint);
                const data = await response.json();
                document.getElementById('total-uploads').innerText = data.value || 0;
            } catch (e) {
                document.getElementById('total-uploads').innerText = "0";
            }
        }

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(decimals)) + ' ' + sizes[i];
        }

        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            const images = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
            const videos = ['mp4', 'mov', 'avi', 'mkv'];
            const audio = ['mp3', 'wav', 'ogg', 'm4a'];
            if (images.includes(ext)) return 'IMAGE';
            if (videos.includes(ext)) return '<i class="fas fa-video" style="color:#ff4444"></i>';
            if (audio.includes(ext)) return '<i class="fas fa-headphones" style="color:#03dac6"></i>';
            return '<i class="far fa-file-alt"></i>';
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
            const fileName = fileInput.files[0].name;
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

            xhr.onreadystatechange = async function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response.startsWith("https")) {
                        // هنا السحر: عند نجاح الرفع نقوم بزيادة العداد العالمي
                        await updateUploadCounter(true);
                        saveToHistory(fileName, response, fileSize);
                        alert("✅ تم الرفع بنجاح!");
                        location.reload(); 
                    } else {
                        alert("❌ فشل الرفع: " + response);
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

        function showQR(url) {
            const modal = document.getElementById('qr-modal');
            const qrDiv = document.getElementById('qrcode');
            qrDiv.innerHTML = "";
            new QRCode(qrDiv, { text: url, width: 150, height: 150 });
            modal.style.display = 'flex';
        }

        function displayHistory() {
            const history = JSON.parse(localStorage.getItem('uploadHistory') || '[]');
            if (history.length > 0) {
                document.getElementById('historyBox').style.display = 'block';
                document.getElementById('historyList').innerHTML = history.reverse().map(item => {
                    const iconOrImg = getFileIcon(item.name);
                    const previewHtml = iconOrImg === 'IMAGE' 
                        ? `<div class="preview-box"><img src="${item.url}" alt="preview"></div>`
                        : `<div class="preview-box">${iconOrImg}</div>`;
                    return `
                        <div class="history-item">
                            <div style="display:flex; align-items:center; max-width:60%;">
                                ${previewHtml}
                                <div style="overflow:hidden;">
                                    <div style="font-size: 12px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">${item.name}</div>
                                    <span class="file-size-badge">${item.size} • ${item.time}</span>
                                </div>
                            </div>
                            <div class="actions">
                                <a href="${item.url}" target="_blank">فتح</a>
                                <span class="qr-btn" onclick="showQR('${item.url}')"><i class="fas fa-qrcode"></i></span>
                                <span class="copy-btn" onclick="copy('${item.url}')">نسخ</span>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        function copy(url) {
            navigator.clipboard.writeText(url);
            alert('تم نسخ الرابط بنجاح!');
        }

        function clearHistory() {
            if(confirm('هل أنت متأكد؟')) {
                localStorage.removeItem('uploadHistory');
                location.reload();
            }
        }

        // جلب قيمة العداد عند فتح الصفحة
        window.onload = function() {
            displayHistory();
            updateUploadCounter(false);
        };
    </script>
</body>
</html>
