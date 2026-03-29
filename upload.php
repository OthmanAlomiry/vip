<?php
$target_dir = "uploads/";
// التأكد من وجود المجلد، وإن لم يوجد يتم إنشاؤه
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "تم رفع الملف بنجاح: <a href='$target_file' style='color:cyan;'>عرض الملف</a>";
} else {
    echo "عذراً، حدث خطأ أثناء الرفع. تأكد من صلاحيات المجلد.";
}
?>
